<form
	method="POST"
	wire:submit.prevent="downloadData"
	class="grid grid-cols-1 gap-4"
>
	<input
		type="number"
		class="input"
		wire:model="schoolYear"
		placeholder="Anno scolastico (es. 2023 per l'anno 2023/2024)"
	/>

	<input
		type="number"
		class="input"
		wire:model="courseYear"
		placeholder="Anno di corso (es. 1, 2, 3, ...)"
	/>
	<div class="grid gap-4 md:grid-cols-2">
		<label class="checkbox">
			<input
				type="radio"
				name="school_type"
				value="middle_school"
				wire:model="schoolType"
			/>
			<p>Solo delle scuole medie</p>
		</label>
		<label class="checkbox">
			<input
				type="radio"
				name="school_type"
				value="high_school"
				wire:model="schoolType"
			/>
			<p>Solo delle scuole superiori</p>
		</label>
	</div>

	<div class="flex justify-center">
		<button
			type="submit"
			class="button mt-4"
		>
			<x-icon-download />
			Scarica i dati
		</button>
	</div>
</form>
