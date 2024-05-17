{% extends admin %}

{% block content %}

<form class="content-wrap grid-flow js-form" data-spacing="400" id="form" method="POST" enctype="multipart/form-data">

	<!-- Title -->
	<div class="page-title flex-group" data-spacing="200">
		<a href="list" class="title-arrow border border-radius">
			<?= embed_icon('navigation/arrow1-left') ?>
		</a>

		<h1 class="panel__title"><?= ViewOld::$title ?></h1>
	</div>

	<?php if ($added) { ?>

		<p class="confirmation-message">Elemento aggiunto</p>

	<?php } else if ($updated) { ?>

		<p class="confirmation-message">Modifiche salvate</p>

	<?php } ?>

	<!-- Page body -->
	<div class="page-body mar-t-3">

		{% place page-body %}

	</div>

	<?php if (!$pageConfig['free']) { ?>

		<!-- Footer -->
		<section class="page-footer">

			<?php if (ViewOld::get('id') && $pageConfig['delete']) { ?>

				<!-- Delete -->
				<button type="submit" class="button button--secondary button--auto-width button--bad" name="delete" onclick="return confirm('Confermi di voler eliminare questo elemento? Non potrà essere ripristinato.')">
					<?= embed_icon('delete') ?>
					Elimina l'elemento
				</button>

			<?php } ?>

			<?php if (!empty($pageConfig['preview-url'])) { ?>

				<!-- Preview -->
				<a class="button button--secondary button--auto-width" href="<?= $pageConfig['preview-url'] ?>" target="_blank">
					<?= embed_icon('view') ?>
					Anteprima
				</a>

			<?php } ?>

			<!-- Save -->
			<button type="submit" class="button" name="submit">
				<?= ViewOld::get('id') ? 'Salva' : 'Aggiungi' ?>
				<?= embed_icon(ViewOld::get('id') ? 'save' : 'add') ?>
			</button>
		</section>

	<?php } ?>

</form>

<!-- Loading panel -->
<div class="loading center-content js-loading">
	<?= embed_icon('loading') ?>
</div>

{% end content %}