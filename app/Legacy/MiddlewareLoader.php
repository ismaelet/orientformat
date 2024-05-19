<?php

namespace App\Legacy;

use Illuminate\Support\Facades\Auth;

class MiddlewareLoader {

	use Singleton;

	private static $middlewares = [];

	private function __construct() {
		$defaultMiddlewareLoader = [
			'public' => function () {
				// dd('public');
				$public = !\App\Legacy\LegacyConfig::getInstance()->hasDatabase ?: \App\Legacy\LegacyDB::find('value FROM config WHERE name = ?', ['public']);

				if (!$public) {
					redirect_old('/offline');
				}
			},

			'not-public' => function () {
				// dd('not-public');
				$public = !\App\Legacy\LegacyConfig::getInstance()->hasDatabase ?: \App\Legacy\LegacyDB::find('value FROM config WHERE name = ?', ['public']);

				if ($public) {
					redirect_old('/');
				}
			},

			'maintenance' => function () {
				// dd('maintenance');
				redirect_old('/maintenance');
			},

			'logged' => function () {
				// dd('logged');
				if (!logged()) {
					redirect_old('/login');
				}
			},

			'not-logged' => function () {
				$config = \App\Legacy\LegacyConfig::getInstance();

				if (!$config->hasDatabase || logged()) {
					redirect_old('/');
				}
			},

			'beginner-review' => function () {
				$reviewId = null;

				if (is_student()) {
					$student = Auth::user()->student;
					$relativeGrade = $student->school_class->grade()->relative_number();
					$startingGrade = $student->school_class->startingGrade;
					$currentGrade = $student->school_class->grade;

					switch (true) {

						case $student->isMiddleSchoolStudent() && $relativeGrade == 3:
							// third middleschool year
							$reviewId = 2;
							break;

						case $student->isHighSchoolStudent() && ($relativeGrade == 1 || $startingGrade == $currentGrade):
							// first higschool year
							$reviewId = 4;
							break;

						case student()->isHighSchoolStudent():
							// other higschool years
							$reviewId = 5;
							break;
					}

					if ($reviewId && !\App\Legacy\LegacyDB::exists('review_results WHERE studentId = ? AND reviewId = ?', [Auth::id(), $reviewId])) {
						redirect_old('/review?id=' . $reviewId);
					}
				}
			},

			'required-email' => function () {
				if (!Auth::user()->email) {
					redirect_old('/add-email');
				}
			}
		];

		foreach ($defaultMiddlewareLoader as $middlewareName => $middlewareFunction) {
			self::add($middlewareName, $middlewareFunction);
		}
	}

	public function add($middlewareName, $middlewareFunction) {
		self::$middlewares[$middlewareName] = $middlewareFunction;

		return $this;
	}

	public function run($middlewareName) {
		$middlewareFunction = self::$middlewares[$middlewareName] ?? null;

		if ($middlewareFunction) {
			$middlewareFunction();
		} else {
			exit('Access denied: ' . $middlewareName);
		}
	}
}
