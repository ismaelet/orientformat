@pushOnce('styles')
	<style>
		.dashboard-table {
			grid-template-columns: repeat(3, auto);
		}

		.dashboard-row {
			display: grid;
			grid-template-columns: subgrid;
			grid-column: 1 / -1;
			border-bottom: 1px solid var(--color-neutral-border);

			&:last-child {
				border-bottom: none;
			}
		}

		.dashboard-cell {
			padding: .5rem;
			border-right: 1px solid var(--color-neutral-border);

			&:last-child {
				border-right: none;
			}

			&:has(svg) {
				display: flex;
				gap: 0.5rem;
				justify-content: center;
				align-items: center;
			}
		}
	</style>
@endpushOnce

<x-layouts.administrator-dashboard :school="$school">
	<div class="mb-12 grid grid-cols-1 gap-4">
		<x-heading.main>Scaricamento dati</x-heading.main>
		<x-subheading.main>{{ $school->name }}</x-subheading.main>
		<p class="text-lg">Qui è possibile scaricare i dati relativi alla scuola in vari formati. La tabella relativa ai
			risultati degli
			studenti può essere molto grande e potrebbe richiedere del tempo per il download.</p>
	</div>

	<div class="dashboard-table border-neutral-border grid rounded-sm border">
		@foreach ($datasets as $dataset)
			<div class="dashboard-row">
				<p class="dashboard-cell text-lg font-semibold">{{ $dataset['label'] }}</p>

				<div class="dashboard-cell">
					<a
						class="hover:text-primary-400 text-primary-600 contents transition-colors"
						href="{{ route($dataset['route'], ['school' => $school, 'format' => 'xlsx']) }}"
					>
						<x-icon-download class="h-4 w-4" />
						<p class="font-semibold">Scarica in formato XLSX</p>
					</a>
				</div>

				<div class="dashboard-cell">
					<a
						class="hover:text-secondary-200 text-secondary-600 contents transition-colors"
						href="{{ route($dataset['route'], ['school' => $school, 'format' => 'csv']) }}"
					>
						<x-icon-download class="h-4 w-4" />
						<p class="font-semibold">Scarica in formato CSV</p>
					</a>
				</div>
			</div>
		@endforeach
	</div>

</x-layouts.administrator-dashboard>
