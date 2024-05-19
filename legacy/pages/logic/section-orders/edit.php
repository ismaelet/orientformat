<?php

use Ecommerce\Cart;

global $cart;

$id = $_GET['id'] ?? false;
$updated = $_GET['updated'] ?? false;
$added = false;

/*
* Setup cart
*/
$cart = new Cart($id);
\App\Legacy\LegacyView::$title = 'Ordine ' . $cart->idCode;

/*
* Form events
*/
if (isset($_POST['change-status'])) {
	$status = $_POST['change-status'];
	$comment = $_POST['comment'] ?? false;

	$cart->updateStatus($status);

	if ($comment) {
		if (\App\Legacy\LegacyDB::exists('ecommerce_carts_comments WHERE cartId=?', $id))
			\App\Legacy\LegacyDB::update('ecommerce_carts_comments SET comment=? WHERE cartId=?', [$comment, $id]);
		else
			\App\Legacy\LegacyDB::add('ecommerce_carts_comments (cartId, comment) VALUES (?, ?)', [$id, $comment]);
	}

	redirect_old();
}

if (isset($_POST['update-tracking'])) {
	$cart->updateTracking($_POST['tracking']);
	redirect_old();
}
