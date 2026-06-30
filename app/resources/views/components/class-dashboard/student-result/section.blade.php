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

				<x-student-result.completed-attempts :attempts="$evaluationAttempts" />

				<p class="mt-0">
					<a
						href="{{ $section->evaluation_test->url($student->id) }}"
						class="text-primary-500 hover:text-primary-400 cta-selfevaluation font-medium transition-colors"
					>Vedi autovalutazione</a>
				</p>
			@else
				<p class="dashboard-panel_value font-bold text-neutral-700">Completata</p>

				<x-student-result.completed-attempts :attempts="$evaluationAttempts" />
			@endif
		@else
			Non ancora completata
		@endif

	</div>

	<div class="group">
		<p class="group-not-[&:has(.test-result)]:hidden group text-sm">Altre attività svolte:</p>

		<ul>
			@foreach ($nonEvaluationTests as $test)
				@if ($attemptsByTest[$test->id] ?? 0)
					<li class="test-result">
						@if (in_array($test->id, $reviewableTestIds))
							<a
								href="{{ $test->url($student->id) }}"
								class="text-secondary-400 hover:text-secondary-300 font-medium italic transition-colors"
							>{{ $test->name }}</a>
						@else
							<span class="italic text-neutral-700">{{ $test->name }}</span>
						@endif

						<x-student-result.completed-attempts :attempts="$attemptsByTest[$test->id] ?? null" />
					</li>
				@endif
			@endforeach
		</ul>
	</div>

	<div>
		@if ($speed)
			Tempo impiegato: <strong>{{ $speed }}</strong>
		@endif
	</div>


	@if ($info)
		<label class="info-icon icon-box">
			<input
				type="checkbox"
				name="section-info-{{ $section->originalSection()->id }}"
				class="hidden"
			>
			<?= embed_icon('info') ?>
		</label>

		<p class="section-info">
			{{ $info }}
		</p>
	@endif
</div>
