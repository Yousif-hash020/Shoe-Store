<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get admin user for created_by field
        $admin = User::where('is_admin', true)->first();
        $adminId = $admin ? $admin->id : null;

        $products = [
            [
                'name' => 'Nike Air Max 270',
                'slug' => 'nike-air-max-270',
                'description' => 'The Nike Air Max 270 delivers visible Air cushioning under the heel and forefoot for all-day comfort. The engineered mesh upper provides breathability and a flexible fit.',
                'short_description' => 'Premium running shoes with Air Max technology for ultimate comfort.',
                'price' => 150.00,
                'sale_price' => 129.99,
                'cost_price' => 80.00,
                'category' => 'Sneakers',
                'brand' => 'Nike',
                'sku' => 'NK-AM270-001',
                'barcode' => '1234567890123',
                'stock_quantity' => 50,
                'min_stock_level' => 10,
                'weight' => 0.8,
                'dimensions' => '30x20x12 cm',
                'size' => '6,7,8,9,10,11,12',
                'colors' => ['Black', 'White', 'Red'],
                'image_url' => 'https://images.unsplash.com/photo-1549298916-b41d501d3772?w=500',
                'image_gallery' => [
                    'https://images.unsplash.com/photo-1549298916-b41d501d3772?w=500',
                    'https://images.unsplash.com/photo-1600185365483-26d7a4cc7519?w=500'
                ],
                'is_featured' => true,
                'is_active' => true,
                'status' => 'active',
                'tags' => 'running, sports, nike, air max, comfortable',
                'meta_title' => 'Nike Air Max 270 - Premium Running Shoes',
                'meta_description' => 'Shop Nike Air Max 270 running shoes with Air cushioning technology. Available in multiple colors and sizes.',
                'warranty_period' => '1 Year',
                'created_by' => $adminId,
            ],
            [
                'name' => 'Adidas Ultraboost 22',
                'slug' => 'adidas-ultraboost-22',
                'description' => 'The Adidas Ultraboost 22 features responsive BOOST midsole cushioning and a Primeknit upper for a supportive fit. Perfect for running and daily wear.',
                'short_description' => 'Revolutionary running shoes with BOOST technology.',
                'price' => 180.00,
                'sale_price' => null,
                'cost_price' => 110.00,
                'category' => 'Sneakers',
                'brand' => 'Adidas',
                'sku' => 'AD-UB22-002',
                'barcode' => '1234567890124',
                'stock_quantity' => 35,
                'min_stock_level' => 8,
                'weight' => 0.9,
                'dimensions' => '31x21x13 cm',
                'size' => '6,7,8,9,10,11,12',
                'colors' => ['Black', 'White', 'Blue'],
                'image_url' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=500',
                'image_gallery' => [
                    'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=500'
                ],
                'is_featured' => true,
                'is_active' => true,
                'status' => 'active',
                'tags' => 'running, sports, adidas, boost, premium',
                'meta_title' => 'Adidas Ultraboost 22 - High Performance Running Shoes',
                'meta_description' => 'Experience next-level comfort with Adidas Ultraboost 22 featuring BOOST cushioning technology.',
                'warranty_period' => '1 Year',
                'created_by' => $adminId,
            ],
            [
                'name' => 'Converse Chuck Taylor All Star',
                'slug' => 'converse-chuck-taylor-all-star',
                'description' => 'The iconic Converse Chuck Taylor All Star high-top sneakers. A timeless classic with canvas upper and rubber sole.',
                'short_description' => 'Classic high-top sneakers, timeless style.',
                'price' => 65.00,
                'sale_price' => 55.00,
                'cost_price' => 35.00,
                'category' => 'Casual',
                'brand' => 'Converse',
                'sku' => 'CV-CT-003',
                'barcode' => '1234567890125',
                'stock_quantity' => 75,
                'min_stock_level' => 15,
                'weight' => 0.6,
                'dimensions' => '29x19x11 cm',
                'size' => '6,7,8,9,10,11,12',
                'colors' => ['Black', 'White', 'Red', 'Navy'],
                'image_url' => 'https://images.unsplash.com/photo-1552346154-21d32810aba3?w=500',
                'image_gallery' => [
                    'https://images.unsplash.com/photo-1552346154-21d32810aba3?w=500'
                ],
                'is_featured' => false,
                'is_active' => true,
                'status' => 'active',
                'tags' => 'casual, classic, converse, canvas, everyday',
                'meta_title' => 'Converse Chuck Taylor All Star - Classic High-Top Sneakers',
                'meta_description' => 'Shop the iconic Converse Chuck Taylor All Star sneakers. Classic style that never goes out of fashion.',
                'warranty_period' => '6 Months',
                'created_by' => $adminId,
            ],
            [
                'name' => 'Vans Old Skool',
                'slug' => 'vans-old-skool',
                'description' => 'The Vans Old Skool is a classic skate shoe with a low-top lace-up silhouette, durable canvas and suede uppers, and signature waffle outsole.',
                'short_description' => 'Classic skate shoes with iconic side stripe.',
                'price' => 70.00,
                'sale_price' => null,
                'cost_price' => 40.00,
                'category' => 'Skate',
                'brand' => 'Vans',
                'sku' => 'VN-OS-004',
                'barcode' => '1234567890126',
                'stock_quantity' => 60,
                'min_stock_level' => 12,
                'weight' => 0.7,
                'dimensions' => '30x20x10 cm',
                'size' => '6,7,8,9,10,11,12',
                'colors' => ['Black', 'White', 'Checkered'],
                'image_url' => 'https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77?w=500',
                'image_gallery' => [
                    'https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77?w=500'
                ],
                'is_featured' => false,
                'is_active' => true,
                'status' => 'active',
                'tags' => 'skate, vans, classic, streetwear, durable',
                'meta_title' => 'Vans Old Skool - Classic Skate Shoes',
                'meta_description' => 'Shop Vans Old Skool skate shoes. Durable construction with classic style for skating and everyday wear.',
                'warranty_period' => '6 Months',
                'created_by' => $adminId,
            ],
            [
                'name' => 'Jordan Air Jordan 1 Retro High',
                'slug' => 'jordan-air-jordan-1-retro-high',
                'description' => 'The Air Jordan 1 Retro High OG brings back the classic basketball shoe that started it all. Premium leather upper with iconic design.',
                'short_description' => 'Iconic basketball shoes with premium leather construction.',
                'price' => 170.00,
                'sale_price' => null,
                'cost_price' => 100.00,
                'category' => 'Basketball',
                'brand' => 'Jordan',
                'sku' => 'JD-AJ1-005',
                'barcode' => '1234567890127',
                'stock_quantity' => 25,
                'min_stock_level' => 5,
                'weight' => 1.0,
                'dimensions' => '32x22x14 cm',
                'size' => '7,8,9,10,11,12,13',
                'colors' => ['Black', 'Red', 'White'],
                'image_url' => 'https://images.unsplash.com/photo-1556906781-9a412961c28c?w=500',
                'image_gallery' => [
                    'https://images.unsplash.com/photo-1556906781-9a412961c28c?w=500'
                ],
                'is_featured' => true,
                'is_active' => true,
                'status' => 'active',
                'tags' => 'basketball, jordan, retro, premium, iconic',
                'meta_title' => 'Air Jordan 1 Retro High - Premium Basketball Shoes',
                'meta_description' => 'Shop the legendary Air Jordan 1 Retro High basketball shoes. Premium leather construction with timeless design.',
                'warranty_period' => '1 Year',
                'created_by' => $adminId,
            ],
            [
                'name' => 'Puma Suede Classic',
                'slug' => 'puma-suede-classic',
                'description' => 'The Puma Suede Classic is a timeless street style icon with premium suede upper and comfortable fit.',
                'short_description' => 'Timeless street style with premium suede upper.',
                'price' => 80.00,
                'sale_price' => 69.99,
                'cost_price' => 45.00,
                'category' => 'Casual',
                'brand' => 'Puma',
                'sku' => 'PM-SC-006',
                'barcode' => '1234567890128',
                'stock_quantity' => 40,
                'min_stock_level' => 8,
                'weight' => 0.7,
                'dimensions' => '29x19x11 cm',
                'size' => '6,7,8,9,10,11,12',
                'colors' => ['Black', 'Blue', 'Red', 'Green'],
                'image_url' => 'https://images.unsplash.com/photo-1584735175315-9d5df23860e6?w=500',
                'image_gallery' => [
                    'https://images.unsplash.com/photo-1584735175315-9d5df23860e6?w=500'
                ],
                'is_featured' => false,
                'is_active' => true,
                'status' => 'active',
                'tags' => 'casual, puma, suede, classic, street style',
                'meta_title' => 'Puma Suede Classic - Premium Casual Shoes',
                'meta_description' => 'Shop Puma Suede Classic shoes. Premium suede construction with timeless street style.',
                'warranty_period' => '6 Months',
                'created_by' => $adminId,
            ],
            [
                'name' => 'New Balance 990v5',
                'slug' => 'new-balance-990v5',
                'description' => 'The New Balance 990v5 combines premium materials with superior comfort. Made in USA with ENCAP midsole technology.',
                'short_description' => 'Premium running shoes made in USA with ENCAP technology.',
                'price' => 185.00,
                'sale_price' => null,
                'cost_price' => 120.00,
                'category' => 'Sneakers',
                'brand' => 'New Balance',
                'sku' => 'NB-990V5-007',
                'barcode' => '1234567890129',
                'stock_quantity' => 20,
                'min_stock_level' => 5,
                'weight' => 0.9,
                'dimensions' => '31x21x13 cm',
                'size' => '7,8,9,10,11,12,13',
                'colors' => ['Grey', 'Navy', 'Black'],
                'image_url' => 'https://images.unsplash.com/photo-1605408499391-6368c628ef42?w=500',
                'image_gallery' => [
                    'https://images.unsplash.com/photo-1605408499391-6368c628ef42?w=500'
                ],
                'is_featured' => true,
                'is_active' => true,
                'status' => 'active',
                'tags' => 'running, new balance, premium, made in usa, comfort',
                'meta_title' => 'New Balance 990v5 - Premium Made in USA Sneakers',
                'meta_description' => 'Shop New Balance 990v5 sneakers. Premium construction made in USA with ENCAP cushioning technology.',
                'warranty_period' => '1 Year',
                'created_by' => $adminId,
            ],
            [
                'name' => 'Reebok Classic Leather',
                'slug' => 'reebok-classic-leather',
                'description' => 'The Reebok Classic Leather is a timeless athletic shoe with soft leather upper and comfortable cushioning.',
                'short_description' => 'Timeless athletic shoes with soft leather upper.',
                'price' => 75.00,
                'sale_price' => 59.99,
                'cost_price' => 40.00,
                'category' => 'Casual',
                'brand' => 'Reebok',
                'sku' => 'RB-CL-008',
                'barcode' => '1234567890130',
                'stock_quantity' => 55,
                'min_stock_level' => 10,
                'weight' => 0.8,
                'dimensions' => '30x20x12 cm',
                'size' => '6,7,8,9,10,11,12',
                'colors' => ['White', 'Black', 'Brown'],
                'image_url' => 'https://images.unsplash.com/photo-1582588678413-dbf45f4823e9?w=500',
                'image_gallery' => [
                    'https://images.unsplash.com/photo-1582588678413-dbf45f4823e9?w=500'
                ],
                'is_featured' => false,
                'is_active' => true,
                'status' => 'active',
                'tags' => 'casual, reebok, leather, classic, comfortable',
                'meta_title' => 'Reebok Classic Leather - Timeless Athletic Shoes',
                'meta_description' => 'Shop Reebok Classic Leather shoes. Soft leather construction with timeless athletic style.',
                'warranty_period' => '6 Months',
                'created_by' => $adminId,
            ]
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }

        echo "Sample products created successfully!\n";
        echo "Featured products: " . Product::where('is_featured', true)->count() . "\n";
        echo "Total products: " . Product::count() . "\n";
    }
}
