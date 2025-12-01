<form
	method="POST"
	wire:submit.prevent="downloadData"
	class="grid grid-cols-1 gap-4"
	x-data="{ schoolYear: @entangle('schoolYear') }"
>
	<input
		type="number"
		class="input"
		wire:model="schoolYear"
		min="2021"
		max="{{ now()->year }}"
		placeholder="Anno scolastico (es. 2023 per l'anno 2023/2024)"
	/>
	<label
		class="checkbox"
		x-bind:class="{ 'hidden': !schoolYear }"
	>
		<input
			type="checkbox"
			wire:model="activeStudents"
		/>
		<p>Scarica studenti attivi nell'anno indicato, invece di studenti registrati</p>
	</label>

	<input
		type="number"
		class="input"
		wire:model="courseYear"
		placeholder="Anno di corso (es. 1, 2, 3, ...)"
		min="1"
		max="5"
	/>
	<div class="flex flex-wrap items-center justify-center gap-8">
		<label class="checkbox">
			<input
				type="radio"
				name="school_type"
				value="all"
				wire:model="schoolType"
				checked
			/>
			<p>Tutti gli studenti</p>
		</label>
		<label class="checkbox">
			<input
				type="radio"
				name="school_type"
				value="middleschool"
				wire:model="schoolType"
			/>
			<p>Solo studenti delle medie</p>
		</label>
		<label class="checkbox">
			<input
				type="radio"
				name="school_type"
				value="highschool"
				wire:model="schoolType"
			/>
			<p>Solo studenti delle superiori</p>
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
