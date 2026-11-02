<?php

namespace App\View\Components\ClassDashboard;

use App\Models\Schools\SchoolClass;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Navigation extends Component
{
    /**
     * Property: The navigation items
     */
    public array $navigation = [];

    /**
     * Create a new component instance.
     */
    public function __construct(public SchoolClass $class)
    {
        $this->navigation = [
            // Teacher's home
            ['title' => 'Tutte le classi', 'icon' => 'classes', 'url' => ['home']],

            // Class welcome dashboard
            ['title' => 'Riepilogo', 'icon' => 'home', 'url' => ['class.show', ['class' => $class->id]]],

            // Class general results
            [
                'title' => 'Risultati di classe',
                'icon' => 'class-progress',
                'links' => [
                    [
                        'title' => 'Progresso della classe',
                        'url' => ['class.general.progress', ['class' => $class->id]],
                    ],
                    [
                        'title' => 'Grafici riassuntivi',
                        'url' => ['class.general.graphs', ['class' => $class->id]],
                    ],
                ],
            ],

            // Student results
            [
                'title' => 'Risultati individuali',
                'icon' => 'students',
                'links' => [
                    // Student result list
                    [
                        'title' => 'Progresso dello studente',
                        'url' => ['class.students.results.index', ['class' => $class->id]],
                    ],

                    // Consigli orientativi
                    // $class->grade == 3
                    // 	? [
                    // 		'title' => 'Consigli orientativi',
                    // 		'url' => ['class.students.guidance.index', ['class' => $class->id]],
                    // 	]
                    // 	: null,
                ],
            ],

            // Settings
            [
                'title' => 'Gestione',
                'icon' => 'settings',
                'links' => [
                    // Student list
                    ['title' => 'Gestione studenti', 'url' => ['class.students.index', ['class' => $class->id]]],

                    // Teacher management
                    ['title' => 'Gestione docenti', 'url' => ['class.teachers.index', ['class' => $class->id]]],

                    // General settings
                    ['title' => 'Impostazioni generali', 'url' => ['class.settings', ['class' => $class->id]]],
                ],
            ],
        ];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.class-dashboard.navigation');
    }
}
