<?php

namespace Database\Seeders;

use App\Models\Achievement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AchievementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $achievements = [
            [
                'id' => 1,
                'name' => 'Asistencia Perfecta de la Semana',
                'description' => 'Asiste a todas las sesiones de entrenamiento programadas en una semana (5 sesiones).',
                'achievement_frequency_id' => 3,
                'threshold' => 5,
                'unit' => 'SESSIONS',
            ],
            [
                'id' => 2,
                'name' => 'Madrugador Constante',
                'description' => 'Llega a tiempo y registra asistencia PRESENTE por 3 días consecutivos.',
                'achievement_frequency_id' => 2,
                'threshold' => 3,
                'unit' => 'DAYS',
            ],
            [
                'id' => 3,
                'name' => 'Maestro del Estilo Libre',
                'description' => 'Supera el récord personal de 100 metros estilo libre en 3 segundos (Logro binario: sí/no).',
                'achievement_frequency_id' => 1,
                'threshold' => 1,
                'unit' => 'COMPLETION',
            ],
            [
                'id' => 4,
                'name' => 'Resistencia de Tiburón',
                'description' => 'Completa un entrenamiento acumulado de 5,000 metros en un solo mes.',
                'achievement_frequency_id' => 4,
                'threshold' => 5000,
                'unit' => 'METERS',
            ],
            [
                'id' => 5,
                'name' => 'La Primer Medalla',
                'description' => 'Registra una medalla o premio en una competencia oficial.',
                'achievement_frequency_id' => 1,
                'threshold' => 1,
                'unit' => 'COUNT',
            ],
            [
                'id' => 6,
                'name' => 'Promoción a Delfín',
                'description' => 'Asciende de la categoría Foca a la categoría Delfín.',
                'achievement_frequency_id' => 1,
                'threshold' => 1,
                'unit' => 'PROMOTION',
            ],
        ];

        Achievement::upsert($achievements, ['id'], ['name', 'description', 'achievement_frequency_id', 'threshold', 'unit']);
    }
}
