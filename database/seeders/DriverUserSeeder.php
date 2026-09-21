<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DriverUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run()
{
    User::create([
        'name' => 'John Driver',
        'email' => 'driver@example.com',
        'password' => bcrypt('password'),
        'role' => 'driver',
    ]);
}
}
