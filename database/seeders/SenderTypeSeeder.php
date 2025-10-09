<?php

namespace Database\Seeders;

use App\Models\SenderType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SenderTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $senderTypes = [
            ['id' => 1, 'name' => 'USER', 'description' => 'Mensaje enviado por un usuario humano (persona).'],
            ['id' => 2, 'name' => 'AI', 'description' => 'Mensaje generado por el asistente de Inteligencia Artificial.'],
            ['id' => 3, 'name' => 'SYSTEM', 'description' => 'Mensaje automático de notificación de la aplicación.'],
        ];

        SenderType::upsert($senderTypes, ['id'], ['name', 'description']);
    }
}
