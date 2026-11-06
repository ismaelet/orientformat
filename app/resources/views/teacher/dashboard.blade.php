@pushOnce('styles')
    <link rel="stylesheet" href="{{ asset('css/legacy/teacher-dashboard.css') }}" />

    <style>
        /* Keep dashboard-specific presentation independent of the legacy layout. */
        main:has(.teacher-dashboard) {
            background-color: var(--color-background-500);
        }

        .teacher-dashboard {
            --text-color-strong: var(--color-neutral-text);
            --border-color-fade: var(--color-neutral-border);
            --color-4: var(--color-primary-500);
            --color-5: var(--color-secondary-200);
            --wrap-padding: var(--content-padding);
        }

        .teacher-dashboard .load--fade-in {
            transition:
                translate 0.5s ease-out,
                opacity 0.5s ease-in;
        }

        .teacher-dashboard .js-load.load--fade-in {
            opacity: 0;
            translate: 0 1rem;
        }

        .teacher-dashboard [data-delay='1'] {
            transition-delay: 0.1s;
        }

        .teacher-dashboard [data-delay='2'] {
            transition-delay: 0.2s;
        }

        .teacher-dashboard [data-delay='3'] {
            transition-delay: 0.3s;
        }

        .dashboard-checkbox {
            display: grid;
            grid-template-columns: calc(1.25rem + 2px) minmax(0, 1fr);
            align-items: center;
            gap: 0.5rem;
            position: relative;
            width: fit-content;
            max-width: 100%;
        }

        .dashboard-checkbox input {
            opacity: 0;
            position: absolute;
        }

        .dashboard-checkbox > span {
            display: flex;
            aspect-ratio: 1;
            margin: 2px 0 2px 2px;
            border: 1px solid var(--color-neutral-border);
            border-radius: 50%;
        }

        .dashboard-checkbox > span::after {
            content: '';
            width: 8px;
            aspect-ratio: 1;
            margin: auto;
            opacity: 0;
            background-color: var(--color-primary-500);
            border-radius: inherit;
            transition: opacity 0.2s;
        }

        .dashboard-checkbox:hover > span::after,
        .dashboard-checkbox input:checked + span::after {
            opacity: 1;
        }

        .dashboard-checkbox input:focus-visible + span {
            outline: 2px solid var(--color-secondary-300);
            outline-offset: 2px;
        }

        .dashboard-checkbox p {
            line-height: 1;
        }

        .dashboard-element {
            position: relative;

            &::before {
                content: '';
                position: absolute;
                inset: 0;
                opacity: 0;
                background: linear-gradient(135deg, var(--color-neutral-50), var(--color-neutral-700));
                border-radius: inherit;
                mix-blend-mode: overlay;
                transition: inherit;
            }

            &:hover::before {
                opacity: 1;
            }

            > * {
                position: relative;
            }
        }
    </style>
@endpushOnce

<x-layouts.main :$title>
    {{-- <p class="mb-8 rounded border-2 border-red-600 px-4 py-2 font-medium text-red-700">
		A causa di un problema tecnico
		potremmo non aver ricevuto tutte le richieste di supporto nelle ultime settimane. In caso tu ci abbia scritto, ma
		non abbia ricevuto risposta, ti preghiamo di contattare nuovamente il supporto. Ci scusiamo per il disagio.
	</p> --}}

    <div class="teacher-dashboard page-content breakout">
        <div class="relative">
            {{-- Title --}}
            {{-- <x-heading.main>Funzionalità<br> {{ is_administrator() ? 'di referente' : "per l'insegnante" }}
			</x-heading.main> --}}

            {{-- Join Requests --}}

            @session('success')
                <x-alerts.success> {{ session('success') }} </x-alerts.success>
            @endsession

            @if ($errors->any())
                <div role="alert" class="border-error-400 text-error-500 mb-4 rounded border p-4">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            @if (! empty($notices))
                {{-- Notices --}}
                <section class="elements mt-12">
                    <x-heading.section>Avvisi</x-heading.section>

                    <div class="mt-4 grid grid-cols-1 gap-4">
                        @foreach ($notices['teacher_join_requests'] ?? [] as $joinRequest)
                            @if (! $joinRequest->class)
                                @php
                                    $joinRequest->delete();
                                @endphp
                                @continue
                            @endif
                            <form
                                method="POST"
                                class="grid grid-cols-1 gap-4 rounded border border-dashed border-neutral-400 p-2"
                            >
                                @csrf

                                <p class="text-center">
                                    <strong>{{ $joinRequest->requesting_teacher->full_name }}</strong>
                                    ha richiesto di collaborare alla gestione della classe
                                    <strong>{{ $joinRequest->class->name }}</strong>
                                </p>

                                <div class="flex flex-wrap justify-center gap-4">
                                    <x-button
                                        type="submit"
                                        size="xs"
                                        variant="secondary"
                                        color="success"
                                        formaction="{{ route('classes.teacher.join.accept', $joinRequest) }}"
                                    >Accetta</x-button>
                                    <x-button
                                        type="submit"
                                        size="xs"
                                        variant="secondary"
                                        color="danger"
                                        formaction="{{ route('classes.teacher.join.reject', $joinRequest) }}"
                                    >Rifiuta</x-button>
                                </div>
                            </form>
                        @endforeach

                        @foreach ($notices['student_join_requests'] ?? [] as $joinRequest)
                            <form
                                method="POST"
                                class="grid grid-cols-1 gap-4 rounded border border-dashed border-neutral-400 p-2"
                            >
                                @csrf

                                <p class="text-center">
                                    Lo studente/studentessa
                                    <strong>{{ $joinRequest->requesting_student->full_name }}</strong>
                                    ha richiesto di unirsi alla classe
                                    <strong>{{ $joinRequest->class?->name }}</strong>
                                </p>

                                <div class="flex flex-wrap justify-center gap-4">
                                    <x-button
                                        type="submit"
                                        size="xs"
                                        variant="secondary"
                                        color="success"
                                        formaction="{{ route('classes.student.join.accept', $joinRequest) }}"
                                    >Accetta</x-button>
                                    <x-button
                                        type="submit"
                                        size="xs"
                                        variant="secondary"
                                        color="danger"
                                        formaction="{{ route('classes.student.join.reject', $joinRequest) }}"
                                    >Rifiuta</x-button>
                                </div>
                            </form>
                        @endforeach

                        @foreach ($notices['invite_requests'] ?? [] as $inviteRequest)
                            @if (! $inviteRequest->class)
                                @php
                                    $inviteRequest->delete();
                                @endphp
                                @continue
                            @endif

                            <form
                                method="POST"
                                class="grid grid-cols-1 gap-4 rounded border border-dashed border-neutral-400 p-2"
                            >
                                @csrf

                                <p class="text-center">
                                    Sei stato invitato/a da
                                    <strong>{{ $inviteRequest->inviting_teacher->full_name }}</strong>
                                    a collaborare alla gestione della classe
                                    <strong>{{ $inviteRequest->class->name }}</strong>
                                </p>

                                <div class="flex flex-wrap justify-center gap-4">
                                    <x-button
                                        type="submit"
                                        size="xs"
                                        variant="secondary"
                                        color="success"
                                        formaction="{{ route('classes.invite.accept', $inviteRequest) }}"
                                    >Accetta</x-button>
                                    <x-button
                                        type="submit"
                                        size="xs"
                                        variant="secondary"
                                        color="danger"
                                        formaction="{{ route('classes.invite.reject', $inviteRequest) }}"
                                    >Rifiuta</x-button>
                                </div>
                            </form>
                        @endforeach
                    </div>
                </section>
            @endif

            {{-- Classes --}}
            @if (is_administrator())
                <x-heading.section class="mb-12">Funzionalità di referente</x-heading.section>
                <a
                    href="{{ route('administrator.dashboard') }}"
                    class="dashboard-element hover:bg-transition-400 group mt-8 flex items-center gap-8 rounded-lg bg-neutral-50 p-8 shadow transition-all hover:text-white"
                >
                    <x-icon-dashboard class="w-12 shrink-0" />

                    <div class="shrink-0">
                        <x-heading.component-big>
                            <span class="transition-colors group-hover:text-white"
                                >Gestione d'Istituto</span
                            ></x-heading.component-big>
                        <p class="mt-2">
                            Qui è possibile visualizzare le classi, i docenti e gli studenti associati all'istituto.
                        </p>
                    </div>
                </a>
            @else
                <section class="elements mt-12">
                    <x-heading.section>Le mie classi</x-heading.section>

                    <div class="js-school-class-list" data-show-all="false">
                        <label class="dashboard-checkbox mt-2 cursor-pointer">
                            <input
                                type="checkbox"
                                class=""
                                onchange="
                                    document.querySelector('.js-school-class-list').dataset.showAll = this.checked
                                        ? 'true'
                                        : 'false'
                                "
                            />
                            <span></span>
                            <p>Mostra le classi che hanno terminato il percorso</p>
                        </label>

                        <div class="element-list element-list_classes mt-8">
                            @foreach ($teacher->school_classes as $key => $schoolClass)
                                <div
                                    class="load--fade-in js-load school-class grid"
                                    data-direction="bottom"
                                    data-delay="<?= $key % 3 ?>"
                                    data-ended="<?= $schoolClass->ended ? 'true' : 'false' ?>"
                                >
                                    <a
                                        class="element element_class gap-2 rounded-lg shadow"
                                        href="<?= $schoolClass->url() ?>"
                                    >
                                        <div class="grid grid-cols-[minmax(0,1fr)_auto] items-center gap-2">
                                            <p class="font-heading text-5xl font-bold">{{ $schoolClass->name }}</p>
                                            <p class="text-lg font-semibold">{{ $schoolClass->yearRangeString() }}</p>
                                        </div>

                                        <div>
                                            <p class="text-center italic">{{ $schoolClass->school->name }}</p>
                                        </div>
                                    </a>
                                </div>
                            @endforeach

                            <div
                                class="load--fade-in js-load"
                                data-direction="bottom"
                                data-delay="{{ $teacher->school_classes->count() % 4 }}"
                            >
                                <a
                                    class="element element_functionality rounded-lg shadow"
                                    href="<?= route('classes.create') ?>"
                                >
                                    <div class="element-icon icon-box">
                                        <x-icon-add class="w-12" />
                                    </div>

                                    <div>
                                        <p class="element-subtitle font-semibold">Aggiungi una classe</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </section>
            @endif

            <!-- Functionalities -->
            <section class="elements mt-12">
                <x-heading.section>Strumenti</x-heading.section>
                <div class="element-list element-list_functionalities mt-8">
                    @foreach ($functionalities as $key => $functionality)
                        <div
                            class="load--fade-in js-load grid"
                            data-direction="bottom"
                            data-delay="{{ ($key - 1) % 2 }}"
                        >
                            <a
                                class="element element_functionality gap-8 rounded-lg shadow"
                                href="{{ $functionality['url'] }}"
                            >
                                <div class="element-icon icon-box">
                                    @isset($functionality['icon'])
                                        <x-dynamic-component :component="'icon-'.$functionality['icon']" />
                                    @endisset

                                    @isset($functionality['slug'])
                                        <x-dynamic-component :component="'icon-functionality-'.$functionality['slug']" />
                                    @endisset
                                </div>

                                <div>
                                    <x-heading.component class="">{{ $functionality['title'] }}</x-heading.component>
                                    <p class="mt-2 text-sm leading-relaxed">{!! $functionality['desc'] !!}</p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>

        <aside class="feed-bar relative">
            <div class="feed-bar_container">
                <h2 class="mb-8 text-2xl font-semibold">Attività recenti</h2>
                <div class="grid gap-4">
                    @foreach ($notifications as $notification)
                        <div
                            class="feed-entry group data-[recent=false]:opacity-60 data-[recent=false]:saturate-50"
                            data-recent="{{ $notification->recent() ? 'true' : 'false' }}"
                        >
                            <p class="feed-text">
                                <span class="text-transition-400 group-data-[recent=false]:text-secondary-300 font-bold">{{ $notification->date }}:</span>
                                {!! $notification->text !!}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        </aside>
    </div>
</x-layouts.main>
