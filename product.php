<?php
declare(strict_types=1);
require __DIR__ . '/includes/helpers.php';

$page    = 'product';
$id      = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) ?: 0;
$product = find_product($id);

if ($product === null) {
    http_response_code(404);
    $pageTitle = 'Not found — ' . SITE_NAME;
    require __DIR__ . '/includes/header.php';
    ?>
    <main class="inner-page product-page">
      <a class="back-link" href="shop.php">← Back to shop</a>
      <div class="shop-hero"><p class="eyebrow">404</p><h1>Piece <em>not found.</em></h1><p>We couldn’t find that piece. It may have moved on from the collection.</p></div>
    </main>
    <?php
    require __DIR__ . '/includes/footer.php';
    exit;
}

$pageTitle = $product['name'] . ' — ' . SITE_NAME;
$added     = flash_get('added') === (string) $product['id'];
$related   = array_slice(array_values(array_filter(PRODUCTS, static fn (array $p): bool => $p['id'] !== $product['id'])), 0, 3);
$thumbs    = [$product['image'], PHOTOS['studio'], PHOTOS['bright']];

require __DIR__ . '/includes/header.php';
?>

<main class="inner-page product-page">
  <a class="back-link" href="shop.php">← Back to shop</a>

  <div class="product-detail">
    <div class="product-gallery">
      <div class="detail-main"><img id="detail-main-img" src="<?= e($product['image']) ?>" alt="<?= e($product['name']) ?>"></div>
      <div class="detail-thumbs">
        <?php foreach ($thumbs as $i => $src): ?>
          <button type="button" class="<?= $i === 0 ? 'active' : '' ?>" data-src="<?= e($src) ?>" aria-label="View image <?= $i + 1 ?>"><img src="<?= e($src) ?>" alt=""></button>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="product-info">
      <p class="eyebrow"><?= e($product['category']) ?> · New collection</p>
      <h1><?= e($product['name']) ?></h1>
      <div class="detail-price"><strong><?= e(money($product['price'])) ?></strong><span>★★★★★ &nbsp; <?= e($product['rating']) ?> (42 reviews)</span></div>
      <p class="detail-description">A study in gentle curves and lasting comfort. Designed with generous proportions and crafted from honest materials, this is a piece made to become part of your everyday.</p>

      <div class="option">
        <label>Upholstery <span><?= e($product['color']) ?></span></label>
        <div class="swatches">
          <button type="button" class="active swatch-cream" aria-label="Cream"></button>
          <button type="button" class="swatch-sage" aria-label="Sage"></button>
          <button type="button" class="swatch-rust" aria-label="Rust"></button>
          <button type="button" class="swatch-charcoal" aria-label="Charcoal"></button>
        </div>
      </div>

      <form method="post" action="cart.php" id="add-form" data-price="<?= (int) $product['price'] ?>" data-added="<?= $added ? '1' : '0' ?>">
        <?= csrf_field() ?>
        <input type="hidden" name="id" value="<?= (int) $product['id'] ?>">
        <input type="hidden" name="qty" id="qty-input" value="1">
        <input type="hidden" name="flash" value="1">
        <input type="hidden" name="return" value="<?= e(current_uri()) ?>">

        <div class="option">
          <label>Quantity</label>
          <div class="quantity">
            <button type="button" id="qty-minus" aria-label="Decrease quantity"><?= icon('minus', 14) ?></button>
            <span id="qty-value" aria-live="polite">1</span>
            <button type="button" id="qty-plus" aria-label="Increase quantity"><?= icon('plus', 14) ?></button>
          </div>
        </div>

        <button type="submit" class="detail-add<?= $added ? ' added' : '' ?>" id="detail-add">
          <span class="lbl-default">Add to cart · <span id="detail-total"><?= e(money($product['price'])) ?></span></span>
          <span class="lbl-added">Added to your cart</span>
          <span class="ico-default"><?= icon('arrow', 18) ?></span>
          <span class="ico-added"><?= icon('bag', 18) ?></span>
        </button>
      </form>

      <div class="detail-benefits"><span><?= icon('truck') ?> Free delivery</span><span><?= icon('return') ?> 30-day returns</span><span><?= icon('leaf') ?> Responsibly made</span></div>
      <div class="accordions">
        <?php foreach (['Details & dimensions', 'Materials & care', 'Delivery & returns'] as $item): ?>
          <button type="button"><?= e($item) ?><?= icon('plus', 16) ?></button>
        <?php endforeach; ?>
      </div>
    </div>
  </div>

  <section class="detail-story">
    <div>
      <p class="eyebrow">Made with intention</p>
      <h2>Comfort you can see. Craft you can feel.</h2>
      <p>Each piece passes through the hands of skilled makers who understand that the smallest details create the most lasting impressions.</p>
    </div>
    <img src="<?= e(PHOTOS['studio']) ?>" alt="Furniture crafted in a serene studio" loading="lazy">
  </section>

  <section class="related">
    <?php section_heading('You may also love', 'Complete the room'); ?>
    <div class="product-grid">
      <?php foreach ($related as $p) { product_card($p); } ?>
    </div>
  </section>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
