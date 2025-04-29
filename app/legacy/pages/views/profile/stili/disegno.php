{% block content %}

<!-- Review view -->
<?php if ($legacyTest->completed) { ?>

	<div id="results-sec" class="grid-flow main-wrap pad-t-5 pad-b-5" data-spacing="700">

		<?= title(__('tests.32-title'), __('tests.32-description')) ?>

		<!-- Methods -->
		<div class="grid-flow" data-columns="25rem" data-spacing="700">

			<?php foreach ($methods as $method) { ?>

				<div class="method interactive">

					<h3 class="subsection-title txt-15rem font-bold br-b-1 br-5 pad-b-05 mar-b-05"><?= $method[0] ?></h3>

					<?php foreach ($method[1] as $desc) { ?>

						<p class="desc txt-1rem txt-2 mar-b-05">- <?= $desc ?></p>

					<?php } ?>

				</div>

			<?php } ?>

		</div>

		<!-- Submit -->
		<?= submit() ?>

	</div>

	<!-- Initial view -->
<?php } else { ?>

	<div id="image-sec" class="main-wrap pad-t-5 pad-b-5">

		<?= title() ?>

		<img id="img" class="mar-t-2" src="<?= client_path('img.jpg') ?>">

		<button type="submit" name="review" class="button button--full-width mar-t-5"><?= __('tests.32-cta') ?></button>

	</div>

<?php } ?>

{% end content %}