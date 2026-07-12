<div>
	<div class="area_header flex items-center">
		<h2 class="text-3xl font-semibold">
			{{ $areaName }}
		</h2>

		@if (count($sectionIds) > 1)
			<div class="area_arrows">
				<button
					type="button"
					class="area_arrow icon-box section-color section-color--area-{{ $areaId }} grid place-items-center"
					wire:click="previous"
					aria-label="Sezione precedente"
				>
					<x-icon-arrow-simple-left class="h-1/3 w-1/3" />
				</button>

				<button
					type="button"
					class="area_arrow icon-box section-color section-color--area-{{ $areaId }} grid place-items-center"
					wire:click="next"
					aria-label="Sezione successiva"
				>
					<x-icon-arrow-simple-right class="h-1/3 w-1/3" />
				</button>
			</div>
		@endif
	</div>

	<div class="relative min-h-[32rem]">
		<div
			wire:loading.class="pointer-events-none opacity-30"
			wire:target="previous,next,select"
			class="min-h-[32rem] transition-opacity"
		>
			@if ($currentSection)
				<div class="graph-item section section-color section-color--area-{{ $areaId }}">
					<div class="dashboard-panel min-h-[32rem]">
						<h3 class="dashboard-panel__title flex items-center justify-between">
							<span class="block">
								{{ $currentSection->name }}
							</span>

							<div
								class="gradient-overlady graph-item__icon text-background invisible flex aspect-square w-20 items-center justify-center rounded-full text-4xl md:visible"
							>
								<x-dynamic-component
									:component="'icon-sections.section-' . $currentSection->effectiveMainSectionId()"
									class="h-1/2 w-1/2"
								/>
							</div>
						</h3>

						<livewire:class-graphs.section-graph
							:section-id="$currentSection->id"
							:school-class-id="$schoolClassId"
							:key="'class-graph-' . $schoolClassId . '-' . $currentSection->id"
							lazy
						/>
					</div>
				</div>
			@endif
		</div>

		<div
			wire:loading.flex
			wire:target="previous,next,select"
			class="absolute inset-0 z-10 hidden items-center justify-center"
		>
			<div class="grid justify-items-center gap-4 rounded bg-white/90 p-6 text-center shadow">
				<x-icon-loading class="w-16" />

				<p>
					Caricamento attività...
				</p>
			</div>
		</div>
	</div>

	@if (count($sectionIds) > 1)
		<div class="section-dots">
			@foreach ($sectionIds as $index => $sectionId)
				<button
					type="button"
					@class(['section-dot', 'active' => $position === $index])
					wire:click="select({{ $index }})"
					aria-label="Vai alla sezione {{ $index + 1 }}"
					aria-current="{{ $position === $index ? 'true' : 'false' }}"
				></button>
			@endforeach
		</div>
	@endif
</div>
