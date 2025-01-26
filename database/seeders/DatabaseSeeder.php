<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if (!User::where('email', 'admin@gmail.com')->exists()) {
            User::create([
                'name' => 'Super Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('00000000'),
            ]);
        }
    }
}
