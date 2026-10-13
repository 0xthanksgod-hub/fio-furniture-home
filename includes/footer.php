<?php
$page = $page ?? 'home';

if ($page !== 'product'):
    $nlStatus = flash_get('newsletter');
?>
<section class="newsletter" id="newsletter">
  <div><p class="eyebrow">Notes from home</p><h2>A little inspiration, delivered slowly.</h2></div>
  <?php if ($nlStatus === 'ok'): ?>
    <p class="newsletter-success" role="status">Welcome home. You’re on the list.</p>
  <?php else: ?>
    <div class="newsletter-form-wrap">
      <form method="post" action="newsletter.php">
        <?= csrf_field() ?>
        <input type="hidden" name="return" value="<?= e(current_uri()) ?>">
        <input required type="email" name="email" placeholder="Enter your email address" aria-label="Email address" maxlength="254">
        <button type="submit">Join our world <?= icon('arrow', 17) ?></button>
      </form>
      <?php if ($nlStatus === 'error'): ?><p class="form-error" role="alert">Please enter a valid email address.</p><?php endif; ?>
    </div>
  <?php endif; ?>
</section>
<?php endif; ?>

<footer id="footer">
  <div class="footer-main">
    <div class="footer-brand">
      <?= logo(true) ?>
      <p>Furniture that makes home feel like you. Designed slowly, made thoughtfully.</p>
      <div class="socials">
        <a href="#" aria-label="Instagram"><?= icon('instagram', 17) ?></a>
        <a href="#" aria-label="Facebook"><?= icon('facebook', 17) ?></a>
        <a href="#" aria-label="Pinterest"><?= icon('pinterest', 17) ?></a>
      </div>
    </div>
    <div class="footer-links">
      <div><strong>Explore</strong><a href="shop.php">New arrivals</a><a href="shop.php">Furniture</a><a href="index.php#categories">Collections</a><a href="#">Journal</a></div>
      <div><strong>About</strong><a href="#">Our story</a><a href="#">Materials</a><a href="#">Craftsmanship</a><a href="#">Design service</a></div>
      <div><strong>Help</strong><a href="#">Delivery</a><a href="#">Returns</a><a href="#">Care guide</a><a href="#footer">Contact</a></div>
    </div>
  </div>
  <div class="footer-bottom">
    <span>© <?= date('Y') ?> Fio Home Furniture</span>
    <div class="payments"><i>VISA</i><i>MC</i><i>AMEX</i></div>
    <div><a href="#">Privacy</a><a href="#">Terms</a></div>
  </div>
</footer>

<?php if ($page === 'home'): ?>
<script>window.FIO_TESTIMONIALS = <?= json_encode(TESTIMONIALS, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;</script>
<?php endif; ?>
<script src="assets/js/app.js" defer></script>
</body>
</html>
