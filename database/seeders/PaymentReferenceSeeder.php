<?php

namespace Database\Seeders;

use App\Models\PaymentReference;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentReferenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            [
                'id' => 1, 
                'name' => 'Efectivo',
                'slug' => 'efectivo',
                'description' => 'Pago en efectivo',
            ],
            [
                'id' => 2, 
                'name' => 'Transferencia Bancaria (SPEI/SEPA)',
                'slug' => 'transferencia-bancaria',
                'description' => 'Pago realizado a través de transferencia bancaria',
            ],
            [
                'id' => 3, 
                'name' => 'Servicio de Pago (Oxxo, 7-Eleven)',
                'slug' => 'servicio-de-pago-comercios',
                'description' => 'Pago realizado a través de comercios',
            ],
            [
                'id' => 4, 
                'name' => 'Tarjeta de Crédito / Débito',
                'slug' => 'tarjeta-de-credito-debito',
                'description' => 'Pago realizado a través de bancos',
            ],
        ];

        PaymentReference::upsert($types, ['id'], ['name', 'slug', 'description']);
    }
}
