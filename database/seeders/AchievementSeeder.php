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
                'name' => 'Asistencia perfecta de la semana',
                'description' => 'Asiste a todas las sesiones de entrenamiento programadas en una semana (5 sesiones).',
                'achievement_frequency_id' => 3,
                'threshold' => 5,
                'unit' => 'sesiones',
            ],
            [
                'id' => 2,
                'name' => 'Madrugador constante',
                'description' => 'Llega a tiempo y registra asistencia PRESENTE por 3 días consecutivos.',
                'achievement_frequency_id' => 2,
                'threshold' => 3,
                'unit' => 'dias',
            ],
            [
                'id' => 3,
                'name' => 'Maestro del estilo libre',
                'description' => 'Supera el récord personal de 100 metros estilo libre en 3 segundos (Logro binario: sí/no).',
                'achievement_frequency_id' => 1,
                'threshold' => 1,
                'unit' => 'finalizado',
            ],
            [
                'id' => 4,
                'name' => 'Resistencia de tiburón',
                'description' => 'Completa un entrenamiento acumulado de 5,000 metros en un solo mes.',
                'achievement_frequency_id' => 4,
                'threshold' => 5000,
                'unit' => 'metros',
            ],
            [
                'id' => 5,
                'name' => 'La primer medalla',
                'description' => 'Registra una medalla o premio en una competencia oficial.',
                'achievement_frequency_id' => 1,
                'threshold' => 1,
                'unit' => 'contador',
            ],
            [
                'id' => 6,
                'name' => 'Promoción a delfín',
                'description' => 'Asciende de la categoría Foca a la categoría Delfín.',
                'achievement_frequency_id' => 1,
                'threshold' => 1,
                'unit' => 'promocion',
            ],
        ];

        Achievement::upsert($achievements, ['id'], ['name', 'description', 'achievement_frequency_id', 'threshold', 'unit']);
    }
}
