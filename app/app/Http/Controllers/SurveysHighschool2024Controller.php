<?php

namespace App\Http\Controllers;

use App\Models\Survey\SurveyHighschool_2024Result;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SurveysHighschool2024Controller extends Controller
{
    /**
     * * Action: Index
     */
    public function index(): View
    {
        $questionAreas = [

            // * SECTION A
            [
                'title' => 'Info di Base',
                'questions' => [
                    // ~ Question A.1
                    [
                        'type' => 'radio-columns',
                        'text' => 'Ruolo svolto',
                        'options' => [
                            'Docente di scuola media',
                            'Docente di scuola superiore',
                            'Referente per l’orientamento',
                            'Coordinatore/Coordinatrice del Consiglio di classe',
                        ],
                    ],

                    // ~ Question A.2
                    [
                        'type' => 'complex-table',
                        'text' => 'Quali sezioni di OrientFormat hai utlizzato?',
                        'headers' => [
                            'Aree', 'Sezioni', 'Utilizzata in una sola classe', 'Utilizzata in più classi',
                        ],
                        'rows' => [
                            [
                                'title' => 'Profilo personale',
                                'options' => [
                                    'La ruota delle emozioni',
                                    'Stili cognitivi',
                                    'Stili personali: modi di agire',
                                    'Stili personali: modi di essere',
                                    'Resilienza',
                                    'Autostima',
                                    'Risolvere problemi',
                                    'Stile attributivo',
                                    'Motivazione e aree interesse',
                                    'Temperamento',
                                ],
                            ],
                            [
                                'title' => 'Competenze di base',
                                'options' => [
                                    'Stare attenti',
                                    'Ricordare',
                                    'Ascoltare',
                                    'Parlare',
                                    'Leggere',
                                    'Scrivere',
                                    'Imparare',
                                ],
                            ],
                            [
                                'title' => 'Saperi informali',
                                'options' => [
                                    'Creatività e autoimprenditorialità',
                                    'L’albero dei miei saperi informali',
                                ],
                            ],
                            [
                                'title' => 'Scegliere',
                                'options' => [
                                    'L’offerta formativa/Orizzonte lavoro',
                                    'Formazione post-diploma',
                                ],
                            ],
                        ],
                    ],
                ],
            ],

            // * SECTION B
            [
                'title' => 'Risposta degli Studenti',
                'questions' => [
                    // ~ Question B.1
                    [
                        'type' => 'radio-rows',
                        'text' => 'Il percorso orientativo proposto è stato svolto da',
                        'options' => [
                            'Tutta la classe',
                            'La maggior parte della classe',
                            'Alcuni studenti',
                        ],
                    ],

                    // ~ Question B.2
                    [
                        'type' => 'radio-rows',
                        'text' => 'Ti sembra che il percorso realizzato dagli studenti abbia interessato e coinvolto',
                        'options' => [
                            'Generalmente poco',
                            'Generalmente abbastanza',
                            'Generalmente molto',
                            'Molto alcuni e poco altri',
                        ],
                    ],
                ],
            ],

            // * SECTION C
            [
                'title' => 'Coinvolgimento dei Colleghi',
                'questions' => [
                    // ~ Question C.1
                    [
                        'type' => 'radio-rows',
                        'text' => 'La sperimentazione proposta nel tuo istituto',
                        'options' => [
                            'Ha interessato e coinvolto altri colleghi del Consiglio di classe',
                            'Ha suscitato qualche interesse ma nessun coinvolgimento',
                            'È stata praticamente ignorata',
                        ],
                    ],

                    // ~ Question C.2
                    [
                        'type' => 'radio-rows',
                        'text' => 'La sperimentazione proposta nel tuo istituto',
                        'options' => [
                            'Ha influito in qualche modo sulla didattica in alcune discipline',
                            'Non ha influito in alcun modo sulla didattica disciplinare',
                        ],
                    ],

                    // ~ Question C.3
                    [
                        'type' => 'radio-rows',
                        'text' => 'La sperimentazione di OrientFormat',
                        'options' => [
                            'Si è rapportata all’alternanza scuola-lavoro',
                            'Non ha avuto nessun raccordo con l’alternanza scuola-lavoro',
                        ],
                    ],
                ],
            ],

            // * SECTION D
            [
                'title' => 'Valutazione del Progetto OrientFormat',
                'questions' => [

                    // ~ Question D.1
                    [
                        'type' => 'grid',
                        'text' => 'Come valuti l’articolazione in quattro aree rispetto ai seguenti aspetti?',
                        'headers' => [
                            'Per niente',
                            'Poco',
                            'Abbastanza',
                            'Molto',
                        ],
                        'options' => [
                            'Utilità',
                            'Adeguatezza',
                            'Ampiezza',
                            'Articolazione',
                            'Completezza',
                        ],
                    ],

                    // ~ Question D.2
                    [
                        'type' => 'grid',
                        'text' => 'Ritieni che la distribuzione delle diverse sezioni nei tre/cinque anni sia',
                        'headers' => [
                            'Per niente',
                            'Poco',
                            'Abbastanza',
                            'Molto',
                        ],
                        'options' => [
                            'Equilibrata',
                            'Efficace',
                            'Ridondante',
                            'Ripetitiva',
                            'Completa in alcune aree',
                            'Incompleta in alcune aree',
                            'Non ho ancora un’idea precisa, avendo sperimentato solo alcune parti',
                        ],
                    ],

                    // ~ Question D.3
                    [
                        'type' => 'grid',
                        'text' => 'Le sezioni che costituiscono il PROFILO PERSONALE forniscono un quadro',
                        'headers' => [
                            'Per niente',
                            'Poco',
                            'Abbastanza',
                            'Molto',
                        ],
                        'options' => [
                            'Completo',
                            'Equilibrato',
                            'Articolato',
                            'Efficace',
                            'Impegnativo',
                            'Non ho ancora un’idea precisa, avendone sperimentato solo alcune',
                        ],
                    ],

                    // ~ Question D.4
                    [
                        'type' => 'grid',
                        'text' => 'Le sezioni che costituiscono l’area delle COMPETENZE DI BASE risultano',
                        'headers' => [
                            'Per niente',
                            'Poco',
                            'Abbastanza',
                            'Molto',
                        ],
                        'options' => [
                            'Utili',
                            'Adeguate allo scopo',
                            'Numerose',
                            'Impegnative',
                            'Ridondanti rispetto ai saperi disciplinari (italiano)',
                            'Non ho ancora un’idea precisa, avendone sperimentato solo alcune',
                        ],
                    ],

                    // ~ Question D.5
                    [
                        'type' => 'grid',
                        'text' => 'Le due sezioni dei SAPERI INFORMALI sono',
                        'headers' => [
                            'Per niente',
                            'Poco',
                            'Abbastanza',
                            'Molto',
                        ],
                        'options' => [
                            'Utili',
                            'Stimolanti',
                            'Coerenti con l’obiettivo',
                            'Difficili',
                            'Incomplete',
                            'Non ho ancora un’idea precisa, non avendole sperimentate',
                        ],
                    ],

                    // ~ Question D.6
                    [
                        'type' => 'grid',
                        'text' => 'Le sezioni che costituiscono l’area SCEGLIERE sono risultate',
                        'headers' => [
                            'Per niente',
                            'Poco',
                            'Abbastanza',
                            'Molto',
                        ],
                        'options' => [
                            'Utili',
                            'Stimolanti',
                            'Lunghe',
                            'Farraginose',
                            'Complete',
                        ],
                    ],

                    // ~ Question D.7
                    [
                        'type' => 'grid',
                        'text' => 'Le attività di autoverifica (“Mettiti alla prova”), presenti in diverse sezioni, sono',
                        'headers' => [
                            'Per niente',
                            'Poco',
                            'Abbastanza',
                            'Molto',
                        ],
                        'options' => [
                            'Utili',
                            'Ponderate',
                            'Impegnative',
                            'Difficili',
                            'Non ho ancora un’idea precisa',
                        ],
                    ],

                    // ~ Question D.8
                    [
                        'type' => 'grid',
                        'text' => 'L’ambiente dedicato al docente (“Funzionalità per l’insegnante”) è risultato essere',
                        'headers' => [
                            'Per niente',
                            'Poco',
                            'Abbastanza',
                            'Molto',
                        ],
                        'options' => [
                            'Ben strutturato',
                            'Di facile gestione',
                            'Utile',
                            'Completo',
                            'Non ho ancora un’idea precisa',
                        ],
                    ],

                    // ~ Question D.9
                    [
                        'type' => 'grid',
                        'text' => 'Le schede di approfondimento teorico (“Saperne di più” e “Glossario”) risultano',
                        'headers' => [
                            'Per niente',
                            'Poco',
                            'Abbastanza',
                            'Molto',
                        ],
                        'options' => [
                            'Utili',
                            'Efficaci',
                            'Complesse',
                            'Approfondite',
                            'Non ho ancora un’idea precisa',
                        ],
                    ],

                    // ~ Question D.10
                    [
                        'type' => 'grid',
                        'text' => 'Le schede di interpretazione dei risultati (“Saperne di più” studente) risultano',
                        'headers' => [
                            'Per niente',
                            'Poco',
                            'Abbastanza',
                            'Molto',
                        ],
                        'options' => [
                            'Utili',
                            'Necessarie',
                            'Efficaci',
                            'Complesse',
                            'Approfondite',
                            'Non ho ancora un’idea precisa',
                        ],
                    ],

                    // ~ Question D.11
                    [
                        'type' => 'grid',
                        'text' => 'I questionari in ingresso e finale (terza media e quarta/quinta superiore) risultano',
                        'headers' => [
                            'Per niente',
                            'Poco',
                            'Abbastanza',
                            'Molto',
                        ],
                        'options' => [
                            'Ben strutturati',
                            'Utili',
                            'Articolati',
                            'Lunghi',
                            'Non ho ancora un’idea precisa',
                        ],
                    ],
                ],
            ],

            // * SECTION E
            [
                'title' => 'Valutazione del Percorso di Formazione/Sperimentazione',
                'questions' => [
                    // ~ Question E.1
                    [
                        'type' => 'grid',
                        'text' => 'Il percorso di 12 ore con l’esperto più 8 ore di progettazione personale è stato',
                        'headers' => [
                            'Per niente',
                            'Poco',
                            'Abbastanza',
                            'Molto',
                        ],
                        'options' => [
                            'Utile',
                            'Adeguato allo scopo',
                            'Lungo',
                            'Breve',
                            'Ben distribuito',
                        ],
                    ],

                    // ~ Question E.2
                    [
                        'type' => 'grid',
                        'text' => 'Gli incontri con l’esperto Iprase sono stati',
                        'headers' => [
                            'Per niente',
                            'Poco',
                            'Abbastanza',
                            'Molto',
                        ],
                        'options' => [
                            'Necessari per comprendere meglio lo strumento',
                            'Utili dal punto di vista formativo',
                            'Stimolanti per l’utilizzo didattico',
                            'Interattivi',
                            'Coinvolgenti',
                        ],
                    ],

                    // ~ Question E.3
                    [
                        'type' => 'grid',
                        'text' => 'Penso che lo sviluppo, durante gli incontri, di alcune tematiche (problem solving, differenze) sia',
                        'headers' => [
                            'Per niente',
                            'Poco',
                            'Abbastanza',
                            'Molto',
                        ],
                        'options' => [
                            'Utile per sfruttare al meglio la piattaforma',
                            'Ridondante',
                            'Stimolante',
                            'Utile per un confronto fra gli sperimentatori',
                        ],
                    ],
                ],
            ],

            // * SECTION F
            [
                'title' => 'Risposte Aperte e Proposte',
                'questions' => [
                    // ~ Question F.1
                    [
                        'type' => 'open',
                        'text' => 'Le parti che convincono di più sono (in ordine decrescente di importanza)',
                    ],

                    // ~ Question F.2
                    [
                        'type' => 'open',
                        'text' => 'Le parti che convincono di meno sono (in ordine decrescente)',
                    ],

                    // ~ Question F.3
                    [
                        'type' => 'open',
                        'text' => 'Le parti che andrebbero tolte sono',
                    ],

                    // ~ Question F.4
                    [
                        'type' => 'open',
                        'text' => 'Le parti che andrebbero aggiunte sono',
                    ],

                    // ~ Question F.5
                    [
                        'type' => 'radio-rows',
                        'text' => 'Ritieni utile estendere questa proposta orientativa a tutta la scuola trentina?',
                        'options' => [
                            'Sì',
                            'No',
                            'Non so',
                        ],
                    ],
                ],
            ],
        ];

        return view('surveys.highschool2024.index')->with('questionAreas', $questionAreas);
    }

    /**
     * * Action: Store
     */
    public function store(Request $request): RedirectResponse
    {
        $results = $request->all();
        $results = array_filter($results);
        $results = json_encode($results);

        SurveyHighschool_2024Result::updateOrCreate(
            [
                'teacher_id' => auth()->id(),
            ],
            [
                'results' => $results,
            ]
        );

        return redirect()->route('home');
    }
}
