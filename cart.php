<?php
declare(strict_types=1);
require __DIR__ . '/includes/helpers.php';

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    redirect('shop.php');
}

$return = safe_return($_POST['return'] ?? null, 'shop.php');

if (!csrf_valid($_POST['csrf'] ?? null)) {
    redirect($return);
}

$id      = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);
$qty     = filter_var($_POST['qty'] ?? 1, FILTER_VALIDATE_INT);
$product = $id !== false && $id !== null ? find_product($id) : null;

if ($product !== null) {
    cart_add($product['id'], $qty === false ? 1 : $qty);
    if (!empty($_POST['flash'])) {
        flash_set('added', (string) $product['id']);
    }
}

redirect($return);
