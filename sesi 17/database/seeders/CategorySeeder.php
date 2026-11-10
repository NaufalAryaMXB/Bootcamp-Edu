<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Tugas 2: Menambahkan data dummy kategori produk
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Elektronik & Komputer'],
            ['name' => 'Aksesoris & Periferal'],
            ['name' => 'Audio & Headset'],
            ['name' => 'Gaming Gear'],
            ['name' => 'Smart Gadget'],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(['name' => $cat['name']], $cat);
        }
    }
}
