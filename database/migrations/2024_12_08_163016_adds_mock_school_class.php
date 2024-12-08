<?php

use App\Models\Schools\SchoolClass;
use App\Models\User;
use App\Models\User\Student;
use App\Models\User\Teacher;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddsMockSchoolClass extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		$schoolId = 24;
		$referentId = 4719;
		$oldSchoolClass = SchoolClass::find(794);
		$teacher = Teacher::find($referentId);

		// Copy the old school class
		$newSchoolClass = $oldSchoolClass->replicate();
		$newSchoolClass->fill([
			'schoolId' => $schoolId,
			'referentId' => $referentId,
			'letter' => 'Z',
			'code' => substr('-' . $oldSchoolClass->code, 0, 10),
			'ended' => 0,
		]);
		$newSchoolClass->save();

		// Attach the class to the teacher
		$classList = explode(',', $teacher->classes);
		$classList[] = $newSchoolClass->id;
		$teacher->update(['classes' => implode(',', $classList)]);

		// Copy the students
		$oldSchoolClass->students->each(function ($oldStudent) use ($newSchoolClass) {

			// Copy the user
			$oldUser = $oldStudent->user;
			$random = rand(1000, 9999);

			$newUser = User::create([
				'username' => 'studente.test' . $random,
				'email' => 'studente' . $random . '@test.com',
				'password' => $oldUser->password,
				'firstName' => 'Studente',
				'lastName' => 'Test',
			]);

			// Copy the student
			$newStudent = $oldStudent->replicate();
			$newStudent->fill([
				'id' => $newUser->id,
				'userId' => $newUser->id,
				'schoolClassId' => $newSchoolClass->id,
			]);
			$newStudent->save();

			// Copy the advices
			$oldAdvice = $oldStudent->advice;

			if ($oldAdvice) {
				$newAdvice = $oldAdvice->replicate();
				$newAdvice->fill(['userID' => $newUser->id]);
				$newAdvice->save();
			}

			// Copy the student's additional results
			$oldStudent->additional_results->each(function ($additionalResult) use ($newStudent) {
				$additionalResult->replicate()
					->fill(['studentId' => $newStudent->id])
					->save();
			});

			// Copy the student's grade results
			$oldStudent->grade_results->each(function ($gradeResult) use ($newStudent) {
				$gradeResult->replicate()
					->fill(['studentId' => $newStudent->id])
					->save();
			});

			// Copy the student's other results
			$oldStudent->other_results->each(function ($otherResult) use ($newStudent) {
				$otherResult->replicate()
					->fill(['userID' => $newStudent->id])
					->save();
			});

			// Copy the student's permanent results
			$oldStudent->permanent_results->each(function ($permanentResult) use ($newStudent) {
				$permanentResult->replicate()
					->fill(['studentId' => $newStudent->id])
					->save();
			});

			// Copy the student's section results
			$oldStudent->section_results->each(function ($sectionResult) use ($newStudent) {
				$sectionResult->replicate()
					->fill(['studentId' => $newStudent->id])
					->save();
			});

			// Copy the student's condensed section results
			$oldStudent->condensed_section_results->each(function ($condensedSectionResult) use ($newStudent) {
				$condensedSectionResult->replicate()
					->fill(['student_id' => $newStudent->id])
					->save();
			});

			// Copy the student's test results
			$oldStudent->test_results->each(function ($testResult) use ($newStudent) {
				$testResult->replicate()
					->fill(['studentId' => $newStudent->id])
					->save();
			});

			// Copy the student's review results
			$oldStudent->review_results->each(function ($reviewResult) use ($newStudent) {
				$reviewResult->replicate()
					->fill(['studentId' => $newStudent->id])
					->save();
			});
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		$referentId = 4719;
		$newSchoolClasses = SchoolClass::where('referentId', $referentId)
			->where('ended', 0)
			->get();
		$teacher = Teacher::find($referentId);

		// Delete the students
		$newSchoolClasses->each(function ($newSchoolClass) use ($teacher) {
			$newSchoolClass->students->each(function ($student) {

				// Delete the user associated with the student
				if ($student->user) {
					$student->user->forceDelete();
				}

				// Delete the student's advices
				if ($student->advice) {
					$student->advice->forceDelete();
				}

				// Delete the student's additional results
				$student->additional_results->each(function ($additionalResult) {
					$additionalResult->forceDelete();
				});

				// Delete the student's grade results
				$student->grade_results->each(function ($gradeResult) {
					$gradeResult->forceDelete();
				});

				// Delete the student's other results
				$student->other_results->each(function ($otherResult) {
					$otherResult->forceDelete();
				});

				// Delete the student's permanent results
				$student->permanent_results->each(function ($permanentResult) {
					$permanentResult->forceDelete();
				});

				// Delete the student's section results
				$student->section_results->each(function ($sectionResult) {
					$sectionResult->forceDelete();
				});

				// Delete the student's condensed section results
				$student->condensed_section_results->each(function ($condensedSectionResult) {
					$condensedSectionResult->forceDelete();
				});

				// Delete the student's test results
				$student->test_results->each(function ($testResult) {
					$testResult->forceDelete();
				});

				// Delete the student's review results
				$student->review_results->each(function ($reviewResult) {
					$reviewResult->forceDelete();
				});

				// Delete the student
				$student->forceDelete();
			});

			// Detach the class from the teacher
			$classList = explode(',', $teacher->classes);
			$classList = array_diff($classList, [$newSchoolClass->id]);
			$teacher->update(['classes' => implode(',', $classList)]);

			// Delete the new school class
			$newSchoolClass->forceDelete();
		});
	}
}
