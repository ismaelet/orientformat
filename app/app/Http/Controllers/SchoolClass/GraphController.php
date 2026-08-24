<?php

namespace App\Http\Controllers\SchoolClass;

use App\Http\Controllers\Controller;
use App\Models\Activities\Section;
use App\Models\Schools\Grade;
use App\Models\Schools\SchoolClass;
use App\Support\Graphs\GraphSections;
use Illuminate\View\View;

class GraphController extends Controller {

    /**
     * Display the class graphs landing page.
     */
    public function index(
        SchoolClass $class,
        Grade $grade,
    ): View {
        $areas = [];

        foreach ($class->grade()->areas as $doableArea) {
            $sections = Section::query()
                ->where('areaId', $doableArea->id)
                ->whereHas(
                    'grades',
                    fn($query) => $query
                        ->whereKey($grade->id),
                )
                ->whereIn(
                    'id',
                    GraphSections::ids(),
                )
                ->orderByDesc('legacy_grades')
                ->get();

            if ($sections->isEmpty()) {
                continue;
            }

            $areas[] = [
                'name' => $doableArea->name,
                'id' => $doableArea->id,
                'sections' => $sections,
            ];
        }

        return view('class.graphs.index', [
            'class' => $class,
            'areas' => $areas,
        ]);
    }

    /**
     * Display the grade selection for graphs.
     */
    public function grades(
        SchoolClass $class,
    ): View {
        $grades = Grade::query()
            ->whereBetween(
                'id',
                [
                    $class->first_grade,
                    $class->last_grade,
                ],
            )
            ->where(
                'is_professional',
                $class->isProfessional(),
            )
            ->get();

        return view('class.graphs.grades', [
            'class' => $class,
            'grades' => $grades,
        ]);
    }
}
