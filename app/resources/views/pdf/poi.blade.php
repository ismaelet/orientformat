@use('App\Helpers\SectionResultHelper')

<x-layouts.pdf :$title>

	<div class="mx-auto w-full max-w-[960px] px-4">

		<h1 class="pt-12 text-center">
			Profilo Orientativo Individualizzato di {{ $student->inverted_full_name }}
		</h1>

		<div class="mt-8 grid grid-cols-[auto_auto_auto] gap-x-8 gap-y-8">

			{{-- Questionari --}}
			<table class="col-span-full mt-4 grid grid-cols-subgrid gap-y-4">
				<tr>
					<td
						colspan="3"
						class="pt-12"
					>
						<h2 class="col-span-full pb-4">
							Scelta indicata nei questionari
						</h2>

						<p>
							Qui puoi trovare la scelta che è stata effettuata nei questionari
							iniziale e finale, e il grado di sicurezza.
						</p>
					</td>
				</tr>

				<tr>
					<td class="pt-4">
						<table class="col-span-full grid grid-cols-subgrid border border-neutral-200">

							<tr class="col-span-full grid grid-cols-subgrid items-center border-t border-neutral-200 py-4 first:border-t-0">
								<td class="py-4 pl-4">
									<h3>Questionario iniziale</h3>
								</td>

								<td class="py-4 pl-4">
									<p>Scelta indicata:</p>
								</td>

								<td class="py-4 pl-4 pr-4">
									@if ($beginnerChoice)
										<p>
											<strong>
												{{ $beginnerChoice['primary_choice_area'] }}
											</strong>

											({{ trim($beginnerChoice['primary_choice_intensity']) }})
										</p>
									@else
										<p>
											<strong>Non ancora compilato</strong>
										</p>
									@endif
								</td>
							</tr>

							<tr class="col-span-full grid grid-cols-subgrid items-center border-t border-neutral-200 py-4">
								<td class="py-4 pl-4">
									<h3>Questionario finale</h3>
								</td>

								<td class="py-4 pl-4">
									<p>Scelta indicata:</p>
								</td>

								<td class="py-4 pl-4 pr-4">
									@if ($endChoice)
										<p>
											<strong>
												{{ $endChoice['primary_choice_area'] }}
											</strong>

											({{ trim($endChoice['primary_choice_intensity']) }})
										</p>
									@else
										<p>
											<strong>Non ancora compilato</strong>
										</p>
									@endif
								</td>
							</tr>

						</table>
					</td>
				</tr>
			</table>

			{{-- Aree POI --}}
			@foreach ($structure as $area)
				<table class="col-span-full mt-4 grid grid-cols-subgrid gap-y-4">
					<tr>
						<td
							colspan="3"
							class="pt-12"
						>
							<h2 class="col-span-full pb-1">
								{{ $area['name'] }}
							</h2>

							@if (!empty($area['subtitle']))
								<p class="pb-4">
									{{ $area['subtitle'] }}
								</p>
							@endif

							<p>
								{{ $area['description'] }}
							</p>
						</td>
					</tr>

					<tr>
						<td class="pt-4">
							<table class="col-span-full grid grid-cols-subgrid border border-neutral-200">
								@foreach ($area['sections'] as $sectionId)
									@php
										$section = $sections->get($sectionId);
										$result = $section ? SectionResultHelper::label($student, $section) : null;
									@endphp

									@if ($section)
										<tr
											class="col-span-full grid grid-cols-subgrid items-center border-t border-neutral-200 py-4 first:border-t-0"
										>
											<td class="py-4 pl-4">
												<h3>{{ $section->name }}</h3>
											</td>

											<td class="py-4 pl-4">
												<p>
													{{ $section->result_label ?: 'Risultato dell\'autovalutazione' }}:
												</p>
											</td>

											<td class="py-4 pl-4 pr-4">
												@if ($result !== null)
													<p>
														<strong>{{ $result }}</strong>
													</p>
												@else
													<p>
														<strong>Non ancora completata</strong>
													</p>
												@endif
											</td>
										</tr>
									@endif
								@endforeach
							</table>
						</td>
					</tr>
				</table>
			@endforeach

			{{-- Area Competenza Imprenditoriale --}}
			<table class="col-span-full mt-4 grid grid-cols-subgrid gap-y-4">
				<tr>
					<td
						colspan="3"
						class="pt-12"
					>
						<h2 class="col-span-full pb-1">
							Area Competenza Imprenditoriale
						</h2>

						<p class="pb-4">
							(Spirito di iniziativa e imprenditorialità)
						</p>

						<p>
							Qui puoi trovare i risultati relativi ai tipi di pensiero
							e alle capacità autoimprenditoriali.
						</p>
					</td>
				</tr>

				<tr>
					<td class="pt-4">
						<table class="col-span-full grid grid-cols-subgrid border border-neutral-200">
							<tr class="col-span-full grid grid-cols-subgrid items-center border-t border-neutral-200 py-4 first:border-t-0">
								<td class="py-4 pl-4">
									<h3>
										Creatività e autoimprenditorialità
									</h3>
								</td>

								<td class="py-4 pl-4">
									<p>Risultati della sezione:</p>
								</td>

								<td class="py-4 pl-4 pr-4">
									@if (empty($results['creatività']))
										<p>
											<strong>Non ancora completata</strong>
										</p>
									@else
										@foreach ($results['creatività'] as $result)
											<p>
												{{ $result['name'] }}:
												<strong>{{ $result['percentage'] }}%</strong>
											</p>
										@endforeach
									@endif
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>

		</div>
	</div>

</x-layouts.pdf>
