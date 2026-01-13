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
                'name' => 'Diaria',
                'slug' => 'diaria',
                'description' => 'Período de 24 horas, utilizado para seguimiento de asistencia y retos diarios.',
                'duration_days' => 1
            ],
            [
                'id' => 2,
                'name' => 'Semanal',
                'slug' => 'semanal',
                'description' => 'Período de 7 días (semana completa), útil para resúmenes y retos semanales.',
                'duration_days' => 7
            ],
            [
                'id' => 3,
                'name' => 'Mensual',
                'slug' => 'mensual',
                'description' => 'Período de un mes calendario, esencial para la facturación y reportes de progreso.',
                'duration_days' => null
            ],
            [
                'id' => 4,
                'name' => 'Trimestral',
                'slug' => 'trimestral',
                'description' => 'Período trimestral (3 meses), utilizado para reportes de desempeño a largo plazo.',
                'duration_days' => null
            ],
            [
                'id' => 5,
                'name' => 'Anual',
                'slug' => 'anual',
                'description' => 'Período anual (12 meses), utilizado para membresías y resúmenes de fin de año.',
                'duration_days' => null
            ],
        ];

        PeriodType::upsert($periodTypes, ['id'], ['name', 'description']);
    }
}
