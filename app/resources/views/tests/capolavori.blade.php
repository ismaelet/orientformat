@php
	$returnUrl = is_student()
	    ? route('activities.grades.show', ['grade' => student()->class->grade()])
	    : route('teacher.simulation');
@endphp

<x-layouts.main :$title>
	<div class="mt-12 text-center">
		<x-heading.main>Capolavori</x-heading.main>
	</div>

	<div class="my-8 flex justify-center">
		<x-button
			href="{{ $returnUrl }}"
			variant="secondary"
		>Indietro</x-button>
	</div>

	<p class="text-lg">Un “capolavoro” è un prodotto realizzato in ambiente scolastico o extra-scolastico, attraverso
		attività svolte
		individualmente oppure in gruppo.
		Il capolavoro è importante perché dimostra un qualche progresso o una maggiore competenza in qualche tipo di attività.
		Puoi inserire anche
		più capolavori nel corso dell’anno, procedendo in questo modo: dai un titolo al tuo capolavoro, seleziona la tipologia
		di attività in cui è nato e
		collegalo ad una competenza che hai sviluppato. Infine carica l’allegato in un formato PDF.<br><br>

		I capolavori che riterrai più importanti (al massimo tre per ogni anno scolastico), li potrai inserire nel tuo
		e-portfolio nel sito <a
			class="text-link"
			target="_blank"
			href="https://unica.istruzione.gov.it/portale/it/orientamento/il-tuo-percorso/e-portfolio"
		>UNICA</a>.<br><br>


		<span class="text-error-400">A conclusione dell’anno scolastico i capolavori saranno rimossi da questo sito.</span>
	</p>

	<div class="shadow-round mb-20 mt-12 grid grid-cols-1 gap-8 rounded p-4 sm:p-8">
		<x-form.open-input
			class="text-center text-lg font-semibold text-neutral-700"
			placeholder="Inserisci il titolo del capolavoro"
		/>

		<div class="max-w-200 mx-auto grid w-full gap-12 lg:grid-cols-2">
			<x-form.field class="">
				<x-label>Nato in ambito</x-label>
				<x-checkbox
					type="radio"
					name="setting"
					text="Scolastico"
				/>
				<x-checkbox
					type="radio"
					name="setting"
					text="Extra-scolastico"
				/>
			</x-form.field>

			<x-form.field class="">
				<x-label>In modalità</x-label>
				<x-checkbox
					type="radio"
					name="mode"
					text="Individuale"
				/>
				<x-checkbox
					type="radio"
					name="mode"
					text="In gruppo"
				/>
			</x-form.field>
		</div>

		<div class="max-w-200 mx-auto grid w-full gap-12 lg:grid-cols-2">
			<x-form.field class="">
				<x-label>Tipologia di attività</x-label>
				<x-checkbox
					type="radio"
					name="type"
					text="Culturale e artistica"
				/>
				<x-checkbox
					type="radio"
					name="type"
					text="Letteraria"
				/>
				<x-checkbox
					type="radio"
					name="type"
					text="Nel campo delle lingue straniere"
				/>
				<x-checkbox
					type="radio"
					name="type"
					text="Nel campo della comunicazione"
				/>
				<x-checkbox
					type="radio"
					name="type"
					text="Musicale e/o coreutica"
				/>
				<x-checkbox
					type="radio"
					name="type"
					text="In campo matematico, scientifico, tecnico, tecnologico"
				/>
				<x-checkbox
					type="radio"
					name="type"
					text="Motoria/sportiva"
				/>
				<x-checkbox
					type="radio"
					name="type"
					text="Di cittadinanza attiva e di volontariato"
				/>
				<x-checkbox
					type="radio"
					name="type"
					text="Professionale"
				/>
				<x-checkbox
					type="radio"
					name="type"
					text="Altre attività"
				/>
			</x-form.field>

			<div class="max-w-96">
				<x-form.field class="">
					<x-label>Competenza sviluppata</x-label>
					<x-checkbox
						type="radio"
						name="skill"
						text="Competenza alfabetica funzionale (Comunicazione nella lingua italiana)"
					/>
					<x-checkbox
						type="radio"
						name="skill"
						text="Competenza multilinguistica (Comunicazione nelle lingue straniere)"
					/>
					<x-checkbox
						type="radio"
						name="skill"
						text="Competenza digitale"
					/>
					<x-checkbox
						type="radio"
						name="skill"
						text="Competenza personale, sociale e capacità di imparare a imparare"
					/>
					<x-checkbox
						type="radio"
						name="skill"
						text="Competenza in materia di cittadinanza"
					/>
					<x-checkbox
						type="radio"
						name="skill"
						text="Competenza imprenditoriale (Spirito di iniziativa e imprenditorialità)"
					/>
					<x-checkbox
						type="radio"
						name="skill"
						text="Consapevolezza ed espressione culturali"
					/>
					<x-checkbox
						type="radio"
						name="skill"
						text="Non sono in grado di indicare quale competenza ho sviluppato"
					/>
				</x-form.field>
			</div>
		</div>

		<div class="grid grid-cols-1 gap-2 text-center">
			<x-label>Seleziona il capolavoro (formato PDF, max 25MB)</x-label>
			<input
				type="file"
				name="file"
				accept=".pdf"
				class="rounded-sm border border-dashed border-neutral-300 px-2 py-3"
			/>
		</div>

		<x-button
			type="submit"
			class="center-icon"
			:disabled="true"
		>
			<x-icon-upload />
			Carica capolavoro
		</x-button>

		<p class="text-error-400">* La funzionalità di caricare il capolavoro sarà attiva a partire dal 1° novembre 2025</p>
	</div>
</x-layouts.main>
