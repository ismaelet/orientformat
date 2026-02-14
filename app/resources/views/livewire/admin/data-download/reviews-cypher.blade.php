<form
	method="POST"
	wire:submit.prevent="downloadData"
	class="grid grid-cols-1 gap-4"
	x-data="{ schoolYear: @entangle('schoolYear') }"
>
	<div class="flex justify-center">
		<button
			type="submit"
			class="button mt-4"
		>
			<x-icon-download />
			<span wire:loading.remove>Scarica il cifrario</span>
			<span wire:loading>Scaricamento...</span>
		</button>
	</div>

	@session('error')
		<p class="text-danger-600 text-center">
			{{ session('error') }}
		</p>
	@endsession
</form>
