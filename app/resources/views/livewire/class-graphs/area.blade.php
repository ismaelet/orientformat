<div>
	<div class="area_header flex items-center">
		<h2 class="text-3xl font-semibold">
			{{ $areaName }}
		</h2>

		@if (count($graphItems) > 1)
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
			@if ($currentSection && ($currentGraphItem = $graphItems[$position]))
				<livewire:class-graphs.section-graph
					:section-id="$currentSection->id"
					:school-class-id="$schoolClassId"
					:area-id="$areaId"
					:graph-key="$currentGraphItem['graph_key']"
					:key="'class-graph-' . $schoolClassId . '-' . $currentSection->id . '-' . $currentGraphItem['graph_key']"
					lazy
				/>
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

	@if (count($graphItems) > 1)
		<div class="section-dots">
			@foreach ($graphItems as $index => $graphItem)
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
