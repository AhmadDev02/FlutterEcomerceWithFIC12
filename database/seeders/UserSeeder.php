<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::factory(9)->create();

        $user = \App\Models\User::factory()->create([
            'name' => 'Ahmad Fajar Alfaravi',
            'email' => 'afajaralfaravi@gmail.com',
            'password' => Hash::make("ahmel0211"),
            'phone' => '085157151563',
            'roles' => "Admin"
        ]);
    }
}
