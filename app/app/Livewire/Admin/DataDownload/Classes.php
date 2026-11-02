<?php

namespace App\Livewire\Admin\DataDownload;

use App\Models\Schools\SchoolClass;
use Livewire\Component;

class Classes extends Component
{
    /**
     * Property: School year
     */
    public ?int $schoolYear = null;

    /**
     * Property: School type
     */
    public string $schoolType = 'all';

    /**
     * Property: Download only active classes
     */
    public bool $activeClasses = false;

    /**
     * Lifecycle Hook: Render the component view
     */
    public function render()
    {
        return view('livewire.admin.data-download.classes');
    }

    /**
     * Action: Download data based on selected parameters
     */
    public function downloadData()
    {

        $data = [];

        $classes = SchoolClass::orderBy('created_at')
            ->with('school', 'grade_level')
            ->get();

        if ($this->schoolYear) {
            // Filter by school year
            $startDate = now()->setDate($this->schoolYear, 9, 1)->startOfDay();
            $endDate = now()->setDate($this->schoolYear + 1, 8, 31)->endOfDay();

            if ($this->activeClasses) {
                // Filter by active classes within the school year
                $classes = $classes->filter(fn ($class) => $class->wasActiveInYear($this->schoolYear));
            } else {
                // Filter by registration date within the school year
                $classes = $classes->whereBetween('created_at', [$startDate, $endDate]);
            }
        }

        if ($this->schoolType !== 'all') {
            $expected = $this->schoolType === 'highschool';

            $classes = $classes->filter(
                fn ($class) => $class->grade_level->is_highschool == $expected
            );
        }

        foreach ($classes as $class) {
            $gradeLevel = $this->schoolYear ? $class?->gradeLevelAt($this->schoolYear) : $class?->grade_level;

            $data[] = [
                'ID' => $class->id,
                'Nome' => $class->name,
                $this->schoolYear ? 'Anno di corso nel '.$this->schoolYear : 'Anno di corso' => $gradeLevel?->school_relative_number ?? '.',
                'Scuola' => $class->school?->name ?? '.',
                'Scuola superiore' => $class->grade_level->is_highschool ? 'Sì' : 'No',
                'Ha terminato il percorso' => $class->ended ? 'Sì' : 'No',
                'Registrata il' => $class->created_at->format('d/m/Y'),
            ];
        }

        if (empty($data)) {
            return session()->flash('error', 'Nessun dato trovato con i parametri selezionati.');
        }

        $fileName = 'Lista_Classi_'.now()->format('Ymd_His').'.csv';

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
