<?php

namespace App\Livewire\Admin\DataDownload;

use App\Models\User\Teacher;
use Livewire\Component;

class Teachers extends Component {

    /**
     * Property: School year
     */
    public ?int $schoolYear = null;

    /**
     * Property: School type
     */
    public string $schoolType = 'all';

    /**
     * Lifecycle Hook: Render the component view
     */
    public function render() {
        return view('livewire.admin.data-download.teachers');
    }

    /**
     * Action: Download data based on selected parameters
     */
    public function downloadData() {

        $data = [];

        $teachers = Teacher::orderBy('created_at')
            ->with('user', 'school', 'classes')
            ->whereHas('user');

        if ($this->schoolYear) {
            // Filter by school year
            $startDate = now()->setDate($this->schoolYear, 9, 1)->startOfDay();
            $endDate = now()->setDate($this->schoolYear + 1, 8, 31)->endOfDay();

            // Filter by registration date within the school year
            $teachers = $teachers->whereBetween('created_at', [$startDate, $endDate]);
        }

        if ($this->schoolType !== 'all') {
            $teachers = $teachers->whereHas('school', function ($query) {
                $query->where('has_high_school', $this->schoolType === 'highschool');
            });
        }

        $teachers = $teachers->get();

        foreach ($teachers as $teacher) {
            $data[] = [
                'ID' => $teacher->id,
                'Cognome' => $teacher->user->last_name,
                'Nome' => $teacher->user->first_name,
                'Classi' => $teacher->classes->count() ?: '0',
                'Scuola' => $teacher->school?->name ?: '.',
                'Scuola superiore' => $teacher->school?->has_high_school ? 'Sì' : 'No',
                'Registrato/a il' => $teacher->user->created_at->format('d/m/Y'),
            ];
        }

        if (empty($data)) {
            return session()->flash('error', 'Nessun dato trovato con i parametri selezionati.');
        }

        $fileName = 'Lista_Docenti_' . now()->format('Ymd_His') . '.csv';
        $filePath = storage_path('app/' . $fileName);
        $handle = fopen($filePath, 'w');

        fputcsv($handle, array_map(fn($field) => ucfirst($field), array_keys($data[0] ?? [])));

        foreach ($data as $teacher) {
            fputcsv($handle, $teacher);
        }

        fclose($handle);

        return response()->download($filePath)->deleteFileAfterSend(true);
    }
}
