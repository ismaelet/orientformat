@pushOnce('styles')
	<style>
		.settings-form {
			border: 1px solid var(--color-neutral-border);
		}

		.field-group {
			position: relative;

			&::before {
				content: "Istituto e classe di appartenenza";
				position: absolute;
				top: -0.75rem;
				left: 1rem;
				background-color: var(--color-neutral-50);
				padding: 0 0.5rem;
				font-size: 0.875rem;
				color: var(--color-neutral-500);
			}
		}
	</style>
@endpushOnce

<x-layouts.main>

	<div class="fill-width px-content-padding grid grid-cols-1 content-center items-stretch gap-12 py-12 lg:grid-cols-2">
		<livewire:student.settings.data :$student />

		<livewire:student.settings.password :$student />
	</div>

</x-layouts.main>
