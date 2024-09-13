<?php

namespace App\Helpers;

use App\Models\Notification;
use App\Models\Schools\SchoolClass;
use Illuminate\Database\Eloquent\Collection;

class SchoolYearHelper {

	const LAST_MIDDLE_SCHOOL_GRADE = 3;
	const LAST_HIGH_SCHOOL_GRADE = 7;

	/**
	 * Update the classes for the new school year
	 */
	public static function newSchoolYear() {
		self::updateGrades();

		// ! This is a temporary fix for the classes that were updated to the wrong grade
		// ! Removing this after the school year 2024/2025 shouldn't give any issue
		self::fixWrongGrades();

		self::setEndedSchoolClasses();

		self::createNotification();
	}

	/**
	 * Update the grade of all classes that weren't on the last grade
	 */
	protected static function updateGrades() {
		$schoolClasses = self::getSchoolClassesInProgress();

		$schoolClasses->each(function ($schoolClass) {
			$currentGrade = $schoolClass->startingGrade + self::getYearsPassed($schoolClass);

			$schoolClass->update([
				'grade' => $currentGrade,
				'year' => self::getCurrentSchoolYear(),
			]);
		});
	}

	/**
	 * Set all classes that have ended the course as ended
	 */
	protected static function setEndedSchoolClasses() {
		$schoolClasses = SchoolClass::where('year', '<', self::getCurrentSchoolYear())->get();

		$schoolClasses->each(function ($schoolClass) {
			$schoolClass->update([
				'ended' => true,
			]);
		});
	}

	/**
	 * Get all school classes that are in progress
	 * 
	 * @return Collection
	 */
	protected static function getSchoolClassesInProgress(): Collection {
		return SchoolClass::where('startingGrade', '<', self::LAST_MIDDLE_SCHOOL_GRADE)
			->orWhereBetween('startingGrade', [
				self::LAST_MIDDLE_SCHOOL_GRADE + 1,
				self::LAST_HIGH_SCHOOL_GRADE
			])
			->get();
	}

	/**
	 * Get the current school year
	 * 
	 * @return int
	 */
	protected static function getCurrentSchoolYear(): int {
		return date('m') >= 9 ? date('Y') : date('Y') - 1;
	}

	/**
	 * Get the amount of years that have passed since the starting year
	 * 
	 * @param SchoolClass $schoolClass
	 */
	protected static function getYearsPassed(SchoolClass $schoolClass): int {
		return self::getCurrentSchoolYear() - $schoolClass->startingYear;
	}

	protected static function createNotification() {
		Notification::create([
			'text' => 'È iniziato un nuovo anno scolastico e abbiamo aggiornato i nominativi delle classi che stanno effettuando il percorso, per riflettere il cambiamento.',
		]);
	}

	/**
	 * Fix the wrong grades of the classes
	 * 
	 * ! This is a temporary fix for the classes that were updated to the wrong grade
	 * ! Removing this after the school year 2024/2025 shouldn't give any issue
	 */
	protected static function fixWrongGrades() {
		$schoolClassesToFix = SchoolClass::where('grade', '>', self::LAST_MIDDLE_SCHOOL_GRADE)
			->where('startingGrade', '<=', self::LAST_MIDDLE_SCHOOL_GRADE)
			->get();

		$schoolClassesToFix->each(function ($schoolClass) {
			$schoolClass->update([
				'grade' => self::LAST_MIDDLE_SCHOOL_GRADE,
				'year' => $schoolClass->startingYear + self::LAST_MIDDLE_SCHOOL_GRADE - $schoolClass->startingGrade,
			]);
		});
	}
}
