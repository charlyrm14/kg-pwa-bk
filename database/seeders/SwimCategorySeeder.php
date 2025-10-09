<?php

namespace Database\Seeders;

use App\Models\SwimCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SwimCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SwimCategory::updateOrCreate([
            'slug' => 'foca'
        ], [
            'name' => 'Foca',
            'slug' => 'foca',
            'description' => "¡Felicidades por comenzar tu aventura acuática! Como una foca, ya estás ganando confianza en el agua. Sigue practicando y pronto estarás nadando como un experto. ¡Vamos paso a paso!"
        ]);

        SwimCategory::updateOrCreate([
            'slug' => 'tortuga'
        ], [
            'name' => 'Tortuga',
            'slug' => 'tortuga',
            'description' => "¡Ya estás avanzando firme como una tortuga en su travesía! Tu técnica mejora y se nota tu esfuerzo. Sigue con esa constancia, que cada brazada te acerca a tu próxima meta."
        ]);

        SwimCategory::updateOrCreate([
            'slug' => 'mantarraya'
        ], [
            'name' => 'Mantarraya',
            'slug' => 'mantarraya',
            'description' => "¡Deslizas en el agua como una mantarraya! Has mejorado mucho tu fluidez y control. Mantén tu concentración y disciplina, vas por excelente camino. ¡Sigue brillando!"
        ]);

        SwimCategory::updateOrCreate([
            'slug' => 'pez-vela'
        ], [
            'name' => 'Pez Vela',
            'slug' => 'pez-vela',
            'description' => "¡Vuelas sobre el agua como un pez vela! Tu velocidad y técnica están en otro nivel. Estás muy cerca de dominarlo todo. Mantén tu energía al máximo, ¡ya casi llegas!"
        ]);

        SwimCategory::updateOrCreate([
            'slug' => 'tiburon'
        ], [
            'name' => 'Tiburón',
            'slug' => 'tiburon',
            'description' => "¡Eres un tiburón en la piscina! Has llegado al nivel más alto y tu esfuerzo es evidente. Sigue entrenando con pasión, ahora eres un ejemplo para otros nadadores. ¡Orgullo total!"
        ]);
    }
}
