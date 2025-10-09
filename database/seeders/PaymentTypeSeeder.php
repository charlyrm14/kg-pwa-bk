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
                'name' => 'MONTHLY_STANDARD', 
                'description' => 'Membresía básica de natación con acceso ilimitado a las clases grupales durante 30 días.',
                'base_amount' => 1500.00,
                'is_recurring' => true,
                'coverage_days' => 30,
            ],
            [
                'id' => 2, 
                'name' => 'ANNUAL_PREMIUM', 
                'description' => 'Membresía anual con un 10% de descuento y acceso prioritario a eventos y clínicas.',
                'base_amount' => 1100.00,
                'is_recurring' => true,
                'coverage_days' => 365,
            ],
            [
                'id' => 3, 
                'name' => 'SINGLE_CLASS', 
                'description' => 'Pase de un día para una clase de prueba o un evento especial. No recurrente.',
                'base_amount' => 250.00,
                'is_recurring' => false,
                'coverage_days' => 1,
            ],
            [
                'id' => 4, 
                'name' => 'FAMILY_MONTHLY', 
                'description' => 'Membresía mensual con tarifa reducida para el segundo miembro de la familia y subsiguientes.', // Precio familiar con descuento
                'base_amount' => 2300.00, 
                'is_recurring' => true,
                'coverage_days' => 30,
            ],
        ];

        PaymentType::upsert($types, ['id'], ['name', 'description', 'base_amount', 'is_recurring', 'coverage_days']);
    }
}
