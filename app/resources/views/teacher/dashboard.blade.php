@pushOnce('styles')
	<link
		rel="stylesheet"
		href="{{ asset('css/legacy/teacher-dashboard.css') }}"
	>
@endpushOnce

<x-layouts.legacy-main :$title>
	<div class="page-content breakout">
		<div class="pos-rel">
			{{-- Title --}}
			<x-heading.main>Funzionalità<br>per {{ is_administrator() ? "l'amministratore" : "l'insegnante" }}
			</x-heading.main>

			<p class="mt-12 rounded border-2 border-amber-500 px-4 py-2 text-amber-600">La dashboard insegnante è in fase di
				aggiornamento, se dovessi riscontrare qualche problema, ti preghiamo di contattare il supporto <a
					href="teacher/support/open-ticket"
					class="text-secondary-300"
				>qui</a>.</p>

			{{-- Classes --}}
			@if (is_administrator())
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
										class="element element_class gap-2"
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
									class="element element_functionality"
									href="<?= client_url('/teacher/add-class') ?>"
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
								class="element element_functionality gap-8"
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
									<h3 class="element-title txt-upp font-bold">{{ $functionality['title'] }}</h3>
									<p class="element-subtitle mt-2">{!! $functionality['desc'] !!}</p>
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
						<div class="feed-entry">
							<p class="feed-text">
								<span>{{ $notification->date }}:</span>
								{!! $notification->text !!}
							</p>
						</div>
					@endforeach

				</div>
			</div>
		</aside>
	</div>
</x-layouts.legacy-main>
