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
			<p class="text-sm">
				{{ section_config($section->id ?? null, 'recap-name-student') ?: 'Risultato dell\'autovalutazione' }}:</p>
			<p class="dashboard-panel_value font-bold">{{ $result->result }}</p>
		@else
			Non ancora completato
		@endif

	</div>

	<div class="">
		@if ($actions)
			<p class="text-sm">Altri risultati:</p>

			@foreach ($actions as $action)
				<p class="">
					<a
						href="{{ $action['url'] }}"
						class="text-secondary-400 hover:text-secondary-300 font-medium underline transition-colors"
					>{{ $action['name'] }}</a>
				</p>
			@endforeach
		@endif
	</div>

	<p>
		@if ($result && $speed)
			Completato in <strong>{{ $speed }}</strong><br>
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
