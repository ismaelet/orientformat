<div class="section section-color section-color--area-{{ $area->id }}">
	<div
		class="dashboard-panel-icon"
		data-delay="2"
		data-direction="bottom"
	>
		<x-dynamic-component :component="'icon-sections.section-' . $section->originalSection()->id" />
	</div>

	<p class="dashboard-panel-title max-w-50 text-neutral-700">{{ $section->name }}</p>

	<div class="">
		@if ($result || $completed)
			@if ($section->evaluation_test)
				<p class="text-sm">
					{{ $section->result_label ?: 'Risultato dell\'autovalutazione' }}:</p>
				<p class="dashboard-panel_value font-bold">{{ $result }}</p>

				<p class="mt-0">
					<a
						href="{{ $section->evaluation_test->url($student->id) }}"
						class="text-primary-500 hover:text-primary-400 cta-selfevaluation font-medium transition-colors"
					>Vedi autovalutazione</a>
				</p>
			@else
				<span class="dashboard-panel_value font-bold text-neutral-700">Completata</span>
			@endif
		@else
			Non ancora completata
		@endif

	</div>

	<div class="group">
		<p class="group-not-[&:has(.test-result)]:hidden group text-sm">Attività svolte:</p>

		<ul>
			@foreach ($section->reviewable_tests() as $test)
				@if ($student->hasCompletedTest($test))
					<li class="test-result">
						<a
							href="{{ $test->url($student->id) }}"
							class="text-secondary-400 hover:text-secondary-300 font-medium transition-colors"
						>Risultato di "{{ $test->name }}"</a>
					</li>
				@endif
			@endforeach
		</ul>
	</div>

	<p>
		@if ($speed)
			Tempo impiegato: <strong>{{ $speed }}</strong>
		@endif
	</p>


	@if (!empty($infos[$section->originalSection()->id]))
		<label class="info-icon icon-box">
			<input
				type="checkbox"
				name="section-info-{{ $section->originalSection()->id }}"
				class="hidden"
			>
			<?= embed_icon('info') ?>
		</label>

		<p class="section-info">
			{{ $infos[$section->originalSection()->id] }}
		</p>
	@endif
</div>
