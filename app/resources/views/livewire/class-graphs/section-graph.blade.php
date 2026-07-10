<div>
	@if ($graph)
		<div class="grah-item__body">
			<div class="graph-item__canvas-wrapper">
				<canvas
					data-section-chart
					data-chart='{{ json_encode($graph, JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_HEX_TAG) }}'
				></canvas>
			</div>
		</div>

		@if ($graph['condensed'] !== null)
			<div class="grah-item__footer grid justify-items-center py-8 text-center">
				<p class="md:text-l">
					{{ section_config($sectionId, 'recap-name-grade') ?: 'Risultato medio' }}:
				</p>

				<p class="font-semibold md:text-xl">
					{{ $graph['condensed'] }}
				</p>
			</div>
		@endif
	@else
		<p class="pb-20 text-center text-lg">
			L'attività non è stata ancora completata
		</p>
	@endif
</div>
