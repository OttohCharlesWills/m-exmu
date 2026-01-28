<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlanSeeder extends Seeder
{
    public function run()
    {
        DB::table('plans')->insert([
            [
                'name' => 'Premium Seller',
                'slug' => 'premium',
                'price' => 5000,
                'duration_days' => 30,
            ],
        ]);
    }
}
