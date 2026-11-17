@php
    $schools = [
        ['Scuola secondaria', 1],
        ['Laurea<br><strong>3 anni</strong>', 2],
        ['Master I livello<br><strong>1/2 anni</strong>', 3],
        ['Corso di<br>perfezionamento<br><strong>1/2 anni</strong>', 3],
        ['Laurea a ciclo unico<br><strong>5/6 anni</strong>', 2],
        ['Laurea magistrale<br><strong>2 anni</strong>', 3],
        ['Dottorato (PhD)<br><strong>3 anni</strong>', 4],
        ['Scuola di<br>specializzazione<br><strong>2/5 anni</strong>', 4],
        ['Master di II livello<br><strong>1/2 anni</strong>', 4],
    ];
@endphp

@pushOnce('styles')
    <style>
        .school-types {
            grid-template-columns: repeat(4, minmax(0, 1fr));
            grid-auto-rows: 1fr;
            gap: 4rem min(2rem, 3vw);
        }

        @media (min-width: 769px) {
            .school-types {
                grid-template-columns: repeat(9, minmax(0, 1fr));
            }
        }

        .school-type {
            display: grid;
            align-items: center;
            position: relative;
            z-index: 1;
            padding: min(1rem, 5vw) min(1rem, 3vw);
            background-color: #ddd;
            border-radius: var(--radius-md);
            box-shadow: var(--shadow);
            text-align: center;
        }

        .school-type.school-type--1 {
            background-color: var(--color-tertiary-400);
            color: #fff;
        }

        .school-type.school-type--2 {
            background-color: var(--color-tertiary-100);
        }

        .school-type.school-type--3 {
            background-color: var(--color-secondary-300);
            color: #fff;
        }

        .school-type.school-type--4 {
            background-color: var(--color-primary-200);
        }

        .school-type p {
            word-break: break-all;
            font-size: min(var(--text-lg), 3vw);
            font-weight: var(--font-weight-semibold);
        }

        @media (min-width: 769px) {
            .school-type {
                grid-row: span 2;
            }
        }

        .school-type:nth-child(1) {
            grid-column: 2 / 4;
        }

        @media (min-width: 769px) {
            .school-type:nth-child(1) {
                grid-column: 2 / 4;
            }
        }

        .school-type:nth-child(2) {
            grid-column: 3 / 5;
        }

        @media (min-width: 769px) {
            .school-type:nth-child(2) {
                grid-row: 4 / 6;
                grid-column: 3 / 5;
            }
        }

        .school-type:nth-child(3) {
            grid-column: 2 / 3;
        }

        @media (min-width: 769px) {
            .school-type:nth-child(3) {
                grid-row: 5 / 7;
                grid-column: 6 / 8;
            }
        }

        .school-type:nth-child(4) {
            grid-column: 3 / 4;
        }

        @media (min-width: 769px) {
            .school-type:nth-child(4) {
                grid-row: 5 / 7;
                grid-column: 8 / -1;
            }
        }

        .school-type:nth-child(5) {
            grid-row: 2;
            grid-column: 1 / 3;
        }

        @media (min-width: 769px) {
            .school-type:nth-child(5) {
                grid-row: 6 / 8;
                grid-column: 1 / 3;
            }
        }

        @media (min-width: 769px) {
            .school-type:nth-child(6) {
                grid-row: 6 / 8;
                grid-column: 3 / 5;
            }
        }

        @media (min-width: 769px) {
            .school-type:nth-child(7) {
                grid-row: 9 / 11;
                grid-column: 2 / 4;
            }
        }

        @media (min-width: 769px) {
            .school-type:nth-child(8) {
                grid-row: 9 / 11;
                grid-column: 4 / 6;
            }
        }

        @media (min-width: 769px) {
            .school-type:nth-child(9) {
                grid-row: 9 / 11;
                grid-column: 6 / 8;
            }
        }

        .info__title {
            margin-block: 1em 0.3em;
            font-size: var(--text-800);
            font-weight: var(--font-weight-semibold);
        }

        .info__subtitle {
            margin-block: 1em 0.3em;
            font-size: var(--text-2xl);
            font-style: italic;
        }
        .info__title + .info__subtitle {
            margin-top: 0;
        }

        .info__text {
            font-size: var(--text-lg);
            line-height: 1.8;
            text-align: justify;
        }
    </style>
@endpushOnce

@pushOnce('scripts')
    @vite('resources/js/tests/formazione-post-diploma.js')
@endpushOnce

<x-layouts.main :$title>
    <div class="test__body mt-20 mb-20 grid grid-cols-1 gap-8">
        <x-test.title class="text-center" :test="$test" />

        <x-button
            class="mx-auto"
            variant="secondary"
            href="{{ is_teacher_or_administrator() ? route('teacher.simulation') : route('activities.grades.show', 3) }}"
        >Indietro</x-button>

        <div class="schools-types__wrapper">
            <div class="school-types grid">
                @foreach ($schools as $school)
                    <div class="school-type school-type--{{ $school[1] }}">
                        <p>{!! $school[0] !!}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="info">
            <p class="info__text">
                Il sistema di formazione universitaria si compone di <strong>tre cicli</strong> che comprendono corsi di
                diversa durata.<br /><br />
                L’accesso ai corsi richiede il possesso di requisiti specifici.<br /><br />
                Per completare un percorso di studi è previsto il raggiungimento di un certo numero di CFU, i
                <strong>crediti formativi universitari</strong> che quantificano l’impegno di studio richiesto.
            </p>

            <h3 class="info__title">Primo ciclo</h3>
            <p class="info__text">
                É costituito esclusivamente dai <strong>Corsi di Laurea</strong>. Essi hanno l'obiettivo di assicurare
                agli studenti un'adeguata padronanza di metodi e contenuti scientifici generali e l'acquisizione di
                specifiche conoscenze professionali. Requisito minimo per l'accesso è il diploma finale di scuola
                secondaria, rilasciato al completamento di 13 anni di scolarità complessiva e dopo il superamento del
                relativo esame di Stato, o un titolo estero comparabile; l'ammissione può essere subordinata alla
                verifica di ulteriori condizioni. I corsi hanno durata triennale. Per conseguire il titolo di Laurea, lo
                studente deve aver acquisito 180 Crediti Formativi Universitari (CFU), equivalenti ai crediti ECTS; può
                essere richiesto un periodo di tirocinio e la discussione di una tesi o la preparazione di un elaborato
                finale.<br /><br />
                Il titolo di Laurea dà accesso alla Laurea Magistrale e agli altri corsi di 2° ciclo.
            </p>

            <h3 class="info__title">Secondo ciclo</h3>
            <p class="info__text">
                I principali corsi di 2° ciclo sono quelli di <strong>Laurea Magistrale</strong>; essi offrono una
                formazione di livello avanzato per l'esercizio di attività di elevata qualificazione in ambiti
                specifici. L'accesso ai corsi è subordinato al possesso di una Laurea o di un titolo estero comparabile;
                l'ammissione è soggetta a requisiti specifici decisi dalle singole università. I corsi hanno durata
                biennale. Per conseguire il titolo di Laurea Magistrale, lo studente deve aver acquisito 120 crediti
                (CFU) e aver elaborato e discusso una tesi di ricerca. Alcuni corsi (Medicina e Chirurgia, Medicina
                veterinaria, Odontoiatria e Protesi dentaria, Farmacia e Farmacia industriale, Architettura e Ingegneria
                edile-architettura, Giurisprudenza, Scienze della formazione primaria) sono definiti “ Corsi di Laurea
                Magistrale a ciclo unico ”: requisito di <strong>accesso</strong> è il diploma di scuola secondaria
                superiore o un titolo estero comparabile; l'ammissione è subordinata a una prova di selezione; gli studi
                si articolano su 5 anni (6 anni e 360 ​​CFU per Medicina e Chirurgia e per Odontoiatria e protesi
                dentaria). Per conseguire il titolo di Laurea Magistrale lo studente deve quindi aver acquisito 300 CFU
                e aver elaborato e discusso una tesi di ricerca.<br /><br />
                Il titolo di Laurea Magistrale dà accesso al Dottorato di Ricerca e agli altri corsi di 3° ciclo.
            </p>

            <h3 class="info__title">Terzo ciclo</h3>
            <p class="info__text">
                I principali corsi di 3° ciclo sono quelli di <strong>Dottorato di Ricerca</strong>; essi hanno
                l'obiettivo di far acquisire una corretta metodologia per la ricerca scientifica avanzata, adottando
                metodologie innovative e nuove tecnologie, prevedendo stage all'estero e la frequenza di laboratori di
                ricerca. L'ammissione richiede una Laurea Magistrale (o un titolo estero comparabile) e il superamento
                di un concorso; la durata è di minimo 3 anni. Il dottorando deve elaborare una tesi originale di ricerca
                e discuterla durante l'esame finale.
            </p>

            <h3 class="info__title">Altri corsi</h3>

            <p class="info__subtitle">Corsi di Specializzazione</p>
            <p class="info__text">
                Sono corsi di 3° ciclo aventi l'obiettivo di fornire conoscenze e abilità per l'esercizio di attività
                professionali di alta qualificazione, particolarmente nel settore delle specialità mediche, cliniche e
                chirurgiche. Per l'ammissione è richiesta una Laurea Magistrale (o un titolo estero comparabile) e il
                superamento di un concorso; la durata degli studi varia da 2 (120 CFU) a 6 anni (360 CFU) in rapporto al
                settore disciplinare.<br /><br />
                Il titolo finale rilasciato è il Diploma di Specializzazione.
            </p>

            <p class="info__subtitle">Master universitario di primo livello</p>
            <p class="info__text">
                Sono corsi di 2° ciclo di perfezionamento scientifico o di alta formazione permanente e ricorrente. Vi
                si accede con una Laurea o con un titolo estero comparabile. La durata minima è annuale (60 CFU); non
                consente l'accesso a corsi di Dottorato di Ricerca e di 3°ciclo, perché il corso non ha ordinamento
                didattico nazionale e il titolo è rilasciato sotto la responsabilità autonoma della singola università.
                Il titolo finale è il Master universitario di primo livello.
            </p>

            <p class="info__subtitle">Master Universitario di secondo livello</p>
            <p class="info__text">
                Sono corsi di 3° ciclo di perfezionamento scientifico o di alta formazione permanente e ricorrente. Vi
                si accede con una Laurea Magistrale o con un titolo estero comparabile. La durata è minima annuale (60
                CFU); non consente l'accesso a corsi di Dottorato di Ricerca e di 3° ciclo, perché il corso non ha
                ordinamento didattico nazionale e il titolo è rilasciato sotto la responsabilità autonoma della singola
                università. Il titolo finale è il Master universitario di secondo livello.
            </p>
        </div>
    </div>
</x-layouts.main>
