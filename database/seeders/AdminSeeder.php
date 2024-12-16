<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'first_name' => 'hemangi',
            'last_name' => 'rathod',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'is_admin' => 1 ,
            'profile_image' => null,
        ]);
    }
}
