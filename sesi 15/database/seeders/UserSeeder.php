<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Menambahkan data dummy pengguna (id, name, email, password)
     */
    public function run(): void
    {
        $users = [
            [
                'name'     => 'Administrator EduShop',
                'email'    => 'admin@edushop.com',
                'password' => Hash::make('password123'),
            ],
            [
                'name'     => 'Budi Santoso',
                'email'    => 'budi@example.com',
                'password' => Hash::make('password123'),
            ],
            [
                'name'     => 'Siti Rahma',
                'email'    => 'siti@example.com',
                'password' => Hash::make('password123'),
            ],
        ];

        foreach ($users as $user) {
            User::firstOrCreate(
                ['email' => $user['email']],
                $user
            );
        }
    }
}
