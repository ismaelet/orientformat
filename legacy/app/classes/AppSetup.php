<?php

use \Legacy\UserSystem\Teacher;

class AppSetup {
	/**
	 * Templates
	 */
	private static function initializeTemplates() {

		\App\Legacy\Logic::$dependencies['recap'] = 'main';
		\App\Legacy\Logic::$dependencies['survey-results'] = 'test';
		\App\Legacy\Logic::$dependencies['read'] = 'main';
		\App\Legacy\Logic::$dependencies['dashboard'] = 'main';
		\App\Legacy\Logic::$dependencies['school-class'] = 'dashboard';
		\App\Legacy\Logic::$dependencies['school-class-graph'] = 'dashboard';
		\App\Legacy\Logic::$priorities['survey-results'] = 210;
		\App\Legacy\Logic::$priorities['recap'] = 60;
		\App\Legacy\Logic::$priorities['read'] = 70;
		\App\Legacy\Logic::$priorities['dashboard'] = 60;
		\App\Legacy\Logic::$priorities['school-class'] = 70;
		\App\Legacy\Logic::$priorities['school-class-graph'] = 70;



		\App\Legacy\Logic::$dependencies['test'] = 'main';
		\App\Legacy\Logic::$dependencies['test-next'] = 'test';
		\App\Legacy\Logic::$dependencies['survey'] = 'main';
		\App\Legacy\Logic::$dependencies['student-read'] = 'main';
		\App\Legacy\Logic::$priorities['test'] = 200;
		\App\Legacy\Logic::$priorities['test-next'] = 210;
		\App\Legacy\Logic::$priorities['survey'] = 60;
		\App\Legacy\Logic::$priorities['student-read'] = 70;
	}

	/**
	 * Middlewares
	 */
	private static function initializeMiddlewares() {
		$middlewares = \App\Legacy\MiddlewareLoader::getInstance();

		$middlewares->add('active', function () {
			if (!user()->groupId && !user()->status) {
				redirect_old('/wait');
			}
		});

		$middlewares->add('student', function () {
			if (!isStudent()) {
				redirect_old('/');
			}
		});

		$middlewares->add('teacher', function () {
			if (!is_teacher()) {
				redirect_old('/');
			}
		});

		$middlewares->add('class', function () {
			$schoolClassId = null;

			if (isset($_GET['class-id'])) {
				$schoolClassId = $_SESSION['dashboard-schoolClassId'] = $_GET['class-id'];
			} else if (isset($_SESSION['dashboard-schoolClassId'])) {
				$schoolClassId = $_SESSION['dashboard-schoolClassId'];
			}

			if (!is_teacher()) {
				redirect_old('/');
			}

			if (!$schoolClassId || !\App\Legacy\LegacyDB::exists(Teacher::TABLE . ' WHERE ' . Teacher::INDEX . ' = ? AND FIND_IN_SET (?, classes)', [teacherId(), $schoolClassId])) {
				redirect_old('/teacher');
			}
		});
	}

	public static function run() {
		self::initializeTemplates();
		self::initializeMiddlewares();
	}
}
