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
        $categories = [
            ['id' => 1, 'name' => 'FOCA', 'slug' => 'FOCA', 'description' => '¡Felicidades por comenzar tu aventura acuática! Como una foca, ya estás ganando confianza en el agua. Sigue practicando y pronto estarás nadando como un experto. ¡Vamos paso a paso!'],
            ['id' => 2, 'name' => 'TORTUGA', 'slug' => 'TORTUGA', 'description' => '¡Ya estás avanzando firme como una tortuga en su travesía! Tu técnica mejora y se nota tu esfuerzo. Sigue con esa constancia, que cada brazada te acerca a tu próxima meta.'],
            ['id' => 3, 'name' => 'MANTARRAYA', 'slug' => 'MANTARRAYA', 'description' => '¡Deslizas en el agua como una mantarraya! Has mejorado mucho tu fluidez y control. Mantén tu concentración y disciplina, vas por excelente camino. ¡Sigue brillando!'],
            ['id' => 4, 'name' => 'PEZ VELA', 'slug' => 'PEZ-VELA', 'description' => '¡Vuelas sobre el agua como un pez vela! Tu velocidad y técnica están en otro nivel. Estás muy cerca de dominarlo todo. Mantén tu energía al máximo, ¡ya casi llegas!'],
            ['id' => 5, 'name' => 'TIBURÓN', 'slug' => 'TIBURON', 'description' => '¡Eres un tiburón en la piscina! Has llegado al nivel más alto y tu esfuerzo es evidente. Sigue entrenando con pasión, ahora eres un ejemplo para otros nadadores. ¡Orgullo total!']
        ];

        SwimCategory::upsert($categories, ['id'], ['name', 'slug', 'description']);
    }
}
