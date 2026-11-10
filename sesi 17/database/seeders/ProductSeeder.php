<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Tugas 2: Menambahkan data dummy produk e-commerce
     */
    public function run(): void
    {
        // Ambil ID kategori berdasarkan nama
        $catElektronik = Category::where('name', 'Elektronik & Komputer')->first()?->id;
        $catAksesoris  = Category::where('name', 'Aksesoris & Periferal')->first()?->id;
        $catAudio      = Category::where('name', 'Audio & Headset')->first()?->id;
        $catGaming     = Category::where('name', 'Gaming Gear')->first()?->id;
        $catGadget     = Category::where('name', 'Smart Gadget')->first()?->id;

        $products = [
            [
                'name'        => 'MacBook Air M2 13-inch',
                'category_id' => $catElektronik,
                'category'    => 'Elektronik & Komputer',
                'price'       => 16499000,
                'description' => 'Laptop super ramping bertenaga chip Apple M2 dengan baterai tahan hingga 18 jam dan layar Liquid Retina.',
                'stock'       => 12,
                'image'       => 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=800&q=80',
            ],
            [
                'name'        => 'Keyboard Mekanikal Wireless RGB',
                'category_id' => $catGaming,
                'category'    => 'Gaming Gear',
                'price'       => 850000,
                'description' => 'Keyboard mekanikal hot-swappable dengan switch linear, konektivitas Bluetooth 5.0, 2.4GHz, dan RGB backlight.',
                'stock'       => 25,
                'image'       => 'https://images.unsplash.com/photo-1587829741301-dc798b83add3?w=800&q=80',
            ],
            [
                'name'        => 'Mouse Ergonomis Nirkabel Silent',
                'category_id' => $catAksesoris,
                'category'    => 'Aksesoris & Periferal',
                'price'       => 375000,
                'description' => 'Mouse ergonomis vertikal peredam nyeri pergelangan tangan, klik hening dengan baterai tahan 6 bulan.',
                'stock'       => 30,
                'image'       => 'https://images.unsplash.com/photo-1615663245857-ac93bb7c39e7?w=800&q=80',
            ],
            [
                'name'        => 'Headphone ANC Nirkabel Premium',
                'category_id' => $catAudio,
                'category'    => 'Audio & Headset',
                'price'       => 1899000,
                'description' => 'Headphone over-ear dengan fitur Active Noise Cancelling (ANC), driver 40mm, dan audio resolusi tinggi.',
                'stock'       => 15,
                'image'       => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=800&q=80',
            ],
            [
                'name'        => 'Smartwatch Amoled Fitness Tracker',
                'category_id' => $catGadget,
                'category'    => 'Smart Gadget',
                'price'       => 1250000,
                'description' => 'Jam tangan pintar layar AMOLED cerah, pemantau detak jantung, SpO2, GPS internal, dan tahan air 5 ATM.',
                'stock'       => 18,
                'image'       => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=800&q=80',
            ],
            [
                'name'        => 'Monitor Gaming Ultrawide 34-inch 144Hz',
                'category_id' => $catGaming,
                'category'    => 'Gaming Gear',
                'price'       => 5890000,
                'description' => 'Monitor lengkung ultrawide 3440x1440, refresh rate 144Hz, waktu respon 1ms, dan dukungan HDR400.',
                'stock'       => 8,
                'image'       => 'https://images.unsplash.com/photo-1527443224154-c4a3942d3acf?w=800&q=80',
            ],
            [
                'name'        => 'USB-C Docking Station 9-in-1',
                'category_id' => $catAksesoris,
                'category'    => 'Aksesoris & Periferal',
                'price'       => 499000,
                'description' => 'Adapter multifungsi dengan port HDMI 4K, 3x USB 3.0, Gigabit Ethernet, SD card reader, dan PD 100W.',
                'stock'       => 40,
                'image'       => 'https://images.unsplash.com/photo-1544652478-6653e09f18a2?w=800&q=80',
            ],
            [
                'name'        => 'TWS Earbuds Hi-Fi Bass',
                'category_id' => $catAudio,
                'category'    => 'Audio & Headset',
                'price'       => 450000,
                'description' => 'Earbuds nirkabel dengan mikrofon AI crystal-clear call, IPX5 tahan keringat, dan total playback 32 jam.',
                'stock'       => 35,
                'image'       => 'https://images.unsplash.com/photo-1590658268037-6bf12165a8df?w=800&q=80',
            ],
        ];

        foreach ($products as $prod) {
            Product::updateOrCreate(
                ['name' => $prod['name']],
                $prod
            );
        }
    }
}
