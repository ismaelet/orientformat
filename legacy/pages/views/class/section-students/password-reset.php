{% block dashboard-body %}

<div class="main-wrap py-40 grid">

	<div>
		<h1 class="brb2 txt-3rem fa-center txt-sbold pad-b-05">Password rigenerata</h1>
		<p class="txt-1rem pt-8 txt-jus">La password dell'utente è stata rigenerata e la nuova password indicata qui sotto dovrà essere usata per accedere alla piattaforma. È importante comunicarla allo alunno/a in quanto, per motivi di sicurezza, non sarà più possibile visualizzarla una volta usciti da questa pagina.</p>

		<h3 class="txt-2rem mar-t-3 fa-center txt-sbold">
			Dati di accesso:
		</h3>

		<p class="txt-13rem mar-t-1 fa-center">
			Username: <span class="font-bold"><?= $student->username ?></span><br>
			Nuova password: <span class="font-bold"><?= $password ?></span>
		</p>

		<div class="fa-center mar-t-3">
			<a href="<?= client_url('/class/students/list') ?>" class="button button--secondary">Torna indietro</a>
		</div>

	</div>

</div>

{% end dashboard-body %}