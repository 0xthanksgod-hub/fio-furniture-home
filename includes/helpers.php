<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'httponly' => true,
        'samesite' => 'Lax',
        'secure'   => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
    ]);
    session_start();
}

require_once __DIR__ . '/data.php';

/** Escape untuk output HTML. */
function e(string|int|float $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function money(int|float $amount): string
{
    return '$' . number_format($amount, 0, '.', ',');
}

/* ---------- CSRF ---------- */

function csrf_token(): string
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf" value="' . e(csrf_token()) . '">';
}

function csrf_valid(?string $token): bool
{
    return is_string($token) && isset($_SESSION['csrf']) && hash_equals($_SESSION['csrf'], $token);
}

/* ---------- Redirect & flash ---------- */

/** Hanya izinkan path relatif same-origin ("/foo?bar"), selain itu pakai fallback. */
function safe_return(?string $url, string $fallback = 'index.php'): string
{
    if ($url !== null && preg_match('~^/(?![/\\\\])[^\r\n\\\\]*$~', $url)) {
        return $url;
    }
    return $fallback;
}

function current_uri(): string
{
    return safe_return($_SERVER['REQUEST_URI'] ?? '', 'index.php');
}

function redirect(string $to): never
{
    header('Location: ' . $to, true, 303);
    exit;
}

function flash_set(string $key, string $value): void
{
    $_SESSION['flash'][$key] = $value;
}

/** Ambil lalu hapus flash message. */
function flash_get(string $key): ?string
{
    $value = $_SESSION['flash'][$key] ?? null;
    unset($_SESSION['flash'][$key]);
    return $value;
}

/* ---------- Keranjang (session) ---------- */

function cart_count(): int
{
    return array_sum($_SESSION['cart'] ?? []);
}

function cart_add(int $productId, int $qty): void
{
    $qty = max(1, min(99, $qty));
    $current = $_SESSION['cart'][$productId] ?? 0;
    $_SESSION['cart'][$productId] = min(99, $current + $qty);
}

/* ---------- Komponen tampilan ---------- */

function icon(string $name, int $size = 20): string
{
    static $paths = [
        'search'    => '<circle cx="11" cy="11" r="7" /><path d="m20 20-4-4" />',
        'bag'       => '<path d="M5 8h14l-1 13H6L5 8Z" /><path d="M9 9V6a3 3 0 0 1 6 0v3" />',
        'heart'     => '<path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.7l-1.1-1.1a5.5 5.5 0 0 0-7.8 7.8l1.1 1.1L12 21l7.8-7.5 1.1-1.1a5.5 5.5 0 0 0-.1-7.8Z" />',
        'arrow'     => '<path d="M5 12h14" /><path d="m14 7 5 5-5 5" />',
        'chevron'   => '<path d="m9 18 6-6-6-6" />',
        'truck'     => '<path d="M3 6h11v11H3z" /><path d="M14 10h4l3 3v4h-7z" /><circle cx="7" cy="19" r="2" /><circle cx="18" cy="19" r="2" />',
        'return'    => '<path d="M3 12a9 9 0 1 0 3-6.7" /><path d="M3 3v6h6" />',
        'leaf'      => '<path d="M20 4C12 4 5 8 5 15c0 3 2 5 5 5 7 0 10-8 10-16Z" /><path d="M4 21c3-6 7-9 12-12" />',
        'pencil'    => '<path d="m4 16-1 5 5-1L20 8l-4-4L4 16Z" /><path d="m14 6 4 4" />',
        'plus'      => '<path d="M12 5v14" /><path d="M5 12h14" />',
        'minus'     => '<path d="M5 12h14" />',
        'grid'      => '<rect x="3" y="3" width="7" height="7" /><rect x="14" y="3" width="7" height="7" /><rect x="3" y="14" width="7" height="7" /><rect x="14" y="14" width="7" height="7" />',
        'instagram' => '<rect x="3" y="3" width="18" height="18" rx="5" /><circle cx="12" cy="12" r="4" /><circle cx="17.5" cy="6.5" r=".5" fill="currentColor" />',
        'facebook'  => '<path d="M14 8h4V3h-4c-4 0-6 2-6 6v3H4v5h4v7h5v-7h4l1-5h-5V9c0-1 .4-1 1-1Z" />',
        'pinterest' => '<path d="M12 2a10 10 0 0 0-3.6 19.3c-.1-1.7 0-3.6.4-5.1l1.3-5.4s-.3-.7-.3-1.8c0-1.7 1-3 2.2-3 1 0 1.5.8 1.5 1.7 0 1-.7 2.6-1 4-.3 1.2.6 2.2 1.8 2.2 2.2 0 3.8-2.3 3.8-5.6 0-2.9-2.1-5-5.1-5-3.5 0-5.5 2.6-5.5 5.3 0 1 .4 2.1.9 2.7.1.1.1.2.1.4l-.3 1.2c-.1.4-.4.5-.8.3-1.9-.9-3-3.5-3-5.6 0-4.6 3.3-8.8 9.6-8.8 5 0 9 3.6 9 8.4 0 5-3.1 9-7.5 9-1.5 0-2.8-.8-3.3-1.7l-.9 3.4c-.3 1.2-1.2 2.8-1.8 3.7.8.2 1.7.3 2.5.3A10 10 0 0 0 12 2Z" />',
    ];
    $inner = $paths[$name] ?? '';
    return '<svg aria-hidden="true" width="' . $size . '" height="' . $size . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">' . $inner . '</svg>';
}

function logo(bool $light = false, string $extraClass = ''): string
{
    $class = trim('logo ' . ($light ? 'logo--light ' : '') . $extraClass);
    return '<a class="' . e($class) . '" href="index.php" aria-label="Fio home"><span>Fio</span><small>Home Furniture</small></a>';
}

function section_heading(string $eyebrow, string $title, ?string $action = null, string $href = '#'): void
{
    ?>
    <div class="section-heading reveal">
      <div><p class="eyebrow"><?= e($eyebrow) ?></p><h2><?= e($title) ?></h2></div>
      <?php if ($action): ?>
        <a class="text-link" href="<?= e($href) ?>"><?= e($action) ?><?= icon('arrow', 17) ?></a>
      <?php endif; ?>
    </div>
    <?php
}

function product_card(array $p): void
{
    $url = 'product.php?id=' . (int) $p['id'];
    ?>
    <article class="product-card">
      <div class="product-image">
        <a class="product-link" href="<?= e($url) ?>"><img src="<?= e($p['image']) ?>" alt="<?= e($p['name']) ?>" loading="lazy"></a>
        <span class="product-badge">New</span>
        <button type="button" class="heart" aria-label="Add to wishlist" aria-pressed="false"><?= icon('heart', 18) ?></button>
        <form class="cart-form" method="post" action="cart.php">
          <?= csrf_field() ?>
          <input type="hidden" name="id" value="<?= (int) $p['id'] ?>">
          <input type="hidden" name="qty" value="1">
          <input type="hidden" name="return" value="<?= e(current_uri()) ?>">
          <button class="add-cart" type="submit">Add to cart <?= icon('plus', 16) ?></button>
        </form>
      </div>
      <a class="product-meta" href="<?= e($url) ?>">
        <div><p><?= e($p['category']) ?></p><h3><?= e($p['name']) ?></h3></div>
        <div class="product-price"><span>★ <?= e($p['rating']) ?></span><strong><?= e(money($p['price'])) ?></strong></div>
      </a>
    </article>
    <?php
}
