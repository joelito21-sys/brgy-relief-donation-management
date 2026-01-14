<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Area;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $areas = [
            ['name' => 'Barangay 123', 'code' => 'BRG123', 'description' => 'Central barangay area', 'is_active' => true],
            ['name' => 'Barangay 456', 'code' => 'BRG456', 'description' => 'Northern barangay area', 'is_active' => true],
            ['name' => 'Barangay 789', 'code' => 'BRG789', 'description' => 'Southern barangay area', 'is_active' => true],
            ['name' => 'Evacuation Center A', 'code' => 'EVACA', 'description' => 'Main evacuation center', 'is_active' => true],
            ['name' => 'Evacuation Center B', 'code' => 'EVACB', 'description' => 'Secondary evacuation center', 'is_active' => true],
            ['name' => 'City Hall', 'code' => 'CITYH', 'description' => 'City hall distribution point', 'is_active' => true],
        ];

        foreach ($areas as $area) {
            Area::create($area);
        }
    }
}
