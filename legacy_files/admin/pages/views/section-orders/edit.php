{% block page-body %}

<!-- Main content -->
<div class="main-content grid gap2">

	<!-- Orders -->
	<section class="form">

		<h3 class="form-title">Dati dell'ordine</h3>

		<div class="form-content">

			<div class="flex-line">
				<div class="status-icon icon-box" style="--_status-color: <?= $cart->statusColor ?>">
					<?= icon_embed($cart->statusIcon) ?>
				</div>

				<h3 class="txt-med txt-1rem txt-ls05"><?= $cart->statusStr ?></h3>
			</div>

			<?php if ($cart->comment && $cart->status == -1) { ?>
				<p class="mar-t-1"><?= $cart->comment ?></p>
			<?php } ?>

			<!-- Orders list -->
			<div class="orders mar-t-2">

				<?php foreach ($cart->orders as $order) { ?>

					<div class="order">
						<img src="<?= file_public_url($order->item->image()) ?>" alt="" class="order_img img-fill">
						<p class="order_name"><?= $order->name ?></p>
						<p class="order_price"><?= $order->totalOriginalPriceStr ?></p>
					</div>

				<?php } ?>

			</div>

			<!-- Recap -->
			<div class="recap">
				<?php if ($cart->couponId) { ?>
					<div class="recap-row">
						<h3 class="recap-text">Codice</h3>
						<p class="recap-price"><?= $cart->coupon->code ?></p>
					</div>
				<?php } ?>

				<?php if ($cart->discount) { ?>
					<div class="recap-row">
						<h3 class="recap-text">Sconto</h3>
						<p class="recap-price">-<?= format_price($cart->discount) ?></p>
					</div>
				<?php } ?>

				<div class="recap-row">
					<h3 class="recap-text">Spedizione</h3>
					<p class="recap-price"><?= format_price($cart->shippingPrice) ?></p>
				</div>

				<div class="recap-row recap-row_total">
					<h3 class="recap-text">Totale</h3>
					<p class="recap-price"><?= format_price($cart->price) ?></p>
				</div>
			</div>
		</div>
	</section>

	<section class="cart-actions flex-line">
		<?php if ($cart->status > 0) { ?>
			<button type="button" class="cart-action cart-action_cancel sbtn sbtn--bad btn-with-icons" data-style="warning" data-function="open-modal" data-target="cancel-order-modal" name="change-status" value="canceled">
				<div class="text-icon" <?= icon_svg('close') ?>></div>
				Cancella l'ordine
			</button>
		<?php } ?>

		<?php if ($cart->status == -1) { ?>
			<button type="submit" class="cart-action cart-action_restore pbtn btn-with-icons" name="change-status" value="waiting-payment">
				<div class="text-icon" <?= icon_svg('correct') ?>></div>
				Ripristina l'ordine
			</button>
		<?php } else if ($cart->status == 1) { ?>
			<button type="submit" class="cart-action cart-action_accept pbtn btn-with-icons" name="change-status" value="confirmed">
				<div class="text-icon" <?= icon_svg('correct') ?>></div>
				Pagamento ricevuto
			</button>
		<?php } else if ($cart->status == 2) { ?>
			<button type="submit" class="cart-action cart-action_send pbtn btn-with-icons" name="change-status" value="shipped">
				<div class="text-icon" <?= icon_svg('correct') ?>></div>
				Spedito
			</button>
		<?php } else if ($cart->status == 3) { ?>
			<button type="submit" class="cart-action cart-action_delivered pbtn btn-with-icons" name="change-status" value="delivered">
				<div class="text-icon" <?= icon_svg('correct') ?>></div>
				Consegnato
			</button>
		<?php } ?>
	</section>
</div>

<!-- Side bar -->
<aside class="side-bar">

	<section class="form">
		<h3 class="form-title">Dati del cliente</h3>

		<div class="form-content">
			<div class="form-inputs">
				<div class="form-field">
					<p class="lbl">Nome completo</p>
					<p><?= $cart->address->fullname ?></p>
				</div>
				<div class="form-field">
					<p class="lbl">Contatti</p>
					<p>
						<a class="link" href="tel:<?= $cart->address->phone ?>"><?= $cart->address->phone ?></a><br>
						<a class="link" href="mailto:<?= $cart->address->email ?>"><?= $cart->address->email ?></a>
					</p>
				</div>
			</div>
		</div>
	</section>

	<section class="form">
		<h3 class="form-title">Indirizzo</h3>

		<div class="form-content">
			<p class="txt-med txt-lh2"><?= $cart->address->fullAddress ?></p>

			<?php if ($cart->status > 1) { ?>
				<div class="tracking mar-t-1">
					<input type="text" class="inp mar-t-1" name="tracking" value="<?= $cart->tracking ?>" placeholder="Codice di tracking">
					<button type="submit" class="pbtn mar-t-1 hidden" name="update-tracking">Salva</button>
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
			<div class="sbtn" data-function="close-modal">Indietro</div>
			<button type="submit" class="pbtn" name="change-status" value="canceled" data-style="warning">Cancella l'ordine</button>
		</div>
	</div>
</dialog>

{% end page-body %}