{% block content %}

<!-- Slider -->
<section class="page__background">
	<div class="background fill-all" <?= background_image('bgr') ?>></div>
</section>

<!-- Content -->
<div class="page__content main-wrap">

	<?= title() ?>

	<div class="mar-t-5 center-content">
		<a href="<?= client_path('Curriculum.pdf') ?>" target="_blank" class="button button--auto-width">
			<?= embed_icon('download') ?>
			Scarica il curriculum
		</a>
	</div>

</div>

{% end content %}