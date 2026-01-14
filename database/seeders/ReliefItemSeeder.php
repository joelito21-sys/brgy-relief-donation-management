<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ReliefItem;

class ReliefItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            [
                'name' => 'Rice',
                'description' => '5kg bag of premium rice',
                'type' => 'food',
                'quantity_available' => 100,
                'unit' => 'bags',
                'weight_kg' => 5.0,
            ],
            [
                'name' => 'Canned Goods',
                'description' => 'Assorted canned sardines and corned beef',
                'type' => 'food',
                'quantity_available' => 200,
                'unit' => 'cans',
                'weight_kg' => 0.5,
            ],
            [
                'name' => 'Drinking Water',
                'description' => 'Bottled drinking water',
                'type' => 'food',
                'quantity_available' => 500,
                'unit' => 'bottles',
                'weight_kg' => 1.0,
            ],
            [
                'name' => 'Blankets',
                'description' => 'Warm thermal blankets',
                'type' => 'clothing',
                'quantity_available' => 150,
                'unit' => 'pieces',
                'weight_kg' => 2.0,
            ],
            [
                'name' => 'T-Shirts',
                'description' => 'Adult size t-shirts (various sizes)',
                'type' => 'clothing',
                'quantity_available' => 200,
                'unit' => 'pieces',
                'weight_kg' => 0.3,
            ],
            [
                'name' => 'First Aid Kit',
                'description' => 'Basic medical first aid supplies',
                'type' => 'medical',
                'quantity_available' => 50,
                'unit' => 'kits',
                'weight_kg' => 1.5,
            ],
            [
                'name' => 'Medicine',
                'description' => 'Common medicines (paracetamol, antibiotics)',
                'type' => 'medical',
                'quantity_available' => 100,
                'unit' => 'packs',
                'weight_kg' => 0.2,
            ],
            [
                'name' => 'Face Masks',
                'description' => 'Surgical face masks',
                'type' => 'medical',
                'quantity_available' => 1000,
                'unit' => 'pieces',
                'weight_kg' => 0.05,
            ],
        ];

        foreach ($items as $item) {
            ReliefItem::create($item);
        }
    }
}
