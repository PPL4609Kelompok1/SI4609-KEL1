<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Review;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'LYUMO US',
                'image_url' => 'images/electricity_saving_box.webp',
                'description' => '24KW Home Electricity - Energy Factor Saver Electronic',
                'price' => 250000,
                'category' => 'solar',
                'marketplace_url' => 'https://shopee.co.id/2024-NEW-ELECTRICITY-SAVING-BOX-Household-Electric-Device-Energy-Saving-Box-i.1014017727.24078865165',
                'energy_efficiency_rating' => 4,
                'reviews' => [
                    ['username' => 'Budi', 'rating' => 5, 'comment' => 'Produk ini sangat membantu menghemat daya!'],
                    ['username' => 'Ani', 'rating' => 4, 'comment' => 'Cocok untuk rumah dengan pemakaian listrik besar.'],
                ]
            ],
            [
                'name' => 'Solar Panel 100W',
                'image_url' => 'images/Solar_Cell_100W.jpg',
                'description' => 'Solar panel 100W untuk kebutuhan listrik rumah tangga.',
                'price' => 899500,
                'category' => 'solar',
                'marketplace_url' => 'https://www.tokopedia.com/pitoserba/solar-cell-panel-surya-100wp-100-wp-100-watt-system-12v-12-volt-poly?utm_source=google&utm_medium=organic&utm_campaign=pdp',
                'energy_efficiency_rating' => 5,
                'reviews' => [
                    ['username' => 'Rudi', 'rating' => 5, 'comment' => 'Daya tahan bagus dan efisien!'],
                    ['username' => 'Siti', 'rating' => 4, 'comment' => 'Mudah dipasang, cocok untuk rumah kecil.'],
                ]
            ],
            [
                'name' => 'Lampu Tenaga Surya Otomatis',
                'image_url' => 'images/Lampu_Tenaga_Surya.jpg',
                'description' => 'Lampu otomatis dengan panel surya untuk taman atau jalanan.',
                'price' => 499000,
                'category' => 'solar',
                'marketplace_url' => 'https://www.tokopedia.com/paleosky/lampu-jalan-tenaga-surya-new-lampu-taman-tenaga-surya-otomatis-outdoor?utm_source=google&utm_medium=organic&utm_campaign=pdp',
                'energy_efficiency_rating' => 5,
                'reviews' => [
                    ['username' => 'Dewi', 'rating' => 5, 'comment' => 'Sangat terang dan hemat listrik!'],
                    ['username' => 'Ahmad', 'rating' => 4, 'comment' => 'Cocok untuk outdoor dan cuaca ekstrem.'],
                ]
            ],
            [
                'name' => 'Inverter 12V ke 220V',
                'image_url' => 'images/Power_Inverter_DC.jpg',
                'description' => 'Inverter berkualitas tinggi untuk sistem tenaga surya.',
                'price' => 155000,
                'category' => 'solar',
                'marketplace_url' => 'https://www.tokopedia.com/butiklampu/power-inverter-dc-12v-ke-ac-220v-300w-u-panel-surya-baterai-ups',
                'energy_efficiency_rating' => 3,
                'reviews' => [
                    ['username' => 'Rina', 'rating' => 5, 'comment' => 'Stabil dan cocok untuk perangkat rumah tangga.'],
                    ['username' => 'Hendra', 'rating' => 4, 'comment' => 'Kualitas bagus, sesuai deskripsi.'],
                ]
            ],
            [
                'name' => 'Baterai Lithium 12V 100Ah',
                'image_url' => 'images/Baterai_Lithium_12V.webp',
                'description' => 'Baterai lithium tahan lama untuk penyimpanan energi surya.',
                'price' => 5400000,
                'category' => 'solar',
                'marketplace_url' => 'https://www.tokopedia.com/ecopowerhome/voz-lifepo4-12-8v-100-ah-lithium-battery-original?utm_source=google&utm_medium=organic&utm_campaign=pdp',
                'energy_efficiency_rating' => 4,
                'reviews' => [
                    ['username' => 'Fajar', 'rating' => 5, 'comment' => 'Sangat tahan lama, cocok untuk backup listrik.'],
                    ['username' => 'Linda', 'rating' => 4, 'comment' => 'Pemasangan mudah dan aman.'],
                ]
            ],
            [
                'name' => 'Tuya Smart Energy Meter Power 80A WiFi',
                'image_url' => 'images/smart_energy_monitor.webp',
                'description' => 'Pantau konsumsi listrik rumah dengan mudah dan akurat.',
                'price' => 650000,
                'category' => 'solar',
                'marketplace_url' => 'https://www.tokopedia.com/istartech/tuya-smart-energy-meter-power-80a-wifi-with-current-transformer-clamp-kwh?utm_source=google&utm_medium=organic&utm_campaign=pdp',
                'energy_efficiency_rating' => 4,
                'reviews' => [
                    ['username' => 'Rudi', 'rating' => 5, 'comment' => 'Akurasi sangat baik!'],
                    ['username' => 'Siti', 'rating' => 4, 'comment' => 'Bisa bantu saya kurangi tagihan bulanan.'],
                ]
            ],
        ];

        foreach ($products as $productData) {
            $reviews = $productData['reviews'];
            unset($productData['reviews']);
            
            $product = Product::create($productData);
            
            foreach ($reviews as $reviewData) {
                $product->reviews()->create($reviewData);
            }
        }
    }
}
