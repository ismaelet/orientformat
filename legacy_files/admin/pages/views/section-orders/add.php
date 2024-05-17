{% block page-body %}

<!-- Main content -->
<div class="main-content grid-flow" data-spacing="700">

	<!-- Orders -->
	<section>
		<h3 class="panel__subtitle panel__subtitle--outside">Dati dell'ordine</h3>

		<div class="panel">
			<div class="order-data grid-flow" data-spacing="400">
				<div class="order-data__item">
					<div class="title-block flex-group">
						<div class="status-icon status-color--<?= $cart->statusCode ?>">
							<?= icon_embed($cart->statusIcon) ?>
						</div>

						<p class="status-name"><?= $cart->statusName ?></p>
					</div>
				</div>

				<?php if (false && $cart->comment && $cart->status == -1) { ?>

					<div class="order-data__item">
						<p class="mar-t-1"><?= $cart->comment ?></p>
					</div>

				<?php } ?>

				<!-- Orders list -->
				<?php foreach ($cart->orders as $order) { ?>

					<div class="order-data__item">
						<div class="order">
							<img src="<?= $order->product->clientImage ?>" alt="" class="order__image image-fill">
							<p class="order__name"><?= $order->name ?></p>
							<p class="order__price"><?= $order->fullPriceString ?></p>
						</div>
					</div>

				<?php } ?>

				<!-- Recap -->
				<?php if ($cart->couponId) { ?>

					<div class="order-data__item">
						<div class="recap__row">
							<p class="recap__text">Codice</p>
							<p class="recap__price"><?= $cart->coupon->code ?></p>
						</div>
					</div>

				<?php } ?>

				<?php if ($cart->discount) { ?>

					<div class="order-data__item">
						<div class="recap__row">
							<p class="recap__text">Sconto</p>
							<p class="recap__price">-<?= $cart->discountString ?></p>
						</div>
					</div>

				<?php } ?>

				<div class="order-data__item">
					<div class="recap__row">
						<p class="recap__text">Spedizione</p>
						<p class="recap__price"><?= $cart->shippingPriceString ?></p>
					</div>
				</div>

				<div class="order-data__item">
					<div class="recap__row recap__row--total">
						<p class="recap__text">Totale</p>
						<p class="recap__price"><?= $cart->priceString ?></p>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="cart-actions flex-group">
		<?php if ($cart->statusCode != 'canceled') { ?>

			<button type="submit" class="cart-action button button--auto-width button--secondary button--bad" name="statusId" value="-1">
				<?= icon_embed('close') ?>
				Cancella l'ordine
			</button>

		<?php } ?>

		<?php if ($cart->statusCode == 'canceled') { ?>

			<button type="submit" class="cart-action button button--auto-width" name="statusId" value="1">
				<?= icon_embed('correct') ?>
				Ripristina l'ordine
			</button>

		<?php } else if ($cart->statusCode == 'waiting-payment') { ?>

			<button type="submit" class="cart-action button button--auto-width" name="statusId" value="2">
				<?= icon_embed('correct') ?>
				Pagamento ricevuto
			</button>

		<?php } else if ($cart->statusCode == 'confirmed-payment') { ?>

			<button type="submit" class="cart-action button button--auto-width" name="statusId" value="3">
				<?= icon_embed('correct') ?>
				Spedito
			</button>

		<?php } else if ($cart->statusCode == 'shipped') { ?>

			<button type="submit" class="cart-action button button--auto-width" name="statusId" value="4">
				<?= icon_embed('correct') ?>
				Consegnato
			</button>

		<?php } ?>

	</section>
</div>

<!-- Side bar -->
<aside class="side-bar">
	<section class="side-bar__block">
		<h3 class="panel__subtitle panel__subtitle--outside">Dati del cliente</h3>

		<div class="panel">
			<div class="form-inputs">
				<div class="form-field">
					<p class="lbl">Nome completo</p>
					<p class="text"><?= $cart->address->fullName ?></p>
				</div>

				<div class="form-field">
					<p class="lbl">Contatti</p>
					<p class="text">
						<a class="link" href="tel:<?= $cart->address->phone ?>"><?= $cart->address->phone ?></a><br>
						<a class="link" href="mailto:<?= $cart->address->email ?>"><?= $cart->address->email ?></a>
					</p>
				</div>
			</div>
		</div>
	</section>

	<section class="side-bar__block">
		<h3 class="panel__subtitle panel__subtitle--outside">Indirizzo</h3>

		<div class="panel">
			<p class="text"><?= $cart->address->fullAddress ?></p>

			<?php if ($cart->status > 1) { ?>

				<div class="tracking mar-t-1">
					<input type="text" class="inp mar-t-1" name="tracking" value="<?= $cart->tracking ?>" placeholder="Codice di tracking">
					<button type="submit" class="button mar-t-1 hidden" name="update-tracking">Salva</button>
				</div>

			<?php } ?>

		</div>
	</section>
</aside>

<!-- Loading panel -->
<div class="loading">
	<div class="load-icon place-cen"></div>
</div>

<!-- Cancel order modal -->
<dialog class="modal" id="cancel-order-modal">
	<div class="modal-form" method="POST">

		<div class="modal-form-header">
			<h2>Cancella l'ordine</h2>
		</div>

		<div class="modal-form-body">
			<p class="mar-b-05">Qui è possibile aggiungere un commento per spiegare perché l'ordine è stato cancellato.</p>
			<textarea class="textarea" name="comment" placeholder="Commento (opzionale)"></textarea>
		</div>

		<div class="modal-form-footer">
			<div class="button button--secondary" data-function="close-modal">Indietro</div>
			<button type="submit" class="button" name="statusId" value="canceled" data-style="warning">Cancella l'ordine</button>
		</div>
	</div>
</dialog>

{% end page-body %}