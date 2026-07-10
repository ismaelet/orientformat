<?php

namespace App\Http\Controllers\SchoolClass;

use App\Http\Controllers\Controller;
use App\Models\Activities\Section;
use App\Models\Schools\Grade;
use App\Models\Schools\SchoolClass;
use Illuminate\View\View;

class GraphController extends Controller {

    private const GRAPH_SECTION_IDS = [
        // Profilo - Stili cognitivi
        1,
        28,
        36,
        37,

        // Profilo - Resilienza
        3,

        // Profilo - Autostima
        4,
        29,
        41,

        // Profilo - Risolvere i problemi
        5,
        30,

        // Profilo - Stile attributivo
        6,

        // Profilo - Motivazione
        7,

        // Profilo - Temperamento
        8,

        // Profilo - La ruota delle emozioni
        27,

        // Competenze - Stare attenti
        9,
        31,

        // Competenze - Ricordare
        10,
        32,

        // Competenze - Ascoltare
        11,
        33,

        // Competenze - Parlare
        12,

        // Competenze - Scrivere
        14,
        34,

        // Competenze - Leggere
        39,

        // Competenze - Imparare
        40,

        // Saperi - Creatività
        17,

        // Scegliere - Interessi
        24,
        45,
    ];

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
                    self::GRAPH_SECTION_IDS,
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
