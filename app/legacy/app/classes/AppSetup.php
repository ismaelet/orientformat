<?php

namespace Legacy;

use App\Legacy\LegacyDB;
use App\Legacy\Logic;
use App\Legacy\MiddlewareLoader;
use App\Models\Schools\SchoolClass;
use Legacy\UserSystem\Teacher;

class AppSetup
{
    /**
     * Templates
     */
    private static function initializeTemplates()
    {

        Logic::$dependencies['recap'] = 'main';
        Logic::$dependencies['survey-results'] = 'test';
        Logic::$dependencies['read'] = 'main';
        Logic::$dependencies['dashboard'] = 'main';
        Logic::$dependencies['school-class'] = 'dashboard';
        Logic::$dependencies['school-class-graph'] = 'dashboard';
        Logic::$priorities['survey-results'] = 210;
        Logic::$priorities['recap'] = 60;
        Logic::$priorities['read'] = 70;
        Logic::$priorities['dashboard'] = 60;
        Logic::$priorities['school-class'] = 70;
        Logic::$priorities['school-class-graph'] = 70;

        Logic::$dependencies['test'] = 'main';
        Logic::$dependencies['test-next'] = 'test';
        Logic::$dependencies['survey'] = 'main';
        Logic::$dependencies['student-read'] = 'main';
        Logic::$priorities['test'] = 200;
        Logic::$priorities['test-next'] = 210;
        Logic::$priorities['survey'] = 60;
        Logic::$priorities['student-read'] = 70;
    }

    /**
     * Middlewares
     */
    private static function initializeMiddlewares()
    {
        $middlewares = MiddlewareLoader::getInstance();

        $middlewares->add('active', function () {
            if (! user()->groupId && ! user()->status) {
                redirect_old('/wait');
            }
        });

        $middlewares->add('student', function () {
            if (! islegacy_student()) {
                redirect_old('/');
            }
        });

        $middlewares->add('teacher', function () {
            if (! is_teacher()) {
                redirect_old('/');
            }
        });

        $middlewares->add('administrator', function () {
            if (! is_administrator()) {
                redirect_old('/');
            }
        });

        $middlewares->add('teacherOrAdministrator', function () {
            if (! is_teacher() && ! is_administrator()) {
                redirect_old('/');
            }
        });

        $middlewares->add('class', function () {
            $schoolClassId = null;

            if (isset($_GET['class-id'])) {
                $schoolClassId = $_SESSION['dashboard-schoolClassId'] = $_GET['class-id'];
            } elseif (isset($_SESSION['dashboard-schoolClassId'])) {
                $schoolClassId = $_SESSION['dashboard-schoolClassId'];
            }

            $schoolClass = SchoolClass::find($schoolClassId);

            if (! is_teacher() && ! is_administrator()) {
                redirect_old('/');
            }

            if (is_administrator() && $schoolClass->schoolId != administrator()->school_id) {
                redirect_old('/teacher');
            }

            if (is_teacher()) {
                if (! $schoolClassId || ! LegacyDB::exists(Teacher::TABLE.' WHERE '.Teacher::INDEX.' = ? AND FIND_IN_SET (?, classes)', [teacherId(), $schoolClassId])) {
                    redirect_old('/teacher');
                }
            }
        });
    }

    public static function run()
    {
        self::initializeTemplates();
        self::initializeMiddlewares();
    }
}
