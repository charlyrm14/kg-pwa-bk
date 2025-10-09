<?php

namespace Database\Seeders;

use App\Models\PeriodType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PeriodTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $periodTypes = [
            [
                'id' => 1,
                'name' => 'DAILY',
                'description' => 'Período de 24 horas, utilizado para seguimiento de asistencia y retos diarios.',
            ],
            [
                'id' => 2,
                'name' => 'WEEKLY',
                'description' => 'Período de 7 días (semana completa), útil para resúmenes y retos semanales.',
            ],
            [
                'id' => 3,
                'name' => 'MONTHLY',
                'description' => 'Período de un mes calendario, esencial para la facturación y reportes de progreso.',
            ],
            [
                'id' => 4,
                'name' => 'QUARTERLY',
                'description' => 'Período trimestral (3 meses), utilizado para reportes de desempeño a largo plazo.',
            ],
            [
                'id' => 5,
                'name' => 'ANNUAL',
                'description' => 'Período anual (12 meses), utilizado para membresías y resúmenes de fin de año.',
            ],
        ];

        PeriodType::upsert($periodTypes, ['id'], ['name', 'description']);
    }
}
