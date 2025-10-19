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
						l’uso di qualsiasi strumento digitale, anche per attività didattiche. È urgente individuare un &quot;ambasciatore
						digitale&quot; da proporre all’istituzione.</li>
					<li>3. Un conflitto tra compagni che turba la vita di classe.</li>
					<li>4. L’intelligenza artificiale aiuta o danneggia?</li>
					<li>5. Il rapporto con un insegnante non funziona.</li>
					<li>6. Programmi di studio o modi di
						condurre la lezione che non convincono.</li>
					<li>7. Come utilizzare al meglio la piattaforma OrientFormat.</li>
				</ul>
			</div>

			@if ($student->class->grade()->absolute_number >= 7 || $student->class->isProfessional())
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

			<div class="mt-20">
				<article>
					<div class="flex flex-wrap items-center gap-8">
						<img
							src="{{ Vite::image('tests/problemi-superiori/role-2-sm.webp') }}"
							alt="Esploratore"
							class="rounded-4xl w-50"
						>
						<x-heading.component-big>L'Esploratore</x-heading.component-big>

						<p class="text-lg leading-loose"><strong>Accorgendosi prima degli altri quando c’è un problema</strong>,
							affronterebbe la
							condizione in cui si è
							venuta a
							trovare la compagna concentrandosi inizialmente sulla raccolta di informazioni complete e
							sull&#39;identificazione di opzioni di intervento non convenzionali.<br><br>
							Ecco come agirebbe, in linea con le sue caratteristiche.<br><br>
							1. Ricerca approfondita e multidimensionale
							L&#39;Esploratore non si limiterebbe a ciò che è immediatamente ovvio, ma cercherebbe attivamente la
							&quot;novità&quot; (ovvero, l&#39;informazione completa e le cause profonde) del problema.
							 Identificazione precoce del problema: agendo sulla sua capacità di accorgersi del problema prima
							degli altri, si assicurerebbe che il fenomeno non venga ignorato o minimizzato.
							 Visione da diversi punti di vista:
							o Vittima: raccoglierebbe dati sulle emozioni della vittima, sul come il bullismo la influenza e
							sui luoghi virtuali specifici in cui avviene.
							o Bulli: cercherebbe di comprendere le motivazioni e le dinamiche di gruppo che spingono gli
							aggressori (non per giustificare, ma per capire come interrompere il ciclo).
							o Contesto tecnologico: indagherebbe a fondo sulle piattaforme utilizzate (social media,
							gruppi di chat, forum) per comprendere le loro specifiche meccaniche di diffusione e
							segnalazione.

							 Prende in considerazione diverse ipotesi: non fermandosi alla prima idea (&quot;Diciamolo agli
							insegnanti&quot;), ma raccogliendo diverse ipotesi di causa (es. problemi a casa, dinamiche di classe non
							risolte, uso improprio di specifici strumenti digitali) e di soluzione.
							2. Generazione di soluzioni innovative e personalizzate
							Poiché le soluzioni note e già sperimentate lo annoiano, l&#39;Esploratore si concentrerebbe sulla creazione di
							un ventaglio di interventi originali, andando oltre le classiche punizioni scolastiche.
							 Intervento tecnologico: esplorerebbe l&#39;uso di strumenti digitali per contrastare il fenomeno, ad
							esempio:
							o Creare una campagna di sensibilizzazione mirata sulle piattaforme dove avviene il
							cyberbullismo.
							o Cercare modi per utilizzare i meccanismi di segnalazione efficaci e rapidi offerti dalle
							piattaforme stesse.
							o Proporre l&#39;introduzione di un &quot;ambasciatore digitale&quot; a scuola, non solo un mediatore, ma
							un esperto delle dinamiche online.

							 Approccio empatico (diversi punti di vista): suggerirebbe un intervento che tenga conto del benessere
							emotivo della vittima, magari creando un sistema di supporto tra pari anonimo per chi ha paura di
							parlare.
							 Soluzione preventiva a lungo termine: invece di limitarsi a risolvere il singolo caso, l&#39;Esploratore
							proporrebbe una soluzione più ampia che affronti il problema della cultura digitale della classe o della
							scuola. Ad esempio, introdurre laboratori di digital citizenship interattivi anziché noiose lezioni frontali.
							In sintesi, l&#39;Esploratore si concentrerebbe sulla fase di diagnosi e ideazione del problema: raccoglierebbe
							il
							maggior numero di informazioni, formulerebbe diverse ipotesi e proporrebbe soluzioni fresche e mirate
							che tengano conto di tutti gli aspetti del problema. Lascerebbe poi al Critico e allo Stratega il compito di
							valutare e attuare l&#39;opzione migliore.</p>
					</div>
				</article>
			</div>
		</section>
	</div>
</x-layouts.test>
