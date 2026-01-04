<form
	method="POST"
	wire:submit.prevent="downloadData"
	class="grid grid-cols-1 gap-4"
	x-data="{ schoolYear: @entangle('schoolYear') }"
>

	<div class="flex flex-wrap items-center justify-center gap-8">
		<label class="checkbox">
			<input
				type="radio"
				name="school_type"
				value="all"
				wire:model="schoolType"
				checked
			/>
			<p>Tutte le scuole</p>
		</label>
		<label class="checkbox">
			<input
				type="radio"
				name="school_type"
				value="middleschool"
				wire:model="schoolType"
			/>
			<p>Solo scuole secondarie di primo grado</p>
		</label>
		<label class="checkbox">
			<input
				type="radio"
				name="school_type"
				value="highschool"
				wire:model="schoolType"
			/>
			<p>Solo scuole secondarie di secondo grado</p>
		</label>
	</div>

	<div class="flex justify-center">
		<button
			type="submit"
			class="button mt-4"
		>
			<x-icon-download />
			<span wire:loading.remove>Scarica i dati</span>
			<span wire:loading>Scaricamento...</span>
		</button>
	</div>

	@session('error')
		<p class="text-danger-600 text-center">
			{{ session('error') }}
		</p>
	@endsession
</form>
