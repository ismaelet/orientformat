@push('styles')
	<style>
		h1 {
			font-size: min(3rem, 10vw);
		}

		.class-list {
			grid-template-columns: max-content max-content 1fr max-content;
			align-items: center;
			gap: .75rem 1rem;

			@media (min-width: 480px) {
				gap: .75rem 2rem;
			}
		}

		.list-row {
			display: grid;
			grid-template-columns: subgrid;
			grid-column: 1 / -1;
			border-bottom: 1px solid var(--color-neutral-200);
			padding-bottom: .75rem;

			&:last-child {
				border-bottom: none;
				padding-bottom: 0;
			}
		}

		.list-header {
			font-weight: var(--font-weight-semibold);
		}
	</style>
@endpush

<x-layouts.main theme="classic">

	<div class="my-8 grid grid-cols-1 content-center gap-8">
		<h1 class="title font-semibold leading-tight text-neutral-700">Amministrazione<br>{{ $school->name }}</h1>

		<div class="surface class-list grid p-8 shadow">
			<div class="list-row">
				<p class="list-header">Classe</p>
				<p class="list-header">Attiva fino al</p>
				<p class="list-header">Gestita da</p>
				<p class="list-header"></p>
			</div>

			@if ($school->school_classes->isEmpty())
				<p class="p-8 text-center">Nessuna classe registrata</p>
			@else
				@foreach ($school->school_classes->sortByDesc('grade')->sortBy('letter') as $schoolClass)
					@php
						$teachers = [];

						foreach ($schoolClass->teachers() as $teacher) {
						    if ($teacher->user) {
						        $teachers[] = $teacher->user->fullName();
						    }
						}

						$teachersString = empty($teachers) ? '-' : implode(',<br>', $teachers);

					@endphp

					<div class="list-row">
						<p class="font-medium">{{ $schoolClass->name }}</p>
						<p class="font-medium">{{ $schoolClass->yearRangeString() }}</p>

						<p>
							{{ $teachersString }}
						</p>

						<p><a
								href="{{ $schoolClass->url() }}"
								class="text-primary border-b"
							>Apri</a></p>
					</div>
				@endforeach
			@endif
		</div>
	</div>

</x-layouts.main>
