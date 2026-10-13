(function () {
  'use strict';

  var $ = function (sel, root) { return (root || document).querySelector(sel); };
  var $$ = function (sel, root) { return Array.prototype.slice.call((root || document).querySelectorAll(sel)); };

  /* ---------- Navbar: scroll state, mobile menu, search ---------- */
  var navbar = $('#navbar');
  var isHome = document.body.dataset.page === 'home';
  var headerLogo = navbar ? $('.logo', navbar) : null;

  function onScroll() {
    if (!navbar) return;
    var scrolled = window.scrollY > 60;
    navbar.classList.toggle('navbar--scrolled', scrolled);
    var heroTop = isHome && !scrolled;
    navbar.classList.toggle('navbar--hero', heroTop);
    if (headerLogo) headerLogo.classList.toggle('logo--light', heroTop);
  }
  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();

  var menuToggle = $('#menu-toggle');
  var navLinks = $('#nav-links');
  function setMenu(open) {
    if (!menuToggle || !navLinks) return;
    navLinks.classList.toggle('nav-links--open', open);
    menuToggle.classList.toggle('is-open', open);
    menuToggle.setAttribute('aria-expanded', String(open));
  }
  if (menuToggle) {
    menuToggle.addEventListener('click', function () {
      setMenu(!navLinks.classList.contains('nav-links--open'));
    });
    $$('a', navLinks).forEach(function (a) {
      a.addEventListener('click', function () { setMenu(false); });
    });
  }

  var searchPanel = $('#search-panel');
  var searchToggle = $('#search-toggle');
  function setSearch(open) {
    if (!searchPanel) return;
    searchPanel.classList.toggle('search-panel--open', open);
    if (searchToggle) searchToggle.setAttribute('aria-expanded', String(open));
    if (open) { var input = $('input', searchPanel); if (input) input.focus(); }
  }
  if (searchToggle) searchToggle.addEventListener('click', function () {
    setSearch(!searchPanel.classList.contains('search-panel--open'));
  });
  var searchClose = $('#search-close');
  if (searchClose) searchClose.addEventListener('click', function () { setSearch(false); });
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') { setSearch(false); setMenu(false); }
  });

  /* ---------- Reveal on scroll ---------- */
  var reveals = $$('.reveal');
  if ('IntersectionObserver' in window) {
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) { entry.target.classList.add('revealed'); io.unobserve(entry.target); }
      });
    }, { threshold: 0.08 });
    reveals.forEach(function (el) { io.observe(el); });
  } else {
    reveals.forEach(function (el) { el.classList.add('revealed'); });
  }

  /* ---------- Wishlist hearts ---------- */
  $$('.heart').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var on = btn.classList.toggle('heart--active');
      btn.setAttribute('aria-pressed', String(on));
    });
  });

  /* ---------- Testimonial slider ---------- */
  var data = window.FIO_TESTIMONIALS;
  if (data && data.length) {
    var idx = 0;
    var quote = $('#t-quote'), name = $('#t-name'), role = $('#t-role'), count = $('#t-count');
    var show = function (i) {
      idx = (i + data.length) % data.length;
      quote.textContent = '“' + data[idx][0] + '”';
      name.textContent = data[idx][1];
      role.textContent = data[idx][2];
      count.textContent = (idx + 1) + ' / ' + data.length;
    };
    $('#t-prev').addEventListener('click', function () { show(idx - 1); });
    $('#t-next').addEventListener('click', function () { show(idx + 1); });
  }

  /* ---------- Halaman produk ---------- */
  var form = $('#add-form');
  if (form) {
    var price = parseInt(form.dataset.price, 10) || 0;
    var qty = 1;
    var qtyInput = $('#qty-input'), qtyValue = $('#qty-value'), total = $('#detail-total');
    var addBtn = $('#detail-add');
    var fmt = function (n) { return '$' + n.toLocaleString('en-US'); };
    var setQty = function (n) {
      qty = Math.max(1, Math.min(99, n));
      qtyInput.value = qty;
      qtyValue.textContent = qty;
      total.textContent = fmt(price * qty);
    };
    $('#qty-minus').addEventListener('click', function () { setQty(qty - 1); });
    $('#qty-plus').addEventListener('click', function () { setQty(qty + 1); });

    // Status "Added to your cart" muncul sebentar setelah redirect dari cart.php
    if (form.dataset.added === '1') {
      setTimeout(function () { addBtn.classList.remove('added'); }, 1800);
    }

    // Ganti gambar utama lewat thumbnail
    var mainImg = $('#detail-main-img');
    $$('.detail-thumbs button').forEach(function (b) {
      b.addEventListener('click', function () {
        $$('.detail-thumbs button').forEach(function (x) { x.classList.remove('active'); });
        b.classList.add('active');
        mainImg.src = b.dataset.src;
      });
    });

    // Swatch
    $$('.swatches button').forEach(function (b) {
      b.addEventListener('click', function () {
        $$('.swatches button').forEach(function (x) { x.classList.remove('active'); });
        b.classList.add('active');
      });
    });
  }
})();
