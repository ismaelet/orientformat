@php
    $schools = [
        ['secondary', 'Scuola secondaria di I grado', 'start', 1, '3 / 5', ['liceo', 'tecnico', 'professionale']],
        ['liceo', 'LICEO', 'liceo', 2, '1 / 3', ['liceo-5', 'liceo-4']],
        ['tecnico', 'ISTITUTO TECNICO', 'tecnico', 2, '3 / 5', ['tecnico-5', 'tecnico-4']],
        ['professionale', 'ISTRUZIONE E FORMAZIONE PROFESSIONALE', 'professionale', 2, '5 / 7', ['professionale-3', 'professionale-2']],
        ['liceo-5', 'Quinquennale', 'liceo', 3, '1', ['diploma']],
        ['liceo-4', 'Quadriennale', 'liceo', 3, '2', ['diploma']],
        ['tecnico-5', 'Quinquennale', 'tecnico', 3, '3', ['diploma']],
        ['tecnico-4', 'Quadriennale', 'tecnico', 3, '4', ['diploma']],
        ['professionale-3', '3 + 1', 'professionale', 3, '5', ['qualifica', 'diploma-professionale']],
        ['professionale-2', '2 + 2', 'professionale', 3, '6', ['diploma-professionale']],
        ['qualifica', '3 anni: Qualifica professionale', 'professionale', 4, '5', ['capes']],
        ['diploma-professionale', '4 anni: Diploma professionale', 'professionale', 4, '6', ['capes']],
        ['diploma', 'Diploma di istruzione secondaria di secondo grado («maturità»)', 'qualification', 5, '2 / 4', ['universita', 'its']],
        ['capes', '5° anno: CAPES — Diploma di maturità professionale', 'qualification', 5, '5 / 7', ['universita', 'its']],
        ['universita', 'Università', 'destination', 6, '2 / 4', []],
        ['its', 'Istituti Tecnici Superiori (ITS Academy)', 'destination', 6, '4 / 6', []],
    ];
@endphp

@pushOnce('styles')
    <style>
        .medie-pathways-scroll {
            overflow-x: auto;
            padding-block: 1rem 2rem;
        }

        .medie-pathways {
            position: relative;
            display: grid;
            grid-template-columns: repeat(6, minmax(0, 1fr));
            gap: 4rem 1.5rem;
            min-width: 56rem;
        }

        .medie-pathway {
            position: relative;
            z-index: 1;
            display: grid;
            align-items: center;
            padding: 1rem;
            border-radius: var(--radius-md);
            background: var(--color-primary-400);
            color: var(--color-tertiary-400);
            box-shadow: var(--shadow);
            text-align: center;
            font-size: var(--text-lg);
            font-weight: var(--font-weight-semibold);
            overflow-wrap: anywhere;
        }

        .medie-pathway--start {
            background: var(--color-secondary-400);
            font-size: var(--text-2xl);
            color: var(--color-neutral-50);
        }

        .medie-pathway--liceo {
            background: var(--color-tertiary-100);
        }

        .medie-pathway--tecnico {
            background: var(--color-secondary-300);
            color: var(--color-neutral-50);
        }

        .medie-pathway--professionale {
            background: var(--color-transition-400);
        }

        .medie-pathway--qualification {
            background: var(--color-tertiary-400);
            color: var(--color-neutral-50);
        }

        .medie-pathways__connections {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            overflow: visible;
            pointer-events: none;
            color: var(--color-tertiary-300);
        }

        .medie-info {
            display: grid;
            gap: 1.5rem;
            font-size: var(--text-lg);
            line-height: 1.8;
        }
    </style>
@endpushOnce

@pushOnce('scripts')
    @vite('resources/js/tests/formazione-medie.js')
@endpushOnce

<x-layouts.main :$title>
    <div class="test__body mt-20 mb-20 grid grid-cols-1 gap-8">
        <x-test.title class="text-center" :test="$test" description="E dopo la scuola media cosa fare?" />

        <x-button
            class="mx-auto"
            variant="secondary"
            href="{{ is_teacher_or_administrator() ? route('teacher.simulation') : route('activities.grades.show', student()->class->grade()) }}"
        >Indietro</x-button>

        <div
            class="medie-pathways-scroll"
            role="region"
            aria-label="Percorsi di formazione dopo la scuola secondaria di primo grado"
            tabindex="0"
        >
            <div class="medie-pathways">
                <svg class="medie-pathways__connections" aria-hidden="true">
                    <defs>
                        <marker id="medie-arrow" viewBox="0 0 10 10" refX="9" refY="5" markerWidth="6" markerHeight="6" orient="auto-start-reverse">
                            <path d="M 0 0 L 10 5 L 0 10 z" fill="currentColor" />
                        </marker>
                    </defs>
                </svg>
                @foreach ($schools as [$id, $label, $type, $row, $column, $destinations])
                    <div
                        id="medie-{{ $id }}"
                        class="medie-pathway medie-pathway--{{ $type }}"
                        style="grid-row: {{ $row }}; grid-column: {{ $column }}"
                        data-destinations="{{ implode(' ', $destinations) }}"
                    >
                        <p>{{ $label }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="medie-info">
            <p>
                I <strong>licei quinquennali</strong> - Classico, Scientifico (con opzione Scienze Applicate o a
                Indirizzo Sportivo), Linguistico, Scienze Umane (anche Economico-Sociale), Artistico, Musicale e
                Coreutico - una volta conseguito il diploma di istruzione secondaria di secondo grado (“maturità”),
                danno accesso all’università e agli Istituti Tecnici Superiori (ITS Academy): l'ammissione non è
                automatica, ma richiede il superamento di una selezione basata su un test scritto, un colloquio
                motivazionale e la valutazione del voto di maturità.
            </p>
            <p>
                In Trentino, i <strong>licei quadriennali</strong> sono quattro: Delle Arti (“Vittoria-Bonporti-Depero”
                di Trento e Rovereto), Scientifico (“Martino Martini” di Mezzolombardo), Percorso STEAM con curricolo
                internazionale (Giuseppe Veronesi” di Rovereto) e Liceo delle Scienze Umane (Istituto “Sacro cuore” di
                Trento).
            </p>
            <p>
                Gli <strong>istituti tecnici</strong> si suddividono in due settori principali:
                <strong>settore Tecnologico</strong> (Meccatronica, Informatica e Telecomunicazioni, Costruzioni
                Ambiente e Territorio, Chimica e Biotecnologie, Elettronica ed Elettrotecnica), e
                <strong>settore Economico</strong> (Amministrazione, Finanza e Marketing, Turismo). Negli istituti
                tecnici e professionali viene introdotto progressivamente il
                <strong>modello quadriennale 4+2</strong> (Filiera tecnologico-professionale): gli studenti affrontano 4
                anni di scuola secondaria e ottengono l'accesso diretto e preferenziale ai 2 anni successivi negli ITS
                Academy, creando un canale diretto verso l'alta specializzazione terziaria.
            </p>
            <p>
                L’<strong>Istruzione e Formazione Professionale</strong> in Trentino offre diverse possibilità: col
                <strong>percorso triennale</strong> si ottiene una Qualifica professionale; con un anno integrativo
                (<strong>3+1</strong>), si consegue il Diploma professionale. 15 dei 33 istituti professionali trentini
                prevedono il <strong>passaggio</strong> progressivo al <strong>modello 2+2</strong>, quindi un
                <strong>percorso quadriennale</strong> al termine del quale si consegue il Diploma professionale di
                Tecnico. Dopo il percorso quadriennale e il conseguimento del diploma, si può frequentare il quinto anno
                CAPES (Corso Annuale per l’Esame di Stato); il Diploma di maturità professionale dà diritto di accesso
                all’università e agli ITS Academy.
            </p>
        </div>
    </div>
</x-layouts.main>
