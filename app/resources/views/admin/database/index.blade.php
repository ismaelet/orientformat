@push('styles')
	<style>
		.panel {
			display: grid;
			grid-template-columns: minmax(0, 1fr);
			gap: 1rem;
			align-content: flex-start;
			padding: 2rem;
		}

		.panel_title {
			color: var(--color-neutral-700);
			font-size: 2rem;
			font-weight: 700;
		}

		.download-buttons {
			display: grid;
			grid-template-columns: minmax(0, 1fr);
			gap: 0.5;
		}

		.download-button {
			display: flex;
			width: fit-content;
			align-items: center;
			gap: .5em;
			border-bottom: 1px dashed;
			line-height: 2;
			transition: border-color 0.2s;

			&:hover {
				border-color: var(--color-primary-400);
			}

			svg {
				width: 1em;
				transition: fill 0.2s;

				.download-button:hover & {
					fill: var(--color-primary-400);
				}
			}
		}
	</style>
@endpush

<x-layouts.admin-dashboard>

	<div class="columns-40rem grid gap-8">
		<div class="panel surface">
			<h2 class="panel_title">Studenti</h2>

			<form
				class="download-buttons"
				method="POST"
				action="{{ route('admin.database.download.active-students') }}"
			>

				@for ($i = $currentYear; $i >= $startingYear; $i--)
					<button
						class="download-button"
						name="year"
						value="{{ $i }}"
					>
						Scarica gli studenti attivi nell'anno scolastico {{ $i }}/{{ $i + 1 }}
						{!! embed_icon('download') !!}
					</button>
				@endfor

			</form>

			<form
				class="download-buttons"
				method="POST"
				action="{{ route('admin.database.download.students') }}"
			>

				<button
					class="download-button download-button--fade"
					name="year"
					value="all"
				>
					Scarica la lista di tutti gli studenti
					{!! embed_icon('download') !!}
				</button>

				@for ($i = $currentYear; $i >= $startingYear; $i--)
					<button
						class="download-button download-button--fade"
						name="year"
						value="{{ $i }}"
					>
						Scarica gli studenti registrati nell'anno scolastico {{ $i }}/{{ $i + 1 }}
						{!! embed_icon('download') !!}
					</button>
				@endfor

			</form>
		</div>

		<!-- Teachers -->
		<div
			class="panel surface"
			method="POST"
		>
			<h2 class="panel_title">Docenti</h2>

			<form
				class="download-buttons"
				method="POST"
				action="{{ route('admin.database.download.teachers') }}"
			>
				<button
					class="download-button"
					name="year"
					value="all"
				>
					Scarica la lista di tutti i docenti
					{!! embed_icon('download') !!}
				</button>

				@for ($i = $currentYear; $i >= $startingYear; $i--)
					<button
						class="download-button"
						name="year"
						value="{{ $i }}"
					>
						Scarica i docenti registrati nel {{ $i }}
						{!! embed_icon('download') !!}
					</button>
				@endfor

			</form>
		</div>

		<!-- Classes -->
		<div
			class="panel surface"
			method="POST"
		>
			<h2 class="panel_title">Classi</h2>

			<form
				class="download-buttons"
				method="POST"
				action="{{ route('admin.database.download.classes') }}"
			>

				<button
					class="download-button"
					name="year"
					value="all"
				>
					Scarica la lista di tutte le classi
					{!! embed_icon('download') !!}
				</button>

				@for ($i = $currentYear; $i >= $startingYear; $i--)
					<button
						class="download-button"
						name="year"
						value="{{ $i }}"
					>
						Scarica le classi registrate dell'anno scolastico {{ $i }}/{{ $i + 1 }}
						{!! embed_icon('download') !!}
					</button>
				@endfor

			</form>
		</div>

		<!-- Reviews -->
		<div class="panel surface">
			<h2 class="panel_title">Questionari</h2>

			{{-- First second year --}}
			<form
				class="download-buttons"
				method="POST"
				action="{{ route('admin.database.download.reviews') }}"
			>
				<input
					type="hidden"
					name="reviewId"
					value="1"
				>

				<button
					class="download-button font-bold"
					name="cypher"
					value="1"
				>
					Scarica il cifrario dei questionari iniziali di prima e seconda
					{!! embed_icon('download') !!}
				</button>

				<button
					class="download-button"
					name="year"
					value="all"
				>
					Scarica la lista dei questionari iniziali di prima e seconda
					{!! embed_icon('download') !!}
				</button>

				@for ($i = $currentYear; $i >= $startingYear; $i--)
					<button
						class="download-button"
						name="year"
						value="{{ $i }}"
					>
						Scarica la lista dei questionari iniziali di prima e seconda per l'anno {{ $i }}/{{ $i + 1 }}
						{!! embed_icon('download') !!}
					</button>
				@endfor

			</form>

			<hr class="text-neutral-300">

			{{-- Third year --}}
			<form
				class="download-buttons"
				method="POST"
				action="{{ route('admin.database.download.reviews') }}"
			>
				<input
					type="hidden"
					name="reviewId"
					value="2"
				>

				<button
					class="download-button font-bold"
					name="cypher"
					value="1"
				>
					Scarica il cifrario dei questionari di terza
					{!! embed_icon('download') !!}
				</button>

				<button
					class="download-button"
					name="year"
					value="all"
				>
					Scarica la lista dei questionari di terza
					{!! embed_icon('download') !!}
				</button>

				@for ($i = $currentYear; $i >= $startingYear; $i--)
					<button
						class="download-button"
						name="year"
						value="{{ $i }}"
					>
						Scarica la lista dei questionari di terza per l'anno {{ $i }}/{{ $i + 1 }}
						{!! embed_icon('download') !!}
					</button>
				@endfor

			</form>

			<hr class="text-neutral-300">

			{{-- End questionaire --}}
			<form
				class="download-buttons"
				method="POST"
				action="{{ route('admin.database.download.reviews') }}"
			>
				<input
					type="hidden"
					name="reviewId"
					value="3"
				>

				<button
					class="download-button font-bold"
					name="cypher"
					value="1"
				>
					Scarica il cifrario dei questionari finali
					{!! embed_icon('download') !!}
				</button>

				<button
					class="download-button"
					name="year"
					value="all"
				>
					Scarica la lista dei questionari finali
					{!! embed_icon('download') !!}
				</button>

				@for ($i = $currentYear; $i >= $startingYear; $i--)
					<button
						class="download-button"
						name="year"
						value="{{ $i }}"
					>
						Scarica la lista dei questionari finali per l'anno {{ $i }}/{{ $i + 1 }}
						{!! embed_icon('download') !!}
					</button>
				@endfor

			</form>
		</div>

		<!-- Results -->
		<!-- <div class="panel surface" method="POST">
		<h2 class="panel_title">Risultati</h2>

		<div class="download-buttons">

			<button class="download-button" name="download-results" value="all">
				Scarica la lista di tutti i risultati
				<div class="text-icon text-icon--small icon-box">
					{!! embed_icon('download') !!}
				</div>
			</button>

			@for ($i = $currentYear; $i >= $startingYear; $i--)
<button class="download-button" name="download-results" value="{{ $i }}">
					Scarica i risultati degli studenti dell'anno scolastico {{ $i }}/{{ $i + 1 }}
					<div class="text-icon text-icon--small icon-box">
						{!! embed_icon('download') !!}
					</div>
				</button>
@endfor

		</div>
	</div> -->

		<!-- Advices -->
		<!-- <div class="panel surface" method="POST">
		<h2 class="panel_title">Consigli orientativi</h2>

		<div class="download-buttons">

			<button class="download-button" name="download-advices" value="all">
				Scarica la lista di tutti i consigli orientativi
				{!! embed_icon('download') !!}
			</button>

			@for ($i = $currentYear; $i >= $startingYear; $i--)
<button class="download-button" name="download-advices" value="{{ $i }}">
					Scarica i consigli orientativi dati nell'anno scolastico {{ $i }}/{{ $i + 1 }}
					{!! embed_icon('download') !!}
				</button>
@endfor

		</div>
	</div> -->
	</div>

</x-layouts.admin-dashboard>
