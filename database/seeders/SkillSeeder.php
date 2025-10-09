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
        Skill::updateOrCreate(['description' => 'Flota como una foca feliz'], ['description' => 'Flota como una foca feliz']);
        Skill::updateOrCreate(['description' => 'Manos al agua sin miedo'], ['description' => 'Manos al agua sin miedo']);
        Skill::updateOrCreate(['description' => 'Respira y relájate'], ['description' => 'Respira y relájate']);

        Skill::updateOrCreate(['description' => 'Patadas firmes y seguras'], ['description' => 'Patadas firmes y seguras']);
        Skill::updateOrCreate(['description' => 'Brazos lentos pero fuertes'], ['description' => 'Brazos lentos pero fuertes']);
        Skill::updateOrCreate(['description' => 'Avanza sin prisa, sin pausa'], ['description' => 'Avanza sin prisa, sin pausa']);

        Skill::updateOrCreate(['description' => 'Desliza como una sombra'], ['description' => 'Desliza como una sombra']);
        Skill::updateOrCreate(['description' => 'Controla cada brazada'], ['description' => 'Controla cada brazada']);
        Skill::updateOrCreate(['description' => 'Coordinación perfecta'], ['description' => 'Coordinación perfecta']);

        Skill::updateOrCreate(['description' => 'Velocidad bajo control'], ['description' => 'Velocidad bajo control']);
        Skill::updateOrCreate(['description' => 'Potencia en cada vuelta'], ['description' => 'Potencia en cada vuelta']);
        Skill::updateOrCreate(['description' => 'Resistencia como un pro'], ['description' => 'Resistencia como un pro']);

        Skill::updateOrCreate(['description' => 'Nada como un depredador'], ['description' => 'Nada como un depredador']);
        Skill::updateOrCreate(['description' => 'Dominio total del agua'], ['description' => 'Dominio total del agua']);
        Skill::updateOrCreate(['description' => 'Estrategia y potencia'], ['description' => 'Estrategia y potencia']);
    }
}
