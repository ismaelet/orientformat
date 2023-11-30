<?php

$configDashboardGraphs = [
	'search-filters' => [
		[
			'title' => 'Dividi i risultati per',
			'slug' => 'divideBy',
			'list' => [
				[
					'title' => 'Sicurezza nella scelta',
					'slug' => 'decided'
				],
				[
					'title' => 'Titolo di studio dei genitori',
					'slug' => 'degree'
				],
				[
					'title' => 'Genere',
					'slug' => 'gender'
				],
			]
		],
		[
			'title' => 'Mostra solo',
			'slug' => 'filterBy',
			'list' => [
				[
					'title' => 'Gli studenti che riguardo alla scelta si sentono',
					'slug' => 'decided',
					'list' => [
						['Molto indecisi', 1],
						['Abbastanza indecisi', 2],
						['Abbastanza decisi', 3],
						['Molto decisi', 4],
						['Sicuri', 5],
					],
				],
				[
					'title' => 'Gli studenti con genitori con titolo di studio',
					'slug' => 'degree',
					'list' => [
						['Non indicato', 1],
						['Licenza elementare', 2],
						['Licenza media', 3],
						['Diploma o una qualifica professionale', 4],
						['Laurea', 5],
					],
				],
				[
					'title' => 'Gli studenti che sono',
					'slug' => 'gender',
					'list' => [
						['Maschi', 1],
						['Femmine', 2],
					],
				],
			]
		]
	],
];
