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

		@if (!empty($graph['description']))
			<p class="mt-6 px-4 text-center">
				{{ $graph['description'] }}
			</p>
		@endif

		@if ($graph['condensed'] !== null)
			<div class="grah-item__footer grid justify-items-center py-8 text-center">
				<p class="md:text-l">
					{{ $graph['condensed_label'] }}
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
