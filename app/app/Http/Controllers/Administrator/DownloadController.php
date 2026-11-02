<?php

namespace App\Http\Controllers\Administrator;

use App\Exports\ArrayExport;
use App\Helpers\SectionResultHelper;
use App\Http\Controllers\Controller;
use App\Models\Schools\Grade;
use App\Models\Schools\School;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DownloadController extends Controller
{
    /**
     * Display the download options page.
     */
    public function index(Request $request)
    {
        $school = administrator()->school;
        $datasets = [
            [
                'label' => 'Risultati studenti',
                'route' => 'administrator.download.results',
            ],
            [
                'label' => 'Elenco studenti attivi',
                'route' => 'administrator.download.students',
            ],
            [
                'label' => 'Elenco docenti',
                'route' => 'administrator.download.teachers',
            ],
            [
                'label' => 'Elenco classi',
                'route' => 'administrator.download.classes',
            ],
        ];

        return view('administrator.download', [
            'school' => $school,
            'datasets' => $datasets,
        ]);
    }

    /**
     * Download student results
     */
    public function downloadResults(Request $request, School $school)
    {
        $data = $this->fetchResultsData($school);

        $filename = 'Risultati_studenti';

        return $this->downloadData($data, $filename, $request);
    }

    /**
     * Download active students
     */
    public function downloadStudents(Request $request, School $school)
    {
        $data = $this->fetchStudentsData($school);

        $filename = 'Elenco_studenti_attivi';

        return $this->downloadData($data, $filename, $request);
    }

    /**
     * Download teachers
     */
    public function downloadTeachers(Request $request, School $school)
    {
        $data = $this->fetchTeachersData($school);

        $filename = 'Elenco_docenti';

        return $this->downloadData($data, $filename, $request);
    }

    /**
     * Download classes
     */
    public function downloadClasses(Request $request, School $school)
    {
        $data = $this->fetchClassesData($school);

        $filename = 'Elenco_classi';

        return $this->downloadData($data, $filename, $request);
    }

    /**
     * Download the requested data in the specified format
     */
    private function downloadData(array $data, string $filename, Request $request)
    {
        $format = $request->input('format', 'csv');

        if ($format === 'csv') {
            return $this->downloadCsv($data, $filename.'.csv');
        }

        if ($format === 'xlsx') {
            return $this->downloadXlsx($data, $filename.'.xlsx');
        }

        abort(400, 'Formato non supportato');
    }

    /**
     * Download data as CSV file
     */
    public function downloadCsv(array $data, string $filename)
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($data) {
            $file = fopen('php://output', 'w');
            if (! empty($data)) {
                fputcsv($file, array_keys($data[0]));
                foreach ($data as $row) {
                    fputcsv($file, $row);
                }
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Download data as XLSX file
     */
    public function downloadXlsx(array $data, string $filename)
    {
        return Excel::download(new ArrayExport($data), $filename);
    }

    /**
     * Fetch results data for download
     */
    private function fetchResultsData(School $school): array
    {
        $students = $school
            ->students()
            ->join('users', 'users.id', '=', 'students.userId')
            ->whereHas('class', function ($query) {
                $query->where('ended', false);
            })
            ->orderBy('schoolClassId')
            ->orderBy('users.last_name')
            ->orderBy('users.first_name')
            ->select('students.*')
            ->with(['user', 'class', 'class.tutor', 'class.tutor.user', 'test_results'])
            ->get();

        $grades = Grade::where('is_professional', false)
            ->where('is_highschool', $school->has_high_school)
            ->orderBy('absolute_number')
            ->get();

        $sections = $grades->flatMap(function (Grade $grade) {
            return $grade->completable_sections()->with('active_tests', 'evaluation_test', 'area')->get();
        })->keyBy('id');

        $sections = $sections->sortBy('areaId');

        foreach ($students as $student) {
            $results = [];

            foreach ($sections as $section) {
                $results[$section->area->name.' - '.$section->name] = ($section->result_label ?: 'Risultato dell\'autovalutazione').': '.(str_replace([',', ';'], ' -', SectionResultHelper::label($student, $section)) ?: 'Non svolto');
            }

            $data[] = [
                'Cognome' => $student->user->last_name,
                'Nome' => $student->user->first_name,
                'Classe' => $student->class->name,
            ] + $results;
        }

        return $data;
    }

    /**
     * Fetch students data for download
     */
    private function fetchStudentsData(School $school): array
    {
        $students = $school
            ->students()
            ->join('users', 'users.id', '=', 'students.userId')
            ->whereHas('class', function ($query) {
                $query->where('ended', false);
            })
            ->orderBy('schoolClassId')
            ->orderBy('users.last_name')
            ->orderBy('users.first_name')
            ->select('students.*')
            ->with(['user', 'class', 'class.tutor', 'class.tutor.user'])
            ->get();

        $data = [];

        foreach ($students as $student) {
            $data[] = [
                'Cognome' => $student->user->last_name,
                'Nome' => $student->user->first_name,
                'Email' => $student->user->email,
                'Classe' => $student->class->name,
                'Tutor' => $student->class->tutor->full_name,
                'Data di registrazione' => $student->created_at->toDateString(),
            ];
        }

        return $data;
    }

    /**
     * Fetch teachers data for download
     */
    private function fetchTeachersData(School $school): array
    {
        $teachers = $school
            ->teachers()
            ->join('users', 'users.id', '=', 'teachers.user_id')
            ->orderBy('users.last_name')
            ->orderBy('users.first_name')
            ->select('teachers.*')
            ->with(['user'])
            ->get();

        $data = [];

        foreach ($teachers as $teacher) {
            $data[] = [
                'Cognome' => $teacher->user->last_name,
                'Nome' => $teacher->user->first_name,
                'Email' => $teacher->user->email,
                'Data di registrazione' => $teacher->user->created_at->toDateString(),
            ];
        }

        return $data;
    }

    /**
     * Fetch classes data for download
     */
    private function fetchClassesData(School $school): array
    {
        $classes = $school
            ->classes()
            ->with(['tutor', 'tutor.user'])
            ->orderBy('ended')
            ->orderBy('name')
            ->get();

        $data = [];

        foreach ($classes as $class) {
            $data[] = [
                'Nome classe' => $class->name,
                'Tutor' => $class->tutor->full_name,
                'Numero di studenti' => $class->students()->count(),
                'Ha terminato il percorso' => $class->ended ? 'Sì' : 'No',
            ];
        }

        return $data;
    }
}
