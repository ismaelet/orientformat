<?php

use Ecommerce\Cart;

$updated = false;
$added = false;

$id = ViewOld::get('id');
$cart = new Cart($id);

ViewOld::setTitle('Ordine ' . $cart->idCode);

/**
 * Page config
 */
$pageConfig['free'] = true;

/**
 * Form events
 */
if (isset($_POST['statusId'])) {
	$statusId = $_POST['statusId'];
	$comment = $_POST['comment'] ?? null;

	$cart->updateStatusId($statusId);

	if ($comment) {
		if (\System\Classes\DBOld::exists('ecommerce_carts_comments WHERE cartId=?', $id)) {
			\System\Classes\DBOld::update('ecommerce_carts_comments SET comment=? WHERE cartId=?', [$comment, $id]);
		} else {
			\System\Classes\DBOld::add('ecommerce_carts_comments (cartId, comment) VALUES (?, ?)', [$id, $comment]);
		}
	}

	$updated = true;
}

if (isset($_POST['update-tracking'])) {
	$cart->updateTrackingCode($_POST['tracking']);

	$updated = true;
}
