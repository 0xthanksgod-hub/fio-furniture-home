<?php
declare(strict_types=1);
require __DIR__ . '/includes/helpers.php';

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    redirect('index.php');
}

$return = safe_return($_POST['return'] ?? null, 'index.php');
$return = preg_replace('~#.*$~', '', $return) . '#newsletter';

if (!csrf_valid($_POST['csrf'] ?? null)) {
    flash_set('newsletter', 'error');
    redirect($return);
}

$email = trim((string) ($_POST['email'] ?? ''));

if ($email === '' || strlen($email) > 254 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    flash_set('newsletter', 'error');
    redirect($return);
}

$dir  = __DIR__ . '/storage';
$file = $dir . '/subscribers.csv';
if (!is_dir($dir)) {
    mkdir($dir, 0750, true);
}

// Cegah CSV/formula injection bila file dibuka di spreadsheet.
$safeEmail = preg_match('/^[=+\-@]/', $email) ? "'" . $email : $email;

$handle = fopen($file, 'ab');
if ($handle !== false && flock($handle, LOCK_EX)) {
    fputcsv($handle, [date('c'), $safeEmail], ',', '"', '');
    fflush($handle);
    flock($handle, LOCK_UN);
}
if ($handle !== false) {
    fclose($handle);
}

flash_set('newsletter', 'ok');
redirect($return);
