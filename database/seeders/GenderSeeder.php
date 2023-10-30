<?php

namespace Database\Seeders;

use App\Models\Gender;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = ['Male', 'Female', 'Common'];
        foreach ($items as $key => $item) {
            Gender::create([
                'name' => $item,
            ]);
        }
    }
}
