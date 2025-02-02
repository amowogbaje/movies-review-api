<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            // 'email' => 'amowogbajegideon@gmail.com',
            'is_admin' => 1,
            'is_approved' => 1
        ]);
    }
}
