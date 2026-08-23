<?php

namespace App\Support\Graphs;

use App\Models\Activities\Section;
use App\Support\Graphs\SectionGraphDefinition;
use RuntimeException;

final class GraphSections {

    public const NORMALIZATION_RAW = 'raw';

    public const NORMALIZATION_TIER_PERCENTAGE = 'tier_percentage';

    public const TYPE_NAMED_PERCENTAGE = 'named_percentage';

    public const TYPE_TIER = 'tier';

    public const TYPE_FIXED_SCORE = 'fixed_score';

    public const DEFAULT_GRAPH_KEY = 'default';

    public const DEFAULT_TIER_DESCRIPTION =
    'Qui puoi vedere come si distribuiscono i risultati della classe in questa sezione, in base al livello raggiunto dagli studenti: basso, medio, alto e così via. Se, ad esempio, la colonna “alto” è più alta delle altre, significa che la maggior parte degli studenti ha ottenuto un buon punteggio in questa sezione. Passa il mouse sopra le colonne per vedere il numero di studenti in ciascun livello.';

    public const CONDENSED_MAX = 'max';

    public const CONDENSED_AVERAGE = 'average';

    public const CONDENSED_STUDENT_AVERAGE = 'student_average';

    public const DEFAULT_CLASS_DATASET_LABEL =
    'Risultato della classe';

    public const DEFAULT_PLATFORM_DATASET_LABEL =
    'Risultato della piattaforma';

    public const DEFAULT_TIER_CLASS_DATASET_LABEL =
    'Studenti della classe in questa fascia';

    public const DEFAULT_CONDENSED_LABEL = 'Risultato medio:';

    public const PROBLEMI_GRUPPO_GRAPH_KEY = 'problemi-gruppo';

    public const DISTRAIBILITA_IPERATTIVITA_GRAPH_KEY = 'distraibilita-iperattivita';

    /**
     * Graph section IDs grouped by aggregation type.
     *
     * @var array<string, array<int>>
     */
    private const SECTIONS = [
        self::TYPE_NAMED_PERCENTAGE => [
            1,
            4,
            6,
            7,
            8,
            17,
            24,
            27,
            28,
            29,
            36,
            37,
            41,
            45,
        ],

        self::TYPE_TIER => [
            3,
            5,
            9,
            10,
            11,
            12,
            14,
            30,
            31,
            32,
            33,
            39,
            40,
        ],

        self::TYPE_FIXED_SCORE => [
            34,
        ],
    ];

    /**
     * The definition of each graph section, including its aggregation type and condensed label
     */
    private const DEFINITIONS = [
        1 => [
            'condensed_type' => self::CONDENSED_MAX,
            'condensed_label' =>
            'Stile prevalente nella classe:',
            'condensed_label_plural' =>
            'Stili prevalenti nella classe:',
        ],
        3 => [
            'normalization' =>
            self::NORMALIZATION_TIER_PERCENTAGE,
            'condensed_label' =>
            'Tasso di resilienza medio:',
        ],
        4 => [
            'condensed_type' => self::CONDENSED_AVERAGE,
            'condensed_label' =>
            'Livello medio di autostima nella classe:',
        ],
        5 => [
            'condensed_label' =>
            'Risultato medio della classe:',
        ],
        6 => [
            'condensed_label' =>
            'Stile attributivo più marcato nella classe:',
            'description' => "Qui puoi vedere a chi o cosa mediamente gli studenti della classe attribuiscono i propri successi e insuccessi."
        ],
        7 => [
            'condensed_label' =>
            'Area che suscita più interesse nella classe:',
        ],
        8 => [
            'condensed_label' =>
            'Temperamento più pronunciato:',
        ],
        9 => [
            'condensed_label' =>
            'Risultato medio delle autovalutazioni:',
        ],
        10 => [
            'normalization' =>
            self::NORMALIZATION_TIER_PERCENTAGE,
            'condensed_label' =>
            'Risultato medio delle autovalutazioni e degli esercizi:',
        ],
        11 => [
            'normalization' =>
            self::NORMALIZATION_TIER_PERCENTAGE,
            'condensed_label' =>
            'Risultato medio delle attività:',
        ],
        12 => [
            'normalization' =>
            self::NORMALIZATION_TIER_PERCENTAGE,
            'condensed_label' =>
            'Risultato medio delle attività:',
        ],
        14 => [
            'condensed_label' =>
            'Risultato medio delle attività:',
        ],
        24 => [
            'condensed_label' =>
            'Interesse prevalente:',
        ],
        27 => [
            'condensed_label' => 'Emozione più pronunciata nella classe:',
            'condensed_label_plural' => 'Emozioni più pronunciate nella classe:',
            'description' => 'Qui sono rappresentate le emozioni più o meno sentite dagli alunni della classe.',
            'class_dataset_label' => 'Intensità dell’emozione nella classe',
            'platform_dataset_label' => 'Intensità media dell’emozione sulla piattaforma',
        ],
        28 => [
            'condensed_type' => self::CONDENSED_MAX,
            'condensed_label' => 'Stile prevalente nella classe:',
            'condensed_label_plural' => 'Stili prevalenti nella classe:',
            'class_dataset_label' => 'Prevalenza dello stile nella classe',
            'platform_dataset_label' => 'Prevalenza media dello stile sulla piattaforma',
        ],
        29 => [
            'condensed_type' => self::CONDENSED_AVERAGE,
            'condensed_label' =>
            'Livello medio di autostima nella classe:',
            'description' => 'Qui puoi vedere come si distribuisce il livello di autostima della classe in aree diverse',
        ],
        30 => [
            'condensed_label' =>
            'Risultato medio delle attività:',
        ],
        31 => [
            'condensed_label' =>
            'Risultato medio delle attività:',
        ],
        32 => [
            'normalization' =>
            self::NORMALIZATION_TIER_PERCENTAGE,
            'condensed_label' =>
            'Risultato medio dell’autovalutazione e attività:',
        ],
        33 => [
            'normalization' =>
            self::NORMALIZATION_TIER_PERCENTAGE,
            'condensed_label' =>
            'Risultato medio delle attività:',
        ],
        34 => [
            'condensed_label' => 'Stile di scrittura più usato nella classe:',
            'condensed_label_plural' => 'Stili di scrittura più usati nella classe:',
            'class_dataset_label' => 'Percentuale di uso dello stile nella classe',
            'platform_dataset_label' => 'Percentuale di uso dello stile sulla piattaforma',
            'description' => 'Qui puoi vedere quali stili di scrittura sono mediamente più o meno usati dagli alunni della classe.',
        ],
        36 => [
            'condensed_type' => self::CONDENSED_MAX,
            'condensed_label' =>
            'Stile prevalente nella classe:',
            'condensed_label_plural' =>
            'Stili prevalenti nella classe:',
        ],
        37 => [
            'condensed_type' => self::CONDENSED_MAX,
            'condensed_label' =>
            'Stile prevalente nella classe:',
            'condensed_label_plural' =>
            'Stili prevalenti nella classe:',
        ],
        39 => [
            'condensed_label' =>
            'Risultato medio delle attività:',
        ],
        40 => [
            'condensed_label' =>
            'Risultato medio delle attività:',
        ],
        41 => [
            'condensed_type' => self::CONDENSED_AVERAGE,
            'condensed_label' =>
            'Livello medio di autostima nella classe:',
        ],
        45 => [
            'condensed_label' =>
            'Interesse prevalente:',
        ],
    ];

    private const GRAPHS = [
        5 => [
            [
                'key' => self::DEFAULT_GRAPH_KEY,
                'type' => self::TYPE_TIER,
                'test_ids' => null,
            ],
            [
                'key' => self::PROBLEMI_GRUPPO_GRAPH_KEY,
                'type' => self::TYPE_NAMED_PERCENTAGE,
                'test_ids' => [218],

                'title' => 'Risolvere problemi in gruppo',

                'description' => 'Qui puoi vedere quali ruoli sono più o meno adottati dagli studenti quando si trovano ad affrontare problemi in gruppo.',

                'school_class_dataset_label' => 'Prevalenza del ruolo nella classe',
                'platform_dataset_label' => 'Prevalenza del ruolo nella piattaforma',

                'condensed_type' => self::CONDENSED_MAX,
                'condensed_label' => 'Ruolo in cui si identificano più studenti della classe:',
                'condensed_plural_label' => 'Ruoli in cui si identificano più studenti della classe:',
            ],
        ],

        9 => [
            [
                'key' => self::DEFAULT_GRAPH_KEY,
                'type' => self::TYPE_TIER,
                'test_ids' => [16],
                'condensed_label' => 'Risultato medio dell\'autovalutazione:',
            ],
            [
                'key' => self::DISTRAIBILITA_IPERATTIVITA_GRAPH_KEY,
                'type' => self::TYPE_NAMED_PERCENTAGE,
                'test_ids' => [17],

                'description' => 'Qui puoi vedere quali sono i tassi di distraibilità e di iperattività medi nella classe.',
            ],
        ],

        17 => [
            [
                'key' => self::DEFAULT_GRAPH_KEY,
                'type' => self::TYPE_NAMED_PERCENTAGE,
                'description' => 'Qui puoi vedere quali sono i tipi di pensiero più o meno presenti nella classe.',
                'condensed_label' => 'Tipo di pensiero più presente nella classe:',
                'condensed_plural_label' => 'Tipi di pensiero più presenti nella classe:',
            ],
        ],

        24 => [
            [
                'key' => self::DEFAULT_GRAPH_KEY,
                'type' => self::TYPE_NAMED_PERCENTAGE,
                'description' => 'Qui puoi vedere quali aree suscitano più o meno interesse nella classe, nell\'ambito della scelta di un percorso di studi futuro.',
                'condensed_label' => 'Area che risulta mediamente più interessante nella classe:',
                'condensed_plural_label' => 'Aree che risultano mediamente più interessanti nella classe:',
            ],
        ],

        27 => [
            [
                'key' => 'emotions',
                'type' => self::TYPE_NAMED_PERCENTAGE,
                'test_ids' => [116],
            ],
        ],

        34 => [
            [
                'key' => 'scrivere-semplificato',
                'type' => self::TYPE_FIXED_SCORE,
                'test_ids' => [62],
            ],
        ],
    ];

    /**
     * Return all supported graph section IDs.
     *
     * @return array<int>
     */
    public static function ids(): array {
        return array_values(
            array_unique(
                array_merge(
                    ...array_values(self::SECTIONS),
                ),
            ),
        );
    }

    /**
     * Return all section IDs for an aggregation type
     */
    public static function idsForType(string $type): array {
        return self::SECTIONS[$type]
            ?? throw new RuntimeException(
                "Unsupported graph aggregation type [{$type}].",
            );
    }

    /**
     * Return all graphs for a section ID
     */
    public static function graphsForSection(
        int $sectionId,
    ): array {
        return self::GRAPHS[$sectionId] ?? [
            [
                'key' => self::DEFAULT_GRAPH_KEY,
                'type' => self::typeForSection(
                    $sectionId,
                ),
                'test_ids' => null,
            ],
        ];
    }

    /**
     * Return a specific graph for a section ID and graph key
     */
    public static function graphForSection(
        int $sectionId,
        ?string $graphKey = null,
    ): array {
        $graphs = self::graphsForSection(
            $sectionId,
        );

        if ($graphKey === null) {
            return $graphs[0];
        }

        foreach ($graphs as $graph) {
            if ($graph['key'] === $graphKey) {
                return $graph;
            }
        }

        throw new \InvalidArgumentException(
            sprintf(
                'Graph [%s] is not defined for section [%d].',
                $graphKey,
                $sectionId,
            ),
        );
    }

    /**
     * Return all graph definitions for a section
     */
    public static function graphDefinitionsForSection(
        Section $section,
    ): array {
        return array_map(
            static fn(array $config): SectionGraphDefinition =>
            SectionGraphDefinition::fromArray(
                section: $section,
                config: $config,
            ),
            self::graphsForSection($section->id),
        );
    }

    /**
     * Return a specific graph definition for a section and graph key
     */
    public static function graphDefinitionForSection(
        Section $section,
        ?string $graphKey = null,
    ): SectionGraphDefinition {
        $definitions =
            self::graphDefinitionsForSection($section);

        if ($graphKey === null) {
            return $definitions[0];
        }

        foreach ($definitions as $definition) {
            if ($definition->key === $graphKey) {
                return $definition;
            }
        }

        throw new \InvalidArgumentException(
            sprintf(
                'Graph [%s] is not defined for section [%d].',
                $graphKey,
                $section->id,
            ),
        );
    }

    /**
     * Return the aggregation type for a section ID
     */
    public static function typeForSection(int $sectionId): string {
        foreach (self::SECTIONS as $type => $sectionIds) {
            if (in_array($sectionId, $sectionIds, true)) {
                return $type;
            }
        }

        throw new RuntimeException(
            "Unsupported graph section [{$sectionId}].",
        );
    }

    /**
     * Check if a section is supported for graphing
     */
    public static function supports(int $sectionId): bool {
        return in_array(
            $sectionId,
            self::ids(),
            true,
        );
    }

    /**
     * Return the graph-value normalization strategy.
     */
    public static function normalizationForSection(
        int $sectionId,
    ): string {
        return self::DEFINITIONS[$sectionId]['normalization']
            ?? self::NORMALIZATION_RAW;
    }

    /**
     * Return the condensed-result strategy.
     */
    public static function condensedTypeForSection(
        int $sectionId,
    ): string {
        if (
            isset(
                self::DEFINITIONS[$sectionId]['condensed_type'],
            )
        ) {
            return self::DEFINITIONS[$sectionId]['condensed_type'];
        }

        return self::typeForSection($sectionId)
            === self::TYPE_TIER
            ? self::CONDENSED_STUDENT_AVERAGE
            : self::CONDENSED_MAX;
    }

    /**
     * Return the condensed label for a section.
     */
    public static function condensedLabelForSection(
        int $sectionId,
        int $valueCount = 1,
    ): string {
        if ($valueCount > 1) {
            return self::DEFINITIONS[$sectionId]['condensed_label_plural']
                ?? self::DEFINITIONS[$sectionId]['condensed_label']
                ?? self::DEFAULT_CONDENSED_LABEL;
        }

        return self::DEFINITIONS[$sectionId]['condensed_label']
            ?? self::DEFAULT_CONDENSED_LABEL;
    }

    /**
     * Return the optional description displayed above a graph.
     */
    public static function descriptionForSection(
        int $sectionId,
    ): ?string {
        $description =
            self::DEFINITIONS[$sectionId]['description']
            ?? null;

        if ($description !== null) {
            return $description;
        }

        if (
            self::typeForSection($sectionId)
            === self::TYPE_TIER
        ) {
            return self::DEFAULT_TIER_DESCRIPTION;
        }

        return null;
    }

    public static function classDatasetLabelForSection(
        int $sectionId,
    ): string {
        if (
            isset(
                self::DEFINITIONS[$sectionId]['class_dataset_label'],
            )
        ) {
            return self::DEFINITIONS[$sectionId]['class_dataset_label'];
        }

        if (
            self::typeForSection($sectionId)
            === self::TYPE_TIER
        ) {
            return self::DEFAULT_TIER_CLASS_DATASET_LABEL;
        }

        return self::DEFAULT_CLASS_DATASET_LABEL;
    }

    public static function platformDatasetLabelForSection(
        int $sectionId,
    ): string {
        return self::DEFINITIONS[$sectionId]['platform_dataset_label']
            ?? self::DEFAULT_PLATFORM_DATASET_LABEL;
    }
}
