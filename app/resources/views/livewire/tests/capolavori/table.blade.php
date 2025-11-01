<div class="contents">

	@if ($masterpieceCount)
		<div class="grid grid-cols-1 gap-8">
			<x-heading.component-big class="text-center">Lista dei capolavori</x-heading.component-big>

			<div class="">{{ $this->table }}</div>
		</div>
	@endif

</div>
