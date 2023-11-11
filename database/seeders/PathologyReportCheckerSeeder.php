<?php

namespace Database\Seeders;

use App\Models\PathologyReportChecker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PathologyReportCheckerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PathologyReportChecker::create([
            'name' => 'Demo Checker',
            'degree' => 'DMT ( DI ) Jashore FT ( JMC)',
            'designation' => 'Medical Technologist Lab',
            'institute' => 'Demo Lab Management',
            'address' => 'Jashore Sadar, Jashore',
        ]);
    }
}
