@use('App\Helpers\SectionResultHelper')
@use('App\Models\Results\User\SectionResult')

<x-layouts.pdf :$title>

	<div class="mx-auto w-full max-w-[960px] px-4">

		<h1 class="pt-12 text-center">Progresso di {{ $student->inverted_full_name }}</h1>

		<div class="grades grid grid-cols-[auto_auto_auto_auto] gap-x-8 gap-y-8">
			@foreach ($grades as $grade)
				@php
					$sections = $grade->completable_sections->where('isStandard', true)->load('main_section')->sortBy('id');

					$areas = $sections->pluck('area')->unique('id')->sortBy('id');
				@endphp

				<table class="grade col-span-full mt-4 grid grid-cols-subgrid gap-y-4">
					<tr>
						<td
							colspan="4"
							class="pt-12"
						>
							<h2 class="col-span-full pb-4">{{ $grade->name }}</h2>
						</td>
					</tr>

					@foreach ($areas as $area)
						<tr>
							<td class="pt-4">
								<table class="">
									<tr>
										<td colspan="4">
											<h3 class="col-span-full mb-4">{{ $area->name }}</h3>
										</td>
									</tr>

									@php
										$areaSections = $sections->where('areaId', $area->id)->load('evaluation_test')->sortBy('id');
									@endphp

									<tr>
										<td>
											<table class="col-span-full grid grid-cols-subgrid border border-neutral-200">
												@foreach ($areaSections as $section)
													@php
														$completed = $student->hasCompletedSection($section);
														$result = SectionResultHelper::label($student, $section);
														$speed = SectionResult::where('studentId', $student->id)
														    ->where('sectionId', $section->id)
														    ->first()
														    ?->verboseSpeed();

														$reviewableTests = $section->reviewableTests();
														$completedTests = $reviewableTests->filter(fn($test) => $student->hasCompletedTest($test));
													@endphp

													<tr class="col-span-full grid grid-cols-subgrid items-center border-t border-neutral-200 py-4 last:pb-0">
														<td class="py-4 pl-4">
															<h4 class="">{{ $section->name }}</h4>
														</td>

														@if ($section->evaluation_test)
															@if ($result)
																<td class="py-4 pl-4">
																	<p>{{ $section->result_label ?: 'Risultato dell\'autovalutazione' }}:</p>
																	<p class=""><strong>{{ $result }}</strong></p>
																</td>
															@else
																<td class="py-4 pl-4">
																	<p class=""><strong>Non ancora completata</strong></p>
																</td>
															@endif
														@else
															<td class="py-4 pl-4">
																<p class=""><strong>{{ $completed ? 'Completata' : 'Non ancora completata' }}</strong></p>
															</td>
														@endif

														<td class="py-4 pl-4">
															@if ($completedTests->isNotEmpty())
																<ul class="">
																	<p class="">Altre attività completate:</p>
																	@foreach ($completedTests as $test)
																		<li class="">
																			{{ $test->name }}
																		</li>
																	@endforeach
																</ul>
															@endif
														</td>

														@if ($speed && ($completedTests->isNotEmpty() || ($section->evaluation_test && $result) || $completed))
															<td class="py-4 pl-4">
																<p>Tempo impiegato:<br><strong>{{ $speed }}</strong></p>
															</td>
														@endif
													</tr>
												@endforeach
											</table>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					@endforeach
				</table>
			@endforeach
		</div>
	</div>

</x-layouts.pdf>
