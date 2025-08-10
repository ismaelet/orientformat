<?php

use App\Models\Review;
use App\Models\ReviewResult;
use App\Models\Schools\SchoolClass;
use App\Models\User\Student;
use App\Models\User\Teacher;
use Illuminate\Support\Facades\Route;

Route::get('download-surveys', function () {

	$reviewsArray = [];

	// Generate questions mockup
	$results = ReviewResult::whereIn('reviewId', [1, 2])
		->with('student', 'student.user', 'student.school_class')
		->orderBy('studentId')
		->get();

	// Get the result keys
	$resultKeys = [];

	foreach ($results as $result) {
		foreach (array_keys($result->results()) as $key) {
			if (!in_array($key, $resultKeys)) {
				$resultKeys[] = $key;
			}
		}
	}

	asort($resultKeys);

	// Generate results
	foreach ($results as $result) {
		if ($result->student && $result->student->user && $result->student->user->status && !$result->student->user->admin_level) {
			$month = date('m', strtotime($result->student->created_at));
			$year = date('Y', strtotime($result->student->created_at));
			$year = $year - ($month < 9 ? 1 : 0);
			$reviewResults = [
				'ID' => $result->student->userId,
				'Cognome' => $result->student->user->lastName,
				'Nome' => $result->student->user->firstName,
				'Anno scolastico' => $result->student->gradeWhen($result->created_at),
				'Anno di corso' => $year,
			];

			foreach ($resultKeys as $key) {
				$reviewResults[$key] = $result->results()[$key] ?? '.';
			}

			$reviewsArray[] = $reviewResults;
		}
	}

	usort($reviewsArray, function ($a, $b) {
		if ($a['Anno di corso'] === $b['Anno di corso']) {
			return $a['ID'] <=> $b['ID'];
		}
		return $a['Anno di corso'] <=> $b['Anno di corso'];
	});

	$fileTitle = 'Risultati Questionari';

	download_csv($reviewsArray, $fileTitle);
});

Route::get('download-students', function () {
	$studentsArray = [];
	$highSchool = true;
	$yearFilter = 2024;
	$fileTitle = 'Studenti ' . ($highSchool ? 'Superiori' : 'Medie') . ' - ' . $yearFilter . '-' . ($yearFilter + 1);

	Student::join('users', 'students.userId', 'users.id')
		->join('school_classes', 'students.schoolClassId', 'school_classes.id')
		->with('user', 'school_class', 'school_class.school', 'test_results')
		->where('users.status', true)
		->where('admin_level', false)
		->where('school_classes.grade', $highSchool ? '>' : '<=', 3)
		// ->where('users.time', '>=', $yearFilter . '-09-01')
		// ->where('users.time', '<', ($yearFilter + 1) . '-09-01')
		->where('school_classes.startingYear', '<=', $yearFilter)
		->where('school_classes.year', '>=', $yearFilter)
		->orderBy('users.time', 'asc')
		->chunk(100, function ($students) use (&$studentsArray) {
			foreach ($students as $student) {
				if ($student->user) {
					$studentData = [
						'ID' => $student->userId,
						'Cognome' => $student->user->lastName,
						'Nome' => $student->user->firstName,
						'Classe' => $student->school_class->name ?? '.',
						'Istituto' => $student->school_class->school->name ?? '.',
						// 'Anno di corso' => $student->school_class->grade ?? '.',
						'Data di nascita' => $student->user->birthdate,
						// 'Data di iscrizione' => $student->user->time,
					];

					$studentsArray[] = $studentData;
				}
			}
		});

	download_csv($studentsArray, $fileTitle);
});

Route::get('download-teachers', function () {
	$teachersArray = [];
	$highSchool = false;
	$yearFilter = 2024;
	$fileTitle = 'Insegnanti' . ($highSchool ? ' Superiori' : ' Medie') . ' - ' . $yearFilter . '-' . ($yearFilter + 1);

	Teacher::join('users', 'teachers.user_id', 'users.id')
		->with('user', 'school', 'school_classes', 'school_classes.school')
		->where('users.status', true)
		->where('admin_level', false)
		->where('users.time', '>=', $yearFilter . '-09-01')
		->where('users.time', '<', ($yearFilter + 1) . '-09-01')
		->whereHas('school_classes', function ($query) use ($yearFilter, $highSchool) {
			$query->where('startingYear', '<=', $yearFilter)
				->where('year', '>=', $yearFilter)
				->where('grade', $highSchool ? '>' : '<=', 3);
		})
		->orderBy('users.time', 'asc')
		->chunk(100, function ($teachers) use (&$teachersArray) {
			foreach ($teachers as $teacher) {
				if ($teacher->user) {
					$teacherData = [
						'ID' => $teacher->user_id,
						'Cognome' => $teacher->user->lastName,
						'Nome' => $teacher->user->firstName,
						'Istituto' => $teacher->school_classes->first()->school->name ?? '.',
						// 'Data di iscrizione' => $teacher->user->time,
					];

					$teachersArray[] = $teacherData;
				}
			}
		});

	download_csv($teachersArray, $fileTitle);
});

Route::get('teachers-count', function () {
	$highSchool = false;

	$teachers = Teacher::join('users', 'teachers.user_id', 'users.id')
		->with('user', 'school', 'school_classes', 'school_classes.school')
		->where('users.status', true)
		->where('admin_level', false)
		->whereHas('school_classes', function ($query) use ($highSchool) {
			$query->where('grade', $highSchool ? '>' : '<=', 3);
		})
		->orderBy('users.time', 'asc')
		->get();

	echo 'Numero di insegnanti: ' . $teachers->count();
});


Route::get('download-school-classes', function () {
	$schoolClassesArray = [];
	$highSchool = true;
	$yearFilter = 2024;
	$fileTitle = 'Classi' . ($highSchool ? ' Superiori' : ' Medie') . ' - ' . $yearFilter . '-' . ($yearFilter + 1);

	SchoolClass::with('school')
		->where('grade', $highSchool ? '>' : '<=', 3)
		->where('startingYear', '<=', $yearFilter)
		->where('year', '>=', $yearFilter)
		->orderBy('time', 'asc')
		->chunk(100, function ($classes) use (&$schoolClassesArray) {
			foreach ($classes as $class) {
				if ($class->school) {
					$classData = [
						'ID' => $class->id,
						'Nome Classe' => $class->name,
						'Istituto' => $class->school->name,
					];

					$schoolClassesArray[] = $classData;
				}
			}
		});

	download_csv($schoolClassesArray, $fileTitle);
});
