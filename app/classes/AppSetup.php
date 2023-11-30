<?php

use UserSystem\Teacher;

class AppSetup {
	/**
	 * Templates
	 */
	private static function initializeTemplates() {
		Logic::$dependencies['test'] = 'main';
		Logic::$dependencies['test-next'] = 'test';
		Logic::$dependencies['survey'] = 'main';
		Logic::$dependencies['recap'] = 'main';
		Logic::$dependencies['survey-results'] = 'test';
		Logic::$dependencies['read'] = 'main';
		Logic::$dependencies['student-read'] = 'main';
		Logic::$dependencies['dashboard'] = 'main';
		Logic::$dependencies['school-class'] = 'dashboard';
		Logic::$dependencies['school-class-graph'] = 'dashboard';
		Logic::$priorities['test'] = 200;
		Logic::$priorities['test-next'] = 210;
		Logic::$priorities['survey'] = 60;
		Logic::$priorities['survey-results'] = 210;
		Logic::$priorities['recap'] = 60;
		Logic::$priorities['read'] = 70;
		Logic::$priorities['student-read'] = 70;
		Logic::$priorities['dashboard'] = 60;
		Logic::$priorities['school-class'] = 70;
		Logic::$priorities['school-class-graph'] = 70;
	}

	/**
	 * Middlewares
	 */
	private static function initializeMiddlewares() {
		$middlewares = MiddlewareLoader::getInstance();

		$middlewares->add('active', function () {
			if (!user()->groupId && !user()->status) {
				redirect('/wait');
			}
		});

		$middlewares->add('beginner-review', function () {
			$reviewId = null;

			if (!isTeacher()) {
				switch (true) {
						// case student()->isInMiddleSchool && student()->schoolClass->relativeGrade < 3:
						// 	// first and second middleschool year
						// 	$reviewId =  1;
						// 	break;

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

				if ($reviewId && !DB::exists('review_results WHERE studentId = ? AND reviewId = ?', [userId(), $reviewId])) {
					redirect('/review?id=' . $reviewId);
				}
			}
		});

		$middlewares->add('end-review', function () {
		});

		$middlewares->add('required-email', function () {
			if (!user()->email) {
				redirect('/add-email');
			}
		});

		$middlewares->add('student', function () {
			if (!isStudent()) {
				redirect('/');
			}
		});

		$middlewares->add('teacher', function () {
			if (!isTeacher()) {
				redirect('/');
			}
		});

		$middlewares->add('class', function () {
			$schoolClassId = null;

			if (isset($_GET['class-id'])) {
				$schoolClassId = $_SESSION['dashboard-schoolClassId'] = $_GET['class-id'];
			} else if (isset($_SESSION['dashboard-schoolClassId'])) {
				$schoolClassId = $_SESSION['dashboard-schoolClassId'];
			}

			if (!isTeacher()) {
				redirect('/');
			}

			if (!$schoolClassId || !DB::exists(Teacher::TABLE . ' WHERE ' . Teacher::INDEX . ' = ? AND FIND_IN_SET (?, classes)', [teacherId(), $schoolClassId])) {
				redirect('/teacher');
			}
		});
	}

	public static function run() {
		self::initializeTemplates();
		self::initializeMiddlewares();
	}
}
