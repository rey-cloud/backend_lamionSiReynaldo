<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use Illuminate\Support\Facades\Hash;

class OrderSeeder extends Seeder
{
    public function run()
    {
        \App\Models\Order::factory(10)->create();

        Order::create([
            'name' => 'Aubrey Amante',
            'email' => 'aubreyamante@gmail.com',
            'password' => Hash::make('password')
        ]);
    }
}
