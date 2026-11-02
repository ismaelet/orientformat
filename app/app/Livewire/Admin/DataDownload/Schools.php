<?php

namespace App\Livewire\Admin\DataDownload;

use App\Models\Schools\School;
use Livewire\Component;

class Schools extends Component
{
    /**
     * Property: School type
     */
    public string $schoolType = 'all';

    /**
     * Lifecycle Hook: Render the component view
     */
    public function render()
    {
        return view('livewire.admin.data-download.schools');
    }

    /**
     * Action: Download data based on selected parameters
     */
    public function downloadData()
    {

        $data = [];

        $schools = School::orderBy('created_at');

        if ($this->schoolType !== 'all') {
            $expected = $this->schoolType === 'highschool';
            $schools = $schools->where('has_high_school', $expected);
        }

        $schools = $schools->get();

        foreach ($schools as $school) {
            $data[] = [
                'ID' => $school->id,
                'Nome' => $school->name,
                'Scuola superiore' => $school->has_high_school ? 'Sì' : 'No',
                'Numero di classi' => $school->classes()->count() ?: '0',
                'Numero di docenti' => $school->teachers()->count() ?: '0',
                'Numero di studenti' => $school->students()->count() ?: '0',
            ];
        }

        if (empty($data)) {
            return session()->flash('error', 'Nessun dato trovato con i parametri selezionati.');
        }

        $fileName = 'Lista_Scuole_'.now()->format('Ymd_His').'.csv';

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
