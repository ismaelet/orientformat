{% block main %}

<div class="main-wrap pad-v-10 grid">

	<div>
		<h1 class="brb2 fa-center txt-sbold pad-b-05">Password rigenerata</h1>
		<p class="txt-1rem pad-t-2">La password dell'utente è stata rigenerata e la nuova password può essere usata per accedere alla piattaforma. È importante comunicarla allo studente/studentessa in quanto, per motivi di sicurezza, non sarà più possibile visualizzarla una volta che questà pagina sarà chiusa.</p>
		<p class="txt-15rem pad-t-2 fa-center">Nuova password: <span class="fw-bold"><?= $password ?></span></p>

		<div class="fa-center mar-t-3">
			<a href="<?= client_url('/teacher/students') ?>" class="button button--secondary">Torna indietro</a>
		</div>

	</div>

</div>

{% end main %}