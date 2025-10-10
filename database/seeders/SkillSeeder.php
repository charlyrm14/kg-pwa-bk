<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skills = [
            ['id' => 1, 'description' => 'Flota como una foca feliz'],
            ['id' => 2, 'description' => 'Manos al agua sin miedo'],
            ['id' => 3, 'description' => 'Respira y relájate'],
            ['id' => 4, 'description' => 'Patadas firmes y seguras'],
            ['id' => 5, 'description' => 'Brazos lentos pero fuertes'],
            ['id' => 6, 'description' => 'Avanza sin prisa, sin pausa'],
            ['id' => 7, 'description' => 'Desliza como una sombra'],
            ['id' => 8, 'description' => 'Controla cada brazada'],
            ['id' => 9, 'description' => 'Coordinación perfecta'],
            ['id' => 10, 'description' => 'Velocidad bajo control'],
            ['id' => 11, 'description' => 'Potencia en cada vuelta'],
            ['id' => 12, 'description' => 'Resistencia como un pro'],
            ['id' => 13, 'description' => 'Nada como un depredador'],
            ['id' => 14, 'description' => 'Dominio total del agua'],
            ['id' => 15, 'description' => 'Estrategia y potencia']
        ];

        Skill::upsert($skills, ['id'], ['description']);
    }
}
