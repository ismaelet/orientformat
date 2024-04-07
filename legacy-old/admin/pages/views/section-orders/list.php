<?php

use function Ecommerce\ecommerce_config;

?>


{% block filter %}

<div class="filters mar-t-1 grid-flow" data-spacing="700">

	<!-- Status -->
	<div class="filter">
		<div class="filter__title">
			<h3 class="fw-bold flex-group">
				Stato

				<?php if ($selectedCartStatuses != $defaultCartStatuses) { ?>

					<span class="interactive js-remove-status-filter">
						<?= icon_embed('close') ?>
					</span>

				<?php } ?>

			</h3>
		</div>

		<div class="flex-group mar-t-1" data-spacing="200">
			<input type="checkbox" class="hidden js-empty-filter-status" name="empty-filter-status" <?= empty($selectedCartStatuses) ? 'checked' : '' ?> data-default-status="0">

			<?php foreach (ecommerce_config('cart-statuses') as $statusId => $status) { ?>

				<label class="status-filter checkbox status-color--<?= $status[0] ?>">
					<input type="checkbox" class="js-status-filter" name="filter-status[]" value="<?= $statusId ?>" <?= in_array($statusId, $selectedCartStatuses) ? 'checked' : '' ?> data-default-status="<?= $statusId > 0 ? 1 : 0 ?>">
					<span></span>
					<p class=""><?= $status[1] ?></p>
				</label>

			<?php } ?>

			<label class="status-filter checkbox">
				<input type="checkbox" class="js-status-all" value="all" <?= $statusIds == $selectedCartStatuses ? 'checked' : '' ?> data-default-status="0">
				<span></span>
				<p class="">Tutti</p>
			</label>

		</div>
	</div>
</div>

{% end filter %}