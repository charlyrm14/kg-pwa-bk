<?php

namespace Database\Seeders;

use App\Models\PaymentType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            [
                'id' => 1,
                'name' => 'Visita',
                'slug' => 'visita',
                'description' => 'Pase de un día para una clase.',
                'base_amount' => 250.00,
                'is_recurring' => false,
                'coverage_days' => 1,
            ],
            [
                'id' => 2,
                'name' => 'Mensual básica',
                'slug' => 'mensual-basica',
                'description' => 'Membresía básica de natación.',
                'base_amount' => 1500.00,
                'is_recurring' => true,
                'coverage_days' => 30,
            ],
            [
                'id' => 3,
                'name' => 'Anual',
                'slug' => 'anual',
                'description' => 'Membresía anual de natación.',
                'base_amount' => 1100.00,
                'is_recurring' => true,
                'coverage_days' => 365,
            ]
        ];

        PaymentType::upsert($types, ['id'], ['name', 'slug', 'description', 'base_amount', 'is_recurring', 'coverage_days']);
    }
}
