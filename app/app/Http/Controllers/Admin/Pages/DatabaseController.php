<?php

namespace App\Http\Controllers\Admin\Pages;

use App\Http\Controllers\Controller;
use App\Legacy\LegacyDB;
use App\Legacy\Questionnaire;
use App\Legacy\User as LegacyUser;
use App\Models\Review;
use App\Models\ReviewQuestion;
use App\Models\ReviewResult;
use App\Models\Schools\SchoolClass;
use App\Models\User\Student;
use App\Models\User\Teacher;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Legacy\Activity\Result\TestResult as LegacyTestResult;
use Legacy\SchoolSystem\School as LegacySchool;
use Legacy\SchoolSystem\SchoolClass as LegacySchoolClass;
use Legacy\UserSystem\Student as LegacyStudent;

class DatabaseController extends Controller {

	/**
	 * Display the admin dashboard
	 */
	public function index(): View {
		$startingYear = 2021;
		$currentYear = (int) date('m') >= 9 ? getdate()['year'] : getdate()['year'] - 1;

		return view('admin.database.index', [
			'startingYear' => $startingYear,
			'currentYear' => $currentYear,
		]);
	}

	public function downloadActiveStudents() {
		$studentsArray = [];
		$yearFilter = $_POST['year'];
		$fileTitle = 'Lista degli studenti attivi - ' . $yearFilter . '-' . ($yearFilter + 1);

		$students = Student::join('users', 'students.userId', 'users.id')
			->with('user', 'school_class', 'school_class.school', 'test_results')
			->where('users.status', true)
			->where('admin_level', false)
			->whereIn('userId', function ($query) use ($yearFilter) {
				$query->select('studentId')
					->from('results_tests')
					->where('time', '>=', $yearFilter . '-09-01')
					->where('time', '<', ($yearFilter + 1) . '-09-01');
			})
			->chunk(100, function ($students) use (&$studentsArray) {
				foreach ($students as $student) {
					$completedActivityCount = $student->test_results->count();
					$totalTime = round($student->test_results->sum('speed') / 60);

					$studentData = [
						'ID' => $student->userId,
						'Cognome' => $student->user->last_name,
						'Nome' => $student->user->first_name,
						'Classe' => $student->school_class->name ?? '.',
						'Istituto' => $student->school_class->school->name ?? '.',
						// 'Registrato/a nel' => $studentObj->startingYear . '/' . ($studentObj->startingYear + 1),
						'Anno di corso' => $student->school_class->grade ?? '.',
						'Data di nascita' => $student->user->birthdate,
						'Attività completate' => $completedActivityCount,
						'Tempo totale impiegato' => $totalTime,
						// 'Consiglio orientativo' => $studentObj->advicesString ? str_replace('<br>', ' - ', $studentObj->advicesString) : '.',
					];

					$studentsArray[] = $studentData;
				}
			});

		download_csv($studentsArray, $fileTitle);
	}

	public function downloadStudents() {
		$studentsArray = [];
		$yearFilter = $_POST['year'] != 'all' ? $_POST['year'] : false;
		$fileTitle = $yearFilter ? 'Lista degli studenti - ' . $yearFilter . '-' . ($yearFilter + 1) : 'Lista di tutti gli studenti';

		$students = Student::join('users', 'students.userId', 'users.id')
			->with('user', 'school_class', 'school_class.school')
			->where('users.status', true)
			->where('admin_level', false)
			->orderBy('userId', 'ASC');

		if ($yearFilter) {
			$students->where('time', '>=', $yearFilter . '-09-01')
				->where('time', '<', ($yearFilter + 1) . '-09-01');
		}

		$students->chunk(100, function ($students) use (&$studentsArray) {
			foreach ($students as $student) {
				$completedActivityCount = $student->test_results->count();
				$totalTime = round($student->test_results->sum('speed') / 60);

				$studentData = [
					'ID' => $student->userId,
					'Cognome' => $student->user->last_name,
					'Nome' => $student->user->first_name,
					'Classe' => $student->school_class->name ?? '.',
					'Istituto' => $student->school_class->school->name ?? '.',
					// 'Registrato/a nel' => $student['startingYear'] . '/' . ($student['startingYear'] + 1),
					'Anno di corso' => $student->school_class->grade ?? '.',
					'Data di nascita' => $student->user->birthdate,
					'Attività completate' => $completedActivityCount,
					'Tempo totale impiegato' => $totalTime,
					// 'Consiglio orientativo' => $studentObj->advicesString ? str_replace('<br>', ' - ', $studentObj->advicesString) : '.',
				];

				$studentsArray[] = $studentData;
			}
		});

		download_csv($studentsArray, $fileTitle);
	}

	public function downloadTeachers() {
		$teachersArray = [];
		$yearFilter = $_POST['year'] != 'all' ? $_POST['year'] : false;
		$fileTitle = $yearFilter ? 'Lista dei docenti - ' . $yearFilter : 'Lista dei docenti';

		$teachers = Teacher::join('users', 'teachers.userId', 'users.id')
			->where('users.status', true)
			->where('admin_level', false)
			->orderBy('users.id', 'ASC');

		if ($yearFilter) {
			$teachers->where('time', '>=', $yearFilter . '-09-01')
				->where('time', '<', ($yearFilter + 1) . '-09-01');
		}

		$teachers->chunk(100, function ($teachers) use (&$teachersArray) {
			foreach ($teachers as $teacher) {
				$teacherData = [
					'ID' => $teacher->userId,
					'Cognome' => $teacher->last_name,
					'Nome' => $teacher->first_name,
					'E-mail' => $teacher->email ?: '.',
				];

				$teachersArray[] = $teacherData;
			}
		});

		download_csv($teachersArray, $fileTitle);
	}

	public function downloadSchoolClasses() {
		$schoolClassesArray = [];
		$yearFilter = $_POST['year'] != 'all' ? $_POST['year'] : false;
		$fileTitle = $yearFilter ? 'Lista delle classi - ' . $yearFilter . '-' . ($yearFilter + 1) : 'Lista di tutte le classi';

		$schoolClasses = SchoolClass::join('schools', 'school_classes.schoolId', 'schools.id')
			->join('users', 'school_classes.referentId', 'users.id')
			->where('school_classes.status', true)
			->where('admin_level', false)
			->orderBy('school_classes.id', 'ASC');

		if ($yearFilter) {
			$schoolClasses->where('startingYear', $yearFilter);
		}

		$schoolClasses->chunk(100, function ($schoolClasses) use (&$schoolClassesArray) {
			foreach ($schoolClasses as $schoolClass) {
				$gradeData = [
					'Nome' => $schoolClass->name,
					'Istituto' => $schoolClass->school->name,
					'Anno scolastico' => $schoolClass->startingYear . '/' . ($schoolClass->startingYear + 1),
					'Anno di corso' => $schoolClass->grade,
				];

				$schoolClassesArray[] = $gradeData;
			}
		});

		download_csv($schoolClassesArray, $fileTitle);
	}


	public function downloadReviews(Request $request) {
		if ($request->cypher) {
			$resultsArray = [];
			$reviewId = $request->reviewId;
			$review = Review::find($reviewId);
			$reviewQuestions = ReviewQuestion::whereRaw("FIND_IN_SET(?, reviewIds)", [$reviewId])
				->orWhere('reviewIds', '')
				->orderBy('full_slug')
				->get();

			foreach ($reviewQuestions as $question) {
				$resultsArray[0][$question->full_slug] = str_replace(["\r", "\n"], '', str_replace(',', ';', $question->text));

				if ($question->rows && $question->type == 'grid' && $question->grouppedBy == 'rows') {
					foreach ($question->options() as $optionKey => $option) {
						$resultsArray[0][$question->full_slug . '_' . ($optionKey + 1)] = $option;
					}
				}
			}

			$fileTitle = $review->title . ' - Cifrario';

			download_csv($resultsArray, $fileTitle);
		} else {

			$reviewsArray = [];
			$yearFilter = $_POST['year'] != 'all' ? $_POST['year'] : false;
			$reviewId = $_POST['reviewId'] ?? false;

			$reviews = Review::all();

			// Generate questions mockup
			$results = ReviewResult::where('reviewId', $reviewId)
				->join('students', 'review_results.studentId', 'students.userId')
				->join('users', 'students.userId', 'users.id')
				->with('student', 'student.user')
				->where('users.status', true)
				->where('admin_level', false);


			if ($yearFilter) {
				$results->where('review_results.time', '>=', $yearFilter . '-09-01')
					->where('review_results.time', '<', ($yearFilter + 1) . '-09-01');
			}

			$results = $results->get();

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
				$reviewResults = [
					'ID' => $result->student->userId,
					'Cognome' => $result->student->user->last_name,
					'Nome' => $result->student->user->first_name,
				];

				foreach ($resultKeys as $key) {
					$reviewResults[$key] = $result->results()[$key] ?? '.';
				}

				$reviewsArray[] = $reviewResults;
			}

			$review = $reviews->where('id', $reviewId)->first();
			$fileTitle = $yearFilter ? $review->title . ' - Lista - ' . $yearFilter . '-' . ($yearFilter + 1) : $review->title . ' - Lista';

			download_csv($reviewsArray, $fileTitle);
		}
	}

	public function downloadResults() {
		$studentsArray = [];
		$yearFilter = $_POST['download-results'] != 'all' ? $_POST['download-results'] : false;
		$yearSql = $yearFilter ? 'AND year = ?' : '';
		$parameters = $yearFilter ? [$yearFilter] : [];
		$fileTitle = $yearFilter ? 'Lista dei risultati - ' . $yearFilter . '-' . ($yearFilter + 1) : 'Lista di tutti i risultati';

		$results = LegacyDB::select('
	*, CONCAT (grade, letter) as gradeName, year as gradeYear, grade as grade, birthdate as birthdate, schools.name as schoolName
		FROM students
			INNER JOIN users ON students.userId = users.id
			INNER JOIN classes ON students.classId = classes.id
			INNER JOIN schools ON classes.school = schools.id
			LEFT JOIN results_condensed ON students.userId = results_condensed.studentId
	WHERE users.status = 1 ' . $yearSql . '
	ORDER BY users.id ASC', $parameters);

		// fetch tests data
		$legacyTests = [];

		$legacyTestRows = LegacyDB::select('
		tests.id as testId, title, sections.name as sectionName, static, dependentOn
		FROM tests
			INNER JOIN sections ON tests.sectionID = sections.id
		WHERE tests.active = 1 AND template <> "recap"
		ORDER BY sectionID ASC, step ASC
	');

		while ($legacyTest = $legacyTestRows->fetch_assoc()) {
			$legacyTests[] = $legacyTest;
		}

		// generate results
		while ($result = $results->fetch_assoc()) {
			$resultData = [
				'ID' => $result['userId'],
				'Cognome' => $result['last_name'],
				'Nome' => $result['first_name'],
				'Classe' => $result['gradeName'],
				'Istituto' => $result['schoolName'],
				'Anno scolastico' => $result['gradeYear'] . '/' . ($result['gradeYear'] + 1),
				'Anno di corso' => $result['grade'],
			];

			foreach ($legacyTests as $legacyTest) {
				$legacyTestTitle = $legacyTest['sectionName'] . ' - ' . $legacyTest['title'];

				if (!$legacyTest['static'] && !$legacyTest['dependentOn']) {
					$resultData[$legacyTestTitle . ' - Risultati'] = !empty($result['test' . $legacyTest['testId'] . '_results']) ? str_replace(',', ' - ', $result['test' . $legacyTest['testId'] . '_results']) : '.';
					$resultData[$legacyTestTitle . ' - Percentuale'] = isset($result['test' . $legacyTest['testId'] . '_percentage']) ? $result['test' . $legacyTest['testId'] . '_percentage'] . '%' : '.';
				}

				$resultData[$legacyTestTitle . ' - Tempo Impiegato'] = $result && $result['test' . $legacyTest['testId'] . '_speed'] ? $result['test' . $legacyTest['testId'] . '_speed'] : '.';
				$resultData[$legacyTestTitle . ' - Numero di volte completato'] = $result && $result['test' . $legacyTest['testId'] . '_times'] ? $result['test' . $legacyTest['testId'] . '_times'] : 0;
			}

			$resultsArray[] = $resultData;
		}

		download_csv($resultsArray, $fileTitle);
	}

	public function downloadAdvices() {
		$studentsArray = [];
		$yearFilter = $_POST['download-advices'] != 'all' ? $_POST['download-advices'] : false;
		$yearSql = $yearFilter ? 'AND year = ?' : '';
		$parameters = $yearFilter ? [$yearFilter] : [];
		$fileTitle = $yearFilter ? 'Lista dei consigli orientativi - ' . $yearFilter . '-' . ($yearFilter + 1) : 'Lista di tutti i consigli orientativi';

		$students = LegacyDB::select('
	advices, users.id as userId, first_name, last_name
		FROM advices
			INNER JOIN students ON advices.userID = students.userId
			INNER JOIN users ON students.userId = users.id
			INNER JOIN classes ON students.classId = classes.id
	WHERE users.status = 1 ' . $yearSql . '
	ORDER BY users.id ASC', $parameters);


		while ($student = $students->fetch_assoc()) {
			$advices = explode(',', $student['advices']);

			$studentData = [
				'ID' => $student['userId'],
				'Cognome' => $student['last_name'],
				'Nome' => $student['first_name'],
				'Consiglio 1' => isset($advices[0]) ? (new Advice($advices[0]))->name : '.',
				'Consiglio 2' => isset($advices[1]) ? (new Advice($advices[1]))->name : '.',
				'Consiglio 3' => isset($advices[2]) ? (new Advice($advices[2]))->name : '.',
			];

			$studentsArray[] = $studentData;
		}


		download_csv($studentsArray, $fileTitle);
	}
}
