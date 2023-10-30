<?php

namespace Database\Seeders;

use App\Models\BloodGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BloogGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
        foreach ($items as $key => $item) {
            BloodGroup::create([
                'name' => $item,
            ]);
        }
    }
}
