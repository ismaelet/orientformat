@pushOnce('styles')
	<style>
		main article {
			font-size: 1.125rem;
			line-height: 2;
			padding-bottom: 3rem;
			border-bottom: 1px solid var(--color-slate-300);

			&:last-child {
				border-bottom: none;
				padding-bottom: 0;
			}

			ul {
				margin-left: 2rem;
				list-style: outside;
			}

			ul>li>ul {
				list-style: circle;
			}

			ol {
				display: grid;
				grid-template-columns: minmax(0, 1fr);
				gap: 1rem;
				list-style-type: decimal;
				margin-left: 1.5rem;
			}

			ol>li::marker {
				font-weight: bold;
				font-size: 1.25rem
			}

			h4 {
				font-size: 1.25rem;
				font-weight: 600;
			}

			table {
				border-collapse: separate;
				border-spacing: 4rem 1rem;
				margin: -1rem -4rem;
				margin-top: 2rem;

				td {
					font-size: 1rem;
				}
			}
		}
	</style>
@endpushOnce

<x-layouts.test
	:$title
	:$test
>
	<div class="mb-20 mt-10">
		<x-test.title :$test />

		<div class="mt-12 grid grid-cols-1 gap-12">
			<div class="grid grid-cols-1 gap-4">
				<x-heading.component>
					Problemi di classe:</x-heading.component>
				<ul class="grid grid-cols-1 gap-2">
					<li>1. Difficoltà da parte di un compagno a inserirsi nel gruppo.</li>
					<li>2. Nella scuola è stato vietato
						l’uso di qualsiasi strumento digitale, anche per attività didattiche. È urgente individuare un "ambasciatore
						digitale" da proporre all’istituzione.</li>
					<li>3. Un conflitto tra compagni che turba la vita di classe.</li>
					<li>4. L’intelligenza artificiale aiuta o danneggia?</li>
					<li>5. Il rapporto con un insegnante non funziona.</li>
					<li>6. Programmi di studio o modi di
						condurre la lezione che non convincono.</li>
					<li>7. Come utilizzare al meglio la piattaforma OrientFormat.</li>
				</ul>
			</div>

			@if (is_teacher() || $student->class->grade()->absolute_number >= 7 || $student->class->isProfessional())
				<div class="grid grid-cols-1 gap-4">
					<x-heading.component>
						Problemi nell’alternanza scuola-lavoro:</x-heading.component>
					<ul class="grid grid-cols-1 gap-2">
						<li>1. Il luogo di lavoro
							non offre garanzie sufficienti di sicurezza (materiale o psicologica).</li>
						<li>2. Le attività proposte non sono coerenti col
							percorso di studi.</li>
						<li>3. Il tutoraggio da parte della scuola o dell’azienda non sembra adeguato.</li>
						<li>4. L’impegno
							richiesto è incompatibile con le esigenze di studio.</li>
						<li>5. I compiti svolti gratuitamente sembrano più uno
							sfruttamento che un’occasione formativa.</li>
						<li>6. Le attività teoriche/pratiche simulate nell’istituto non sembrano
							sufficientemente strutturate ed efficaci.</li>
						<li>7. Non c’è o non risulta efficace l’interazione fra orientamento e
							alternanza.</li>
					</ul>
				</div>
			@endif
		</div>

		<section class="mt-16">
			<x-heading.section class="text-center">Problema: Una compagna di classe è fatta oggetto di cyberbullismo. Come
				aiutarla?<br><br>Esempio di soluzione</x-heading.section>
			<p class="mt-4 text-center text-xl">(In evidenza le caratteristiche di ogni ruolo)</p>

			<div class="mt-20 grid grid-cols-1 gap-20">

				{{-- Esploratore --}}
				@include('tests.problemi-superiori.esempio-problem_esploratore')

				{{-- Stratega --}}
				@include('tests.problemi-superiori.esempio-problem_stratega')

				{{-- Critico --}}
				@include('tests.problemi-superiori.esempio-problem_critico')

				{{-- Saggio --}}
				@include('tests.problemi-superiori.esempio-problem_saggio')
			</div>
		</section>

		<div class="mt-8 flex w-full">
			<x-test.button
				:$test
				class="w-full"
			/>
		</div>
	</div>
</x-layouts.test>
