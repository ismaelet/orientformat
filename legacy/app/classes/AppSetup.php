<?php

use \Legacy\UserSystem\Teacher;

class AppSetup {
	/**
	 * Templates
	 */
	private static function initializeTemplates() {

		\Legacy\System\Classes\Logic::$dependencies['recap'] = 'main';
		\Legacy\System\Classes\Logic::$dependencies['survey-results'] = 'test';
		\Legacy\System\Classes\Logic::$dependencies['read'] = 'main';
		\Legacy\System\Classes\Logic::$dependencies['dashboard'] = 'main';
		\Legacy\System\Classes\Logic::$dependencies['school-class'] = 'dashboard';
		\Legacy\System\Classes\Logic::$dependencies['school-class-graph'] = 'dashboard';
		\Legacy\System\Classes\Logic::$priorities['survey-results'] = 210;
		\Legacy\System\Classes\Logic::$priorities['recap'] = 60;
		\Legacy\System\Classes\Logic::$priorities['read'] = 70;
		\Legacy\System\Classes\Logic::$priorities['dashboard'] = 60;
		\Legacy\System\Classes\Logic::$priorities['school-class'] = 70;
		\Legacy\System\Classes\Logic::$priorities['school-class-graph'] = 70;



		\Legacy\System\Classes\Logic::$dependencies['test'] = 'main';
		\Legacy\System\Classes\Logic::$dependencies['test-next'] = 'test';
		\Legacy\System\Classes\Logic::$dependencies['survey'] = 'main';
		\Legacy\System\Classes\Logic::$dependencies['student-read'] = 'main';
		\Legacy\System\Classes\Logic::$priorities['test'] = 200;
		\Legacy\System\Classes\Logic::$priorities['test-next'] = 210;
		\Legacy\System\Classes\Logic::$priorities['survey'] = 60;
		\Legacy\System\Classes\Logic::$priorities['student-read'] = 70;
	}

	/**
	 * Middlewares
	 */
	private static function initializeMiddlewares() {
		$middlewares = \Legacy\System\Classes\MiddlewareLoader::getInstance();

		$middlewares->add('active', function () {
			if (!user()->groupId && !user()->status) {
				redirect_old('/wait');
			}
		});

		$middlewares->add('beginner-review', function () {
			$reviewId = null;

			if (!is_teacher()) {
				switch (true) {

					case student()->isInMiddleSchool && student()->schoolClass->relativeGrade == 3:
						// third middleschool year
						$reviewId = 2;
						break;

					case student()->isInHighschool && (student()->schoolClass->relativeGrade == 1 || student()->schoolClass->startingGrade == student()->schoolClass->currentGrade):
						// first higschool year
						$reviewId = 4;
						break;

					case student()->isInHighschool:
						// other higschool years
						$reviewId = 5;
						break;
				}

				if ($reviewId && !\Legacy\System\Classes\LegacyDB::exists('review_results WHERE studentId = ? AND reviewId = ?', [userId(), $reviewId])) {
					redirect_old('/review?id=' . $reviewId);
				}
			}
		});

		$middlewares->add('end-review', function () {
		});

		$middlewares->add('required-email', function () {
			if (!user()->email) {
				redirect_old('/add-email');
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

			if (!$schoolClassId || !\Legacy\System\Classes\LegacyDB::exists(Teacher::TABLE . ' WHERE ' . Teacher::INDEX . ' = ? AND FIND_IN_SET (?, classes)', [teacherId(), $schoolClassId])) {
				redirect_old('/teacher');
			}
		});
	}

	public static function run() {
		self::initializeTemplates();
		self::initializeMiddlewares();
	}
}
