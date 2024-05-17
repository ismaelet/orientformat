{% extends main %}

{% block main %}

<!-- Slider -->
<section id="slider">

	<div id="bgr-img" class="bgr" <?= background_image('/pages/assets/management/bgr.png') ?>></div>

</section>

<!-- Content -->
<section class="main-wrap pad-b-5">

	<!-- Title -->
	<div class="title-box mar-t-4 txt-cen">
		<h1 class="title txt-25rem txt-sbold"><?= $edit ? 'Modifica' : $title ?></h1>
		<p class="stitle txt-1rem mar-t-1"><?= $edit ? $stitle_edit . ' <strong>' . $row[$name] . '</strong>' : $stitle_add ?></p>
		<a href="<?= $edit ? client_url('/' . str_replace('add', 'list', $view->name)) : client_url('/management') ?>" class="sbtn back"><?= $edit ? 'Torna alla lista' : 'Torna alla gestione' ?></a>
	</div>

	<!-- Form -->
	<form method="POST" action="#form" id="form" class="mar-t-4">

		<?= gen_form($inputs, $row, $error) ?>

		<?php if ($done) { ?>
			<p class="inp ok mar-t-1">Elemento aggiunto con successo</p>
		<?php } ?>

		<div class="txt-cen mar-t-1">
			<button type="submit" name="<?= $edit ? 'edit' : 'add' ?>" class="button"><?= $edit ? 'Modifica' : 'Aggiungi' ?></button>
		</div>

	</form>

</section>

{% end main %}