<div class="section section-color section-color--area-{{ $area->id }}">
	<div
		class="dashboard-panel-icon js-load load--fade-in"
		data-delay="2"
		data-direction="bottom"
	>
		{!! embed_icon('sections/section-' . $section->main_section->id) !!}
	</div>

	<p class="dashboard-panel-title text-neutral-700">{{ $section->name }}</p>

	<div class="">
		@if ($result->result)
			@if ($section->evaluation_test)
				<p class="text-sm">
					{{ $section->result_label ?: 'Risultato dell\'autovalutazione' }}:</p>
				<p class="dashboard-panel_value font-bold">{{ $result->result }}</p>

				<p class="mt-0">
					<a
						href="{{ $section->evaluation_test->url($student->id) }}"
						class="text-primary-500 hover:text-primary-400 font-medium transition-colors"
					>Vedi autovalutazione</a>
				</p>
			@else
				<span class="dashboard-panel_value font-bold text-neutral-700">Completata
			@endif
		@else
			Non ancora completata
		@endif

	</div>

	<div class="">
		@if ($tests)
			<p class="text-sm">Attività svolte:</p>

			@foreach ($tests as $test)
				<p class="">
					<a
						href="{{ $test->url($student->id) }}"
						class="text-secondary-400 hover:text-secondary-300 font-medium transition-colors"
					>Risultato di "{{ $test->name }}"</a>
				</p>
			@endforeach
		@endif
	</div>

	<p>
		@if ($result && $speed)
			Completata in <strong>{{ $speed }}</strong><br>
		@endif
	</p>


	@if (!empty($infos[$section->main_section->id]))
		<label class="info-icon icon-box">
			<input
				type="checkbox"
				name="section-info-{{ $section->main_section->id }}"
				class="hidden"
			>
			<?= embed_icon('info') ?>
		</label>

		<p class="section-info">
			{{ $infos[$section->main_section->id] }}
		</p>
	@endif
</div>
