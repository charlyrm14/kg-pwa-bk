<?php

namespace Database\Seeders;

use App\Models\ChatType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChatTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $chatTypes = [
            ['id' => 1, 'name' => 'Directo', 'description' => 'Conversación uno a uno entre dos usuarios.'],
            ['id' => 2, 'name' => 'Grupo', 'description' => 'Conversación entre tres o más usuarios.'],
            ['id' => 3, 'name' => 'Asistente IA', 'description' => 'Conversación entre un usuario y la IA de la aplicación.'],
            ['id' => 4, 'name' => 'Soporte', 'description' => 'Conversación entre un usuario y el equipo de soporte/administradores.'],
        ];

        ChatType::upsert($chatTypes, ['id'], ['name', 'description']);
    }
}
