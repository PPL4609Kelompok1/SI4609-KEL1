<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RecommendationController extends Controller
{
    public function index()
    {
        $products = [
            [
                'name' => 'LYUMO US',
                'image' => 'images\electricity_saving_box.webp',
                'description' => '24KW Home Electricity - Energy Factor Saver Electronic',
                'price' => 'Rp 250.000,-',
                'reviews' => [
                    'Produk ini sangat membantu menghemat daya!',
                    'Cocok untuk rumah dengan pemakaian listrik besar.',
                ],
                'shopee_link' => 'https://shopee.co.id/2024-NEW-ELECTRICITY-SAVING-BOX-Household-Electric-Device-Energy-Saving-Box-i.1014017727.24078865165',
                'tokopedia_link' => 'https://www.tokopedia.com/bussines-hiovbxq/hemat-daya-80-90-zx-penghemat-listrik-alat-penghemat-listrik-token-meteran-home-berlaku-untuk-semua-meteran-listrik-pasang-dan-mainkan-hemat-daya-electric-saver-power-factor-saver-electric-saver-electricity-saving-box-alat-hemat-daya-penghemat-daya-1730850753204749700?extParam=ivf%3Dfalse%26keyword%3Dpower+saver+factor%26search_id%3D20250415132625EFDC168E4C8F491F70SJ%26src%3Dsearch',
            ],
            [
                'name' => 'Solar Panel 100W',
                'image' => 'https://cdn.mos.cms.futurecdn.net/CqWL82hz69BP8oGSqBuUwG.jpg',
                'description' => 'Solar panel 100W untuk kebutuhan listrik rumah tangga.',
                'price' => 'Rp 900.000,-',
                'reviews' => [
                    'Daya tahan bagus dan efisien!',
                    'Mudah dipasang, cocok untuk rumah kecil.',
                ],
                'shopee_link' => 'https://shopee.co.id/produk-solarpanel100w',
                'tokopedia_link' => 'https://tokopedia.link/produk-solarpanel100w',
            ],
            [
                'name' => 'Lampu Tenaga Surya Otomatis',
                'image' => 'https://images.tokopedia.net/img/cache/700/VqbcmM/2022/12/23/31e9d5ed-3c58-48db-a6d0-d4a1c5f2b83e.jpg',
                'description' => 'Lampu otomatis dengan panel surya untuk taman atau jalanan.',
                'price' => 'Rp 120.000,-',
                'reviews' => [
                    'Sangat terang dan hemat listrik!',
                    'Cocok untuk outdoor dan cuaca ekstrem.',
                ],
                'shopee_link' => 'https://shopee.co.id/produk-lampusurya',
                'tokopedia_link' => 'https://tokopedia.link/produk-lampusurya',
            ],
            [
                'name' => 'Inverter 12V ke 220V',
                'image' => 'https://www.invertersrus.com/wp-content/uploads/2020/03/psw-inverter.jpg',
                'description' => 'Inverter berkualitas tinggi untuk sistem tenaga surya.',
                'price' => 'Rp 1.250.000,-',
                'reviews' => [
                    'Stabil dan cocok untuk perangkat rumah tangga.',
                    'Kualitas bagus, sesuai deskripsi.',
                ],
                'shopee_link' => 'https://shopee.co.id/produk-inverter',
                'tokopedia_link' => 'https://tokopedia.link/produk-inverter',
            ],
            [
                'name' => 'Baterai Lithium 12V 100Ah',
                'image' => 'https://cdn11.bigcommerce.com/s-76h1u0/images/stencil/1280x1280/products/361/1441/12v100ah-main__03297.1609878662.png',
                'description' => 'Baterai lithium tahan lama untuk penyimpanan energi surya.',
                'price' => 'Rp 3.500.000,-',
                'reviews' => [
                    'Sangat tahan lama, cocok untuk backup listrik.',
                    'Pemasangan mudah dan aman.',
                ],
                'shopee_link' => 'https://shopee.co.id/produk-baterai',
                'tokopedia_link' => 'https://tokopedia.link/produk-baterai',
            ],
            [
                'name' => 'Smart Energy Monitor',
                'image' => 'https://cdn.thewirecutter.com/wp-content/media/2022/04/energymonitors-2048px-0632.jpg',
                'description' => 'Pantau konsumsi listrik rumah dengan mudah dan akurat.',
                'price' => 'Rp 650.000,-',
                'reviews' => [
                    'Akurasi sangat baik!',
                    'Bisa bantu saya kurangi tagihan bulanan.',
                ],
                'shopee_link' => 'https://shopee.co.id/produk-monitor',
                'tokopedia_link' => 'https://tokopedia.link/produk-monitor',
            ],
        ];

        return view('recommendations.index', compact('products'));
    }
}