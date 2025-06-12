{% block content %}

<div class="main-wrap pad-t-4 pad-b-5">

	<!-- Title -->
	<?= title() ?>

	<h1 class="fa-center font-bold mar-t-4 mar-b-2"><?= __('tests.70-title') ?></h1>

	<p class="text txt-1rem txt-lh2 mar-b-3">
		<?= __('tests.70-text') ?><br><br>

		<span class="txt-09rem txt-rig block">
			<?= __('tests.70-author') ?>
		</span>
	</p>

	<!-- Submit -->
	<?= submit() ?>

</div>

{% end content %}