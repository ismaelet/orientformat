{% block dashboard-body %}

<div class="page__content grid center-content">
	<div class="grid" data-spacing="700">
		<h1 class="section-title">Consigli orientativi</h1>
		<p class="section-subtitle">Qui puoi attribuire i consigli orientativi agli studenti alla fine del percorso oppure puoi comparare i consigli<br>orientativi dati alle intenzioni che gli studenti hanno indicato riguardo alla scelta della scuola superiore.</p>
	</div>

	<div class="page-content">
		<a class="dashboard-panel" href="<?= client_url('/class/students/suggestion/give') ?>">
			<div class="dashboard-panel_icon icon-box">
				<?= embed_icon('suggestion') ?>
			</div>
			<div class="">
				<h2 class="text-6xl font-bold tracking-wide">POI</h2>
				<p class="text-2xl"><span class="font-bold">P</span>rofilo <span class="font-bold">O</span>rientativo <span class="font-bold">I</span>ndividualizzato</p>
				<p class="text-lg text-neutral-350">- Certificazione delle competenze -</p>
			</div>
		</a>

		<!-- <a class="dashboard-panel" href="<?= client_url('/class/students/suggestion/compare') ?>">
			<div class="dashboard-panel_icon icon-box">
				<?= embed_icon('section2') ?>
			</div>
			<h2 class="dashboard-panel_title">Compara i consigli orientativi</h2>
		</a> -->
	</div>
</div>

{% end dashboard-body %}