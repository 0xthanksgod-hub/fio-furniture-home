<?php
/**
 * Variabel yang diharapkan: $page ('home' | 'shop' | 'product'), $pageTitle (opsional).
 */
$page      = $page ?? 'home';
$pageTitle = $pageTitle ?? SITE_NAME;
$isHome    = $page === 'home';
$count     = cart_count();

$navItems = [
    ['Home',        'index.php',            $page === 'home'],
    ['Shop',        'shop.php',             $page === 'shop'],
    ['Collections', 'index.php#categories', false],
    ['About',       'index.php#collection', false],
    ['Contact',     '#footer',              false],
];
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= e($pageTitle) ?></title>
  <meta name="description" content="<?= e(SITE_DESCRIPTION) ?>">
  <link rel="icon" type="image/svg+xml" href="assets/favicon.svg">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=Playfair+Display:ital,wght@0,500;1,400;1,500&display=swap">
  <link rel="stylesheet" href="assets/css/style.css">
  <noscript><style>.reveal{opacity:1;transform:none}</style></noscript>
</head>
<body data-page="<?= e($page) ?>">

<header class="navbar<?= $isHome ? ' navbar--hero' : '' ?>" id="navbar">
  <?= logo($isHome) ?>
  <nav class="nav-links" id="nav-links" aria-label="Main">
    <?php foreach ($navItems as [$label, $href, $active]): ?>
      <a href="<?= e($href) ?>"<?= $active ? ' class="active" aria-current="page"' : '' ?>><?= e($label) ?></a>
    <?php endforeach; ?>
  </nav>
  <div class="nav-actions">
    <button type="button" id="search-toggle" aria-label="Search" aria-expanded="false" aria-controls="search-panel"><?= icon('search') ?></button>
    <button type="button" class="bag-button" aria-label="Cart with <?= $count ?> items"><?= icon('bag') ?><?php if ($count > 0): ?><span><?= $count ?></span><?php endif; ?></button>
    <button type="button" class="menu-toggle" id="menu-toggle" aria-label="Toggle menu" aria-expanded="false"><i></i><i></i></button>
  </div>
</header>

<form class="search-panel" id="search-panel" method="get" action="shop.php" role="search">
  <?= icon('search', 22) ?>
  <input type="search" name="q" placeholder="Search furniture, rooms, collections..." aria-label="Search" value="<?= e($_GET['q'] ?? '') ?>">
  <button type="button" id="search-close">Close</button>
</form>
