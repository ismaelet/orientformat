<?php

namespace App\Livewire\Admin\DataDownload;

use App\Models\Activities\Test;
use App\Models\Results\User\TestResult;
use App\Models\Review;
use App\Models\ReviewQuestion;
use App\Models\ReviewResult;
use App\Models\Schools\Grade;
use App\Models\User\Student;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;
use Livewire\Component;

class Details extends Component {

    /**
     * Property: School year
     */
    public ?int $schoolYear = null;

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
    public function render() {
        return view('livewire.admin.data-download.details');
    }

    public function downloadData() {
        return redirect()->route('admin.data-download.details', [
            'schoolYear' => $this->schoolYear,
            'schoolType' => $this->schoolType,
            'activeStudents' => $this->activeStudents,
        ]);
    }
}
