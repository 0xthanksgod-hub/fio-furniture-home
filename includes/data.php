<?php
declare(strict_types=1);

const SITE_NAME = 'Fio Home Furniture';
const SITE_DESCRIPTION = 'Thoughtfully designed furniture that brings warmth, character, and quiet beauty into the rhythm of everyday life.';

/** Gambar (Unsplash). Ganti dengan file lokal di assets/img/ jika diperlukan. */
const PHOTOS = [
    'hero'    => 'https://images.unsplash.com/photo-1776186243326-1d467b258232?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixlib=rb-4.1.0&q=88&w=1800',
    'room'    => 'https://images.unsplash.com/photo-1750639258774-9a714379a093?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixlib=rb-4.1.0&q=85&w=1400',
    'dining'  => 'https://images.unsplash.com/photo-1770646403987-64cf5c08c870?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixlib=rb-4.1.0&q=85&w=1200',
    'chair'   => 'https://images.unsplash.com/photo-1567538096630-e0c55bd6374c?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixlib=rb-4.1.0&q=85&w=1000',
    'studio'  => 'https://images.unsplash.com/photo-1712668401428-df42b8bd93fc?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixlib=rb-4.1.0&q=85&w=1200',
    'bench'   => 'https://images.unsplash.com/photo-1765282745950-99c5abe761f8?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixlib=rb-4.1.0&q=85&w=1000',
    'wicker'  => 'https://images.unsplash.com/photo-1648993880083-3080b2110bc0?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixlib=rb-4.1.0&q=85&w=1000',
    'table'   => 'https://images.unsplash.com/photo-1648994517762-15aae4c01ce7?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixlib=rb-4.1.0&q=85&w=1000',
    'minimal' => 'https://images.unsplash.com/photo-1764349109503-af3c316f85c2?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixlib=rb-4.1.0&q=85&w=1000',
    'bright'  => 'https://images.unsplash.com/photo-1719760518176-e124a5bcd025?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixlib=rb-4.1.0&q=85&w=1200',
];

const CATEGORIES = ['Sofa', 'Chair', 'Table', 'Bed', 'Storage', 'Lighting'];

/** Katalog produk. Ganti dengan query database bila sudah ada. */
const PRODUCTS = [
    ['id' => 1, 'name' => 'Onda Lounge Chair',   'category' => 'Chair',    'price' => 890,  'rating' => '4.9', 'image' => PHOTOS['chair'],   'color' => 'Natural Bouclé'],
    ['id' => 2, 'name' => 'Forma Modular Sofa',  'category' => 'Sofa',     'price' => 2480, 'rating' => '4.8', 'image' => PHOTOS['room'],    'color' => 'Warm Ivory'],
    ['id' => 3, 'name' => 'Luna Side Table',     'category' => 'Table',    'price' => 420,  'rating' => '4.9', 'image' => PHOTOS['table'],   'color' => 'Travertine'],
    ['id' => 4, 'name' => 'Arco Reading Chair',  'category' => 'Chair',    'price' => 740,  'rating' => '4.7', 'image' => PHOTOS['wicker'],  'color' => 'Natural Weave'],
    ['id' => 5, 'name' => 'Tavola Dining Table', 'category' => 'Table',    'price' => 1680, 'rating' => '4.8', 'image' => PHOTOS['dining'],  'color' => 'Smoked Oak'],
    ['id' => 6, 'name' => 'Linea Daybed',        'category' => 'Bed',      'price' => 1320, 'rating' => '4.9', 'image' => PHOTOS['bench'],   'color' => 'Oat Linen'],
    ['id' => 7, 'name' => 'Quiet Floor Lamp',    'category' => 'Lighting', 'price' => 390,  'rating' => '4.6', 'image' => PHOTOS['studio'],  'color' => 'Brushed Brass'],
    ['id' => 8, 'name' => 'Sera Console',        'category' => 'Storage',  'price' => 980,  'rating' => '4.8', 'image' => PHOTOS['minimal'], 'color' => 'Ash Wood'],
];

const TESTIMONIALS = [
    ['Fio completely changed the feeling of our home. Every piece is quietly beautiful, incredibly comfortable, and feels like it has always belonged here.', 'Maya Chen', 'Interior stylist'],
    ['The quality is immediately apparent. From the fabric to the joinery, our sofa has the considered detail of something we will keep for decades.', 'Amelia Ross', 'Fio customer'],
    ['Their design team helped us find exactly the right proportions. The result feels personal, warm, and wonderfully unforced.', 'James Bennett', 'Architect'],
];

function find_product(int $id): ?array
{
    foreach (PRODUCTS as $p) {
        if ($p['id'] === $id) {
            return $p;
        }
    }
    return null;
}
