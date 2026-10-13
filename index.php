<?php
declare(strict_types=1);
require __DIR__ . '/includes/helpers.php';

$page      = 'home';
$pageTitle = SITE_NAME;

$categoryImages = [
    'Sofa' => PHOTOS['room'], 'Chair' => PHOTOS['chair'], 'Table' => PHOTOS['dining'],
    'Bed' => PHOTOS['bench'], 'Storage' => PHOTOS['minimal'], 'Lighting' => PHOTOS['studio'],
];
$features = [
    ['leaf',   'Quality materials', 'Natural, durable materials selected for beauty and longevity.'],
    ['truck',  'Free shipping',     'Complimentary delivery on every order over $500.'],
    ['return', 'Easy returns',      'A simple 30-day return process, made entirely stress-free.'],
    ['pencil', 'Custom design',     'Personalized finishes and guidance for a piece truly your own.'],
];
$gallery = [
    [PHOTOS['room'],   'Soft neutral living room',    'Quiet Living'],
    [PHOTOS['studio'], 'Minimal reading corner',      'The Art of Pause'],
    [PHOTOS['hero'],   'Curved sofa interior',        'Soft Geometry'],
    [PHOTOS['dining'], 'Warm dining room',            'Gathered Warmth'],
    [PHOTOS['bright'], 'Bright contemporary lounge',  'Light & Space'],
];
$first = TESTIMONIALS[0];

require __DIR__ . '/includes/header.php';
?>

<section class="hero">
  <div class="hero-copy reveal">
    <p class="eyebrow">The considered collection · <?= date('Y') ?></p>
    <h1>Furniture That Makes Home <em>Feel Like You</em></h1>
    <p class="hero-description">Thoughtfully designed furniture that brings warmth, character, and quiet beauty into the rhythm of everyday life.</p>
    <div class="hero-buttons">
      <a class="button button--dark" href="shop.php">Shop now <?= icon('arrow', 17) ?></a>
      <a class="button button--outline" href="#categories">View collection <?= icon('arrow', 17) ?></a>
    </div>
    <div class="hero-note"><span>Made thoughtfully</span><span>Designed to last</span><span>Delivered with care</span></div>
  </div>
  <div class="hero-visual">
    <img class="parallax-image" src="<?= e(PHOTOS['hero']) ?>" alt="Warm modern living room with sculptural furniture" fetchpriority="high">
    <div class="floating-product floating-product--one"><img src="<?= e(PHOTOS['chair']) ?>" alt=""><div><small>Most loved</small><strong>Onda Chair</strong><span>$890</span></div></div>
    <div class="floating-product floating-product--two"><span class="material-dot"></span><div><small>Natural texture</small><strong>Italian bouclé</strong></div></div>
    <div class="hero-count"><strong>01</strong><span></span>04</div>
  </div>
</section>

<section id="categories" class="section-shell categories-section">
  <?php section_heading('Shop your way', 'Made for every room', 'Explore all', 'shop.php'); ?>
  <div class="category-row">
    <?php foreach ($categoryImages as $name => $image): ?>
      <a class="category-card reveal" href="shop.php?category=<?= urlencode($name) ?>"><img src="<?= e($image) ?>" alt="<?= e($name) ?> furniture" loading="lazy"><span><?= e($name) ?><i><?= icon('chevron', 14) ?></i></span></a>
    <?php endforeach; ?>
  </div>
</section>

<section class="section-shell products-section">
  <?php section_heading('Objects of lasting value', 'Featured pieces', 'Shop all furniture', 'shop.php'); ?>
  <div class="product-grid">
    <?php foreach (array_slice(PRODUCTS, 0, 4) as $p) { product_card($p); } ?>
  </div>
</section>

<section id="collection" class="collection-highlight">
  <div class="collection-image reveal"><img src="<?= e(PHOTOS['dining']) ?>" alt="Sunlit oak dining table and chairs" loading="lazy"><span>01 — 08</span></div>
  <div class="collection-copy reveal">
    <p class="eyebrow">The gathering collection</p>
    <h2>Made for the moments that <em>bring us together.</em></h2>
    <p>Warm timber, softened edges, and generous proportions shape a collection made for long dinners, slow mornings, and everything shared between.</p>
    <a class="text-link" href="shop.php">Explore collection <?= icon('arrow', 17) ?></a>
  </div>
  <div class="collection-small-image"><img src="<?= e(PHOTOS['table']) ?>" alt="Simple table detail with flowers" loading="lazy"></div>
</section>

<section class="section-shell why-section">
  <?php section_heading('The Fio difference', 'Considered in every detail'); ?>
  <div class="feature-grid">
    <?php foreach ($features as [$ico, $title, $text]): ?>
      <div class="feature-card reveal"><span><?= icon($ico, 23) ?></span><h3><?= e($title) ?></h3><p><?= e($text) ?></p></div>
    <?php endforeach; ?>
  </div>
</section>

<section class="inspiration section-shell">
  <?php section_heading('Spaces to live in', 'Room inspiration', 'View the journal', '#'); ?>
  <div class="masonry">
    <?php foreach ($gallery as $i => [$image, $alt, $label]): ?>
      <div class="gallery-item gallery-item--<?= $i + 1 ?> reveal"><img src="<?= e($image) ?>" alt="<?= e($alt) ?>" loading="lazy"><div><span><?= e($label) ?></span><?= icon('arrow', 18) ?></div></div>
    <?php endforeach; ?>
  </div>
</section>

<section class="testimonial-section" id="testimonials">
  <div class="testimonial-photo"><img src="<?= e(PHOTOS['wicker']) ?>" alt="Warm reading chair interior" loading="lazy"></div>
  <div class="testimonial-content">
    <p class="eyebrow">Homes, beautifully lived</p>
    <div class="stars">★★★★★</div>
    <blockquote id="t-quote">“<?= e($first[0]) ?>”</blockquote>
    <div class="testimonial-footer">
      <div><strong id="t-name"><?= e($first[1]) ?></strong><span id="t-role"><?= e($first[2]) ?></span></div>
      <div class="slider-controls">
        <button type="button" id="t-prev" aria-label="Previous testimonial">←</button>
        <span id="t-count">1 / <?= count(TESTIMONIALS) ?></span>
        <button type="button" id="t-next" aria-label="Next testimonial">→</button>
      </div>
    </div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
