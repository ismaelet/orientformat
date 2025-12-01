<?php

namespace App\Livewire\Admin\DataDownload;

use App\Models\User\Student;
use Livewire\Component;

class Details extends Component {

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
     * Lifecycle Hook: Render the component view
     */
    public function render() {
        return view('livewire.admin.data-download.details');
    }

    /**
     * Action: Download data based on selected parameters
     */
    public function downloadData() {
        dd(1);
        $data = [];

        $students = Student::orderBy('id', 'asc')
            ->with('user')
            ->get();

        foreach ($students as $student) {
            $data[] = [
                'ID' => $student->id,
                'Cognome' => $student->user->last_name,
                'Nome' => $student->user->first_name,
                'Classe' => $student->class->name,
                'Scuola' => $student->class->school->name,
                'Anno di corso' => $student->class->grade->name,
                'Registrato/a il' => $student->created_at->format('d/m/Y H:i:s'),
            ];
        }

        $fileName = 'Lista_Studenti_' . now()->format('Ymd_His') . '.csv';

        $handle = fopen($fileName, 'w');

        fputcsv($handle, array_map(fn($field) => ucfirst($field), array_keys($data[0] ?? [])));

        foreach ($data as $student) {
            fputcsv($handle, $student);
        }

        fclose($handle);

        return response()->download($fileName)->deleteFileAfterSend(true);
    }
}
