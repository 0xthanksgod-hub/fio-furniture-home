<?php
declare(strict_types=1);
require __DIR__ . '/includes/helpers.php';

$page      = 'shop';
$pageTitle = 'Shop — ' . SITE_NAME;

$category = (string) ($_GET['category'] ?? 'All');
if ($category !== 'All' && !in_array($category, CATEGORIES, true)) {
    $category = 'All';
}
$q = trim((string) ($_GET['q'] ?? ''));
$q = mb_substr($q, 0, 80);

$visible = array_values(array_filter(PRODUCTS, static function (array $p) use ($category, $q): bool {
    if ($category !== 'All' && $p['category'] !== $category) {
        return false;
    }
    if ($q !== '') {
        $haystack = $p['name'] . ' ' . $p['category'] . ' ' . $p['color'];
        return mb_stripos($haystack, $q) !== false;
    }
    return true;
}));

$filterUrl = static function (string $cat) use ($q): string {
    $params = [];
    if ($cat !== 'All') {
        $params['category'] = $cat;
    }
    if ($q !== '') {
        $params['q'] = $q;
    }
    return 'shop.php' . ($params ? '?' . http_build_query($params) : '');
};

$n = count($visible);

require __DIR__ . '/includes/header.php';
?>

<main class="inner-page">
  <div class="shop-hero reveal">
    <p class="eyebrow">The Fio collection</p>
    <h1>Objects for <em>everyday living.</em></h1>
    <p>Timeless furniture, considered in every detail and made to live beautifully with you.</p>
  </div>

  <div class="shop-toolbar">
    <div class="filters">
      <?php foreach (array_merge(['All'], CATEGORIES) as $item): ?>
        <a href="<?= e($filterUrl($item)) ?>"<?= $category === $item ? ' class="active" aria-current="true"' : '' ?>><?= e($item) ?></a>
      <?php endforeach; ?>
    </div>
    <div class="result-count"><?= icon('grid', 16) ?> <?= $n ?> <?= $n === 1 ? 'piece' : 'pieces' ?><?= $q !== '' ? ' for “' . e($q) . '”' : '' ?></div>
  </div>

  <?php if ($n > 0): ?>
    <div class="shop-grid">
      <?php foreach ($visible as $p) { product_card($p); } ?>
    </div>
  <?php else: ?>
    <div class="empty-state">
      <p>No pieces match your search.</p>
      <a class="text-link" href="shop.php">Clear filters <?= icon('arrow', 17) ?></a>
    </div>
  <?php endif; ?>

  <div class="shop-editorial">
    <img src="<?= e(PHOTOS['bright']) ?>" alt="Serene modern interior" loading="lazy">
    <div>
      <p class="eyebrow">Complimentary styling</p>
      <h2>Need a little help finding the right piece?</h2>
      <p>Our design team is here to help you shape a home that feels entirely your own.</p>
      <a class="button button--light" href="#footer">Book a consultation <?= icon('arrow', 17) ?></a>
    </div>
  </div>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
