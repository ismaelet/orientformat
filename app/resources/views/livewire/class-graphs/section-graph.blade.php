<div>
	@if ($graph)
		<div class="graph-item section section-color section-color--area-{{ $areaId }}">
			<div class="dashboard-panel min-h-[32rem]">
				<h3 class="dashboard-panel__title flex items-center justify-between">
					<span class="block">
						{{ $sectionName }}
					</span>

					<div
						class="gradient-overlady graph-item__icon text-background invisible flex aspect-square w-20 items-center justify-center rounded-full text-4xl md:visible"
					>
						<x-dynamic-component
							:component="'icon-sections.section-' . $iconSectionId"
							class="h-1/2 w-1/2"
						/>
					</div>
				</h3>

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
			</div>
		</div>
	@else
		<div class="graph-item section section-color section-color--area-{{ $areaId }}">
			<div class="dashboard-panel min-h-[32rem]">
				<h3 class="dashboard-panel__title">
					{{ $sectionName }}
				</h3>

				<p class="pb-20 text-center text-lg">
					L'attività non è stata ancora completata
				</p>
			</div>
		</div>
	@endif
</div>
