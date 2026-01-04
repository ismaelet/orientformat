<form
	method="POST"
	wire:submit.prevent="downloadData"
	class="grid grid-cols-1 gap-4"
>
	<input
		type="number"
		class="input"
		wire:model="schoolYear"
		min="2021"
		max="{{ now()->year }}"
		placeholder="Registrati nell'anno scolastico"
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
			<p>Tutti i docenti</p>
		</label>
		<label class="checkbox">
			<input
				type="radio"
				name="school_type"
				value="middleschool"
				wire:model="schoolType"
			/>
			<p>Solo docenti con classi alle medie</p>
		</label>
		<label class="checkbox">
			<input
				type="radio"
				name="school_type"
				value="highschool"
				wire:model="schoolType"
			/>
			<p>Solo docenti con classi alle superiori</p>
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
