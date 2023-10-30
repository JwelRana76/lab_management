<?php

namespace Database\Seeders;

use App\Models\Religion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReligionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = ['Islam', 'Hinduism', 'Buddhism', 'Christianity', 'Other'];
        foreach ($items as $key => $item) {
            Religion::create([
                'name' => $item,
            ]);
        }
    }
}
