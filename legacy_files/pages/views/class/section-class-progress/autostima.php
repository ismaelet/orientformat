{% block content %}

<h1 class="txt-3rem txt-med fa-center mar-b-2">Risultati Autostima</h1>

<p class="fa-center txt-1rem">
	Qui puoi controllare i risultati delle autovalutazioni relative all'autostima.<br>
	Compariranno solo gli studenti che hanno completato almeno una delle autovalutazioni.<br>
	Le due barre orizzontati rappresentano le medie della classe e di tutti i partecipanti alla piattaforma.<br>
</p>

<div class="mar-t-2">
	<?php graph_columns($graphData) ?>
</div>

{% end content %}