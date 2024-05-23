<?php

use Ecommerce\Address;
use Ecommerce\Cart;
use Ecommerce\Customer;
use Ecommerce\Order;
use Ecommerce\Product;

use function Ecommerce\ecommerce_config;

$cartStatuses = ecommerce_config('cart-statuses');
$statusIds = array_keys($cartStatuses);
$defaultCartStatuses = [1, 2, 3, 4];

$selectedCartStatuses = $_GET['filter-status'] ?? $defaultCartStatuses;
$selectedCartStatuses = isset($_GET['empty-filter-status']) ? [] : $selectedCartStatuses;
$selectedCartStatusesSql = implode(',', $selectedCartStatuses);

/**
 * Page configuration
 */
$pageConfig['add'] = false;
$pageConfig['row-action'] = 'add?id={{' . Cart::INDEX . '}}';

/**
 * Query config
 */
$queryConfig['table'] = Cart::TABLE;
$queryConfig['index'] = Cart::INDEX;
$queryConfig['select'] = [Cart::TABLE . '.' . Cart::INDEX, Cart::TABLE . '.time'];
$queryConfig['from'] =
	Cart::TABLE .
	' LEFT JOIN ' . Customer::TABLE .
	' ON ' . Cart::TABLE . '.' . Cart::CUSTOMER_INDEX . ' = ' . Customer::TABLE . '.' . Customer::INDEX .
	' LEFT JOIN ' . Address::TABLE .
	' ON ' . Cart::TABLE . '.' . Cart::ADDRESS_INDEX . ' = ' . Address::TABLE . '.' . Address::INDEX;
$queryConfig['where'] = $selectedCartStatuses ? '(statusId IN (' . $selectedCartStatusesSql . '))' : 'statusId = -1000';

// handle search
$queryConfig['where-search'] = "
	(
		" . Cart::TABLE . "." . Cart::INDEX . " = ? OR
		LPAD(" . Cart::TABLE . "." . Cart::INDEX . ", 6, '0') = ? OR
		CONCAT('#', LPAD(" . Cart::TABLE . "." . Cart::INDEX . ", 6, '0')) = ? OR
		LOWER(fullName) LIKE CONCAT('%',?,'%') OR
		" . Cart::TABLE . "." . Cart::INDEX . " IN
			(
				SELECT " . Order::CART_INDEX . " FROM " . Order::TABLE . "
				INNER JOIN " . Product::TABLE . "
				ON " . Order::TABLE . "." . Order::PRODUCT_INDEX . " = " . Product::TABLE . "." . Product::INDEX . "
				WHERE LOWER(name) LIKE CONCAT('%',?,'%')
			)
		)
";

/**
 * Fields
 */
$fields = [
	['title' => 'ID', 'name' => Cart::INDEX],
	['title' => 'Dati', 'name' => 'data', 'size' => 1],
	['title' => 'Destinatario', 'name' => 'address',  'size' => 1],
	['title' => 'Contatti', 'name' => 'contacts', 'size' => 1],
	['title' => 'Articoli', 'name' => 'orders', 'size' => 1],
	['title' => 'Totale', 'name' => 'price',],
	['title' => 'Stato', 'name' => 'status',],
	['title' => 'Data', 'name' => 'time', 'parse' => 'date-day'],

	['type' => 'btn'],
];

$buttons = [
	['title' => 'Gestisci', 'color' => 'blue', 'url' => 'edit?id={{' . Cart::INDEX . '}}'],
	// ['title' => 'Rinvia l\'email', 'color' => 'green', 'name' => 'resend-status-email'],
];

//expand results
function _expand_results(&$entry, $field, $key, $row) {
	$cart = new Cart($row[Cart::INDEX]);

	switch ($field['name']) {
		case Cart::INDEX:
			$entry['value'] = $cart->idCode;
			break;
		case 'data':
			$entry['value'] = [];

			if ($cart->shippingMethodId) {
				$entry['value'][] = $cart->shippingMethod->name;
			}

			if ($cart->paymentMethodId) {
				$entry['value'][] = $cart->paymentMethod->name;
			}

			if ($cart->couponId) {
				$entry['value'][] = 'Codice sconto: ' . $cart->coupon->code;
			}

			$entry['value'] = implode('<br>', $entry['value']);
			break;
		case 'address':
			// address
			$entry['value'] = $cart->address->fullAddress;
			break;
		case 'contacts':
			// contacts
			$entry['value'] = $cart->address->contactsString;
			break;
		case 'orders':
			// orders
			if ($cart->quantity) {
				$entry['value'] = [];

				foreach ($cart->orders as $order) {
					$entry['value'][] = $order->name;
				}

				$entry['value'] = implode(',', $entry['value']);
			} else {
				$entry['value'] = '- Nessun articolo registrato -';
			}
			break;
		case 'price':
			// price
			$entry['value'] = $cart->priceString;
			break;
		case 'status':
			// status
			$entry['value'] = '<span class="order-status background-status-color--' . $cart->statusCode . '">' . $cart->statusName . '</span>';
			break;
	}
}

// resend status email
if (isset($_POST['resend-status-email'])) {
	(new Cart($_POST['ID']))->sendStatusEmail();
}
