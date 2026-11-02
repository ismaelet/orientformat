<?php

namespace App\Livewire\Admin\DataDownload;

use App\Models\User\Student;
use Livewire\Component;

class Students extends Component
{
    /**
     * Property: School year
     */
    public ?int $schoolYear = null;

    /**
     * Property: Course year
     */
    public ?int $courseYear = null;

    /**
     * Property: School type
     */
    public string $schoolType = 'all';

    /**
     * Property: Download only active students
     */
    public bool $activeStudents = false;

    /**
     * Lifecycle Hook: Render the component view
     */
    public function render()
    {
        return view('livewire.admin.data-download.students');
    }

    /**
     * Action: Download data based on selected parameters
     */
    public function downloadData()
    {

        $data = [];

        $students = Student::orderBy('created_at')
            ->with('user', 'class.school', 'class.grade_level');

        if ($this->schoolYear) {
            // Filter by school year
            $startDate = now()->setDate($this->schoolYear, 9, 1)->startOfDay();
            $endDate = now()->setDate($this->schoolYear + 1, 8, 31)->endOfDay();

            if ($this->activeStudents) {
                // Filter by active students within the school year
                $students = $students->whereHas('test_results', function ($query) use ($startDate, $endDate) {
                    $query->whereBetween('created_at', [$startDate, $endDate]);
                });
            } else {
                // Filter by registration date within the school year
                $students = $students->whereBetween('created_at', [$startDate, $endDate]);
            }
        }

        if ($this->schoolType !== 'all') {
            $students = $students->whereHas('class.grade_level', fn ($query) => $query->where('is_highschool', $this->schoolType === 'highschool'));
        }

        $students = $students->get();

        foreach ($students as $student) {
            $gradeLevel = $this->schoolYear ? $student->class?->gradeLevelAt($this->schoolYear) : $student->class?->grade_level;

            // Filter by course year if specified
            if ($this->courseYear && ($gradeLevel?->school_relative_number ?? null) != $this->courseYear) {
                continue;
            }

            $data[] = [
                'ID' => $student->id,
                'Cognome' => $student->user->last_name,
                'Nome' => $student->user->first_name,
                'Classe' => $student->class?->name ?? '.',
                'Scuola' => $student->class->school?->name ?? '.',
                'Scuola superiore' => $student->class?->grade_level?->is_highschool ? 'Sì' : 'No',

                $this->schoolYear ? 'Anno di corso nel '.$this->schoolYear : 'Anno di corso' => $gradeLevel?->school_relative_number ?? '.',

                'Anno di fine corso' => $student->class?->ended ? $student->class?->lastActiveYear() : '.',

                'Registrato/a il' => $student->created_at->format('d/m/Y'),
            ];
        }

        if (empty($data)) {
            return session()->flash('error', 'Nessun dato trovato con i parametri selezionati.');
        }

        $fileName = 'Lista_Studenti_'.now()->format('Ymd_His').'.csv';

        $filePath = storage_path('app/'.$fileName);
        $handle = fopen($filePath, 'w');

        fputcsv($handle, array_map(fn ($field) => ucfirst($field), array_keys($data[0] ?? [])));

        foreach ($data as $student) {
            fputcsv($handle, $student);
        }

        fclose($handle);

        return response()->download($filePath)->deleteFileAfterSend(true);
    }
}
