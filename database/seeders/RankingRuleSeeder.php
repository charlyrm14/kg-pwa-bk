<?php

namespace Database\Seeders;

use App\Models\RankingRule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RankingRuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rankingRules = [
            [
                'id' => 1,
                'name' => 'Asistencia a clase',
                'description' => null,
                'trigger_type' => 'attendances',
                'trigger_id' => null,
                'points_awarded' => 10,
                'max_points_per_period' => 50,
                'is_active' => true,
            ],
            [
                'id' => 2,
                'name' => 'Asistencia perfecta semanal',
                'description' => null,
                'trigger_type' => 'attendances',
                'trigger_id' => 'perfect_week',
                'points_awarded' => 20,
                'max_points_per_period' => 20,
                'is_active' => true,
            ],
            [
                'id' => 3,
                'name' => 'Pago mensual puntual',
                'description' => null,
                'trigger_type' => 'payment',
                'trigger_id' => null,
                'points_awarded' => 50,
                'max_points_per_period' => 50,
                'is_active' => true,
            ],
            [
                'id' => 4,
                'name' => 'Pago anticipado',
                'description' => null,
                'trigger_type' => 'payment',
                'trigger_id' => 'early_payment',
                'points_awarded' => 20,
                'max_points_per_period' => 20,
                'is_active' => true,
            ],
            [
                'id' => 5,
                'name' => 'Nivel completado',
                'description' => null,
                'trigger_type' => 'levels',
                'trigger_id' => null,
                'points_awarded' => 100,
                'max_points_per_period' => null,
                'is_active' => true,
            ],
            [
                'id' => 6,
                'name' => 'Ascenso de nivel',
                'description' => null,
                'trigger_type' => 'levels',
                'trigger_id' => 'promotion',
                'points_awarded' => 50,
                'max_points_per_period' => null,
                'is_active' => true,
            ],
            [
                'id' => 7,
                'name' => 'Logro desbloqueado',
                'description' => null,
                'trigger_type' => 'achievement',
                'trigger_id' => null,
                'points_awarded' => 30,
                'max_points_per_period' => null,
                'is_active' => true,
            ],
            [
                'id' => 8,
                'name' => 'Logro especial',
                'description' => null,
                'trigger_type' => 'achievement',
                'trigger_id' => 'special',
                'points_awarded' => 70,
                'max_points_per_period' => null,
                'is_active' => true,
            ],
            [
                'id' => 9,
                'name' => 'Racha de asistencias',
                'description' => null,
                'trigger_type' => 'attendances',
                'trigger_id' => 'streak_5',
                'points_awarded' => 25,
                'max_points_per_period' => 25,
                'is_active' => true,
            ],
        ];

        RankingRule::upsert(
            $rankingRules,
            ['trigger_type', 'trigger_id'],
            [
                'name', 
                'description', 
                'trigger_type', 
                'trigger_id', 
                'points_awarded', 
                'max_points_per_period', 
                'is_active'
            ]
        );
    }
}
