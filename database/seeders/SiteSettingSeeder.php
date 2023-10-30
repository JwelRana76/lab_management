<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SiteSetting;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SiteSetting::create([
            'name' => 'Demo Hospital Management',
            'name_short' => 'DHMS',
            'address' => 'Jashore Sadar, Jashore',
            'contact' => '01571-166570',
        ]);
    }
}
