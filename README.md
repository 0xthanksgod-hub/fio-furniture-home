# Fio Home Furniture — versi PHP

Konversi dari proyek React/Vite (Figma Make) ke PHP murni. Tanpa Composer, tanpa build step.

**Kebutuhan:** PHP 8.0+. Jalankan lokal:

    php -S localhost:8000

lalu buka http://localhost:8000. Di hosting (Apache/cPanel) cukup upload semua isi folder ke `public_html`.

## Struktur
| File | Fungsi |
|---|---|
| `index.php` | Beranda |
| `shop.php` | Katalog, filter `?category=Chair`, pencarian `?q=oak` |
| `product.php` | Detail produk `?id=1` (404 jika tidak ada) |
| `cart.php` | POST tambah ke keranjang (session) |
| `newsletter.php` | POST simpan email ke `storage/subscribers.csv` |
| `includes/data.php` | Data produk, kategori, testimoni, URL gambar |
| `includes/helpers.php` | Session, CSRF, ikon, komponen kartu produk |
| `includes/header.php`, `footer.php` | Layout bersama |
| `assets/css/style.css`, `assets/js/app.js` | Gaya dan interaksi |

## Catatan
- Edit produk di `includes/data.php` (atau ganti `PRODUCTS` dengan query database).
- Gambar masih hotlink ke Unsplash; simpan lokal di `assets/img/` bila perlu.
- `storage/` dan `includes/` diblokir lewat `.htaccess` (Apache). Di Nginx, blokir manual kedua folder itu.
- Keranjang baru berupa penghitung (sama seperti aslinya); belum ada halaman checkout.
