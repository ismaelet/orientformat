{% block content %}

<div class="grid-flow" data-columns="25rem" data-spacing="700">

	<?php foreach ($panels as $panel) { ?>

		<!-- Panel -->
		<div class="panel-wrapper">
			<h3 class="panel__title panel__title--outside"><?= $panel['title'] ?></h3>

			<section class="panel">
				<div class="panel__header">
					<div class="panel__icon">
						<?= icon_embed(APP_ICONS_DIR . 'navigation/' . $panel['slug']) ?>
					</div>
					<p class="heading-like"><?= $panel['info'] ?></p>
				</div>

				<div class="panel__body">
				</div>

				<div class="panel__footer">
					<a href="<?= $panel['primary-button']['link'] ?>" class="button button--small button--full-width"><?= $panel['primary-button']['label'] ?></a>

					<?php if (isset($panel['secondary-button'])) { ?>
						<a href="<?= $panel['secondary-button']['link'] ?>" class="button button--small button--secondary button--full-width"><?= $panel['secondary-button']['label'] ?></a>
					<?php } ?>
				</div>
			</section>
		</div>

	<?php } ?>

</div>

{% end content %}