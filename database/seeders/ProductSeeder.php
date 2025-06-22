<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name' => 'Laptop Pro X',
            'sku' => 'LPX-001',
            'price' => 75000.00,
            'quantity' => 10,
        ]);

        Product::create([
            'name' => 'Mechanical Keyboard',
            'sku' => 'MK-005',
            'price' => 8500.50,
            'quantity' => 25,
        ]);

        Product::create([
            'name' => 'Wireless Mouse',
            'sku' => 'WM-010',
            'price' => 1200.75,
            'quantity' => 50,
        ]);
    }
}