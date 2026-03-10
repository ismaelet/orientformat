@pushOnce('styles')
	<link
		rel="stylesheet"
		href="{{ asset('css/legacy/teacher-dashboard.css') }}"
	>

	<style>
		.dashboard-element {
			position: relative;

			&::before {
				content: "";
				position: absolute;
				inset: 0;
				opacity: 0;
				background: linear-gradient(135deg, #fff, #000);
				border-radius: inherit;
				mix-blend-mode: overlay;
				transition: inherit;
			}

			&:hover::before {
				opacity: 1;
			}

			>* {
				position: relative;
			}
		}
	</style>
@endpushOnce

<x-layouts.legacy-main :$title>
	<div class="page-content breakout">
		<div class="pos-rel">
			{{-- Title --}}
			{{-- <x-heading.main>Funzionalità<br> {{ is_administrator() ? 'di referente' : "per l'insegnante" }}
			</x-heading.main> --}}

			{{-- <p class="border-transition-400 text-transition-500 mt-12 rounded border-2 px-4 py-2">La dashboard insegnante è in
				fase di
				aggiornamento, se dovessi riscontrare qualche problema, ti preghiamo di contattare il supporto <a
					href="teacher/support/open-ticket"
					class="text-secondary-300 font-semibold"
				>qui</a>.</p> --}}

			{{-- Join Requests --}}

			@session('success')
				<x-alerts.success>
					{{ session('success') }}
				</x-alerts.success>
			@endsession

			@if (!empty($notices))
				{{-- Notices --}}
				<section class="elements mar-t-3">
					<x-heading.section>Avvisi</x-heading.section>

					<div class="mt-4 grid grid-cols-1 gap-4">

						@foreach ($notices['teacher_join_requests'] ?? [] as $joinRequest)
							@if (!$joinRequest->class)
								@php
									$joinRequest->delete();
								@endphp
								@continue
							@endif
							<form
								method="POST"
								class="border-1 grid grid-cols-1 gap-4 rounded border-dashed border-neutral-400 p-2"
							>
								@csrf

								<p class="text-center"><strong>{{ $joinRequest->requesting_teacher->full_name }}</strong>
									ha richiesto di collaborare alla gestione della classe
									<strong>{{ $joinRequest->class->name }}</strong>
								</p>

								<div class="wrap flex justify-center gap-4">
									<x-button
										type="submit"
										size="xs"
										variant="secondary"
										color="success"
										formaction="{{ route('classes.teacher.join.accept', $joinRequest) }}"
									>Accetta</x-button>
									<x-button
										type="button"
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
								class="border-1 grid grid-cols-1 gap-4 rounded border-dashed border-neutral-400 p-2"
							>
								@csrf

								<p class="text-center">Lo studente/studentessa
									<strong>{{ $joinRequest->requesting_student->full_name }}</strong>
									ha richiesto di unirsi alla classe
									<strong>{{ $joinRequest->class?->name }}</strong>
								</p>

								<div class="wrap flex justify-center gap-4">
									<x-button
										type="submit"
										size="xs"
										variant="secondary"
										color="success"
										formaction="{{ route('classes.student.join.accept', $joinRequest) }}"
									>Accetta</x-button>
									<x-button
										type="button"
										size="xs"
										variant="secondary"
										color="danger"
										formaction="{{ route('classes.student.join.reject', $joinRequest) }}"
									>Rifiuta</x-button>
								</div>
							</form>
						@endforeach

						@foreach ($inviteRequests ?? [] as $inviteRequest)
							@if (!$inviteRequest->class)
								@php
									$inviteRequest->delete();
								@endphp
								@continue
							@endif

							<form
								method="POST"
								class="border-1 grid grid-cols-1 gap-4 rounded border-dashed border-neutral-400 p-2"
							>
								@csrf

								<p class="text-center">Sei stato invitato/a da
									<strong>{{ $inviteRequest->inviting_teacher->full_name }}</strong>
									a collaborare alla gestione della classe
									<strong>{{ $inviteRequest->class->name }}</strong>
								</p>

								<div class="wrap flex justify-center gap-4">
									<x-button
										type="submit"
										size="xs"
										variant="secondary"
										color="success"
										formaction="{{ route('classes.invite.accept', $inviteRequest) }}"
									>Accetta</x-button>
									<x-button
										type="button"
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
						<x-heading.component-big><span class="transition-colors group-hover:text-white">Gestione
								d'Istituto</span></x-heading.component-big>
						<p class="mt-2">Qui è possibile visualizzare le classi, i docenti e gli studenti associati all'istituto.</p>
					</div>
				</a>
			@else
				<section class="elements mar-t-3">
					<x-heading.section>Le mie classi</x-heading.section>

					<div
						class="js-school-class-list"
						data-show-all="false"
					>

						<label class="checkbox clickable mt-2">
							<input
								type="checkbox"
								class=""
								onchange="document.querySelector('.js-school-class-list').dataset.showAll = this.checked ? 'true' : 'false'"
							>
							<span></span>
							<p>Mostra le classi che hanno terminato il percorso</p>
						</label>

						<div class="element-list element-list_classes mar-t-2">

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
										<p class="element-subtitle txt-sbold">Aggiungi una classe</p>
									</div>
								</a>
							</div>
						</div>
					</div>
				</section>
			@endif

			<!-- Functionalities -->
			<section class="elements mar-t-3">
				<x-heading.section>Strumenti</x-heading.section>
				<div class="element-list element-list_functionalities mar-t-2">

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
										<x-dynamic-component :component="'icon-' . $functionality['icon']" />
									@endisset

									@isset($functionality['slug'])
										<x-dynamic-component :component="'icon-functionality-' . $functionality['slug']" />
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

		<aside class="feed-bar pos-rel">
			<div class="feed-bar_container">
				<h2 class="txt-15rem txt-sbold mar-b-2">Attività recenti</h2>
				<div class="grid gap-4">

					@foreach ($notifications as $notification)
						<div
							class="feed-entry group data-[recent=false]:opacity-60 data-[recent=false]:saturate-50"
							data-recent="{{ $notification->recent() ? 'true' : 'false' }}"
						>
							<p class="feed-text">
								<span
									class="text-transition-400 group-data-[recent=false]:text-secondary-300 font-bold">{{ $notification->date }}:</span>
								{!! $notification->text !!}
							</p>
						</div>
					@endforeach

				</div>
			</div>
		</aside>
	</div>
</x-layouts.legacy-main>
