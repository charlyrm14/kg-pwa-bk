<?php

namespace Database\Seeders;

use App\Models\NotificationType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NotificationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            ['id' => 1, 'name' => 'Nuevo contenido', 'description' => 'Un nuevo artículo o tip de nutrición ha sido publicado.'],
            ['id' => 2, 'name' => 'Logro desbloqueado', 'description' => 'Has desbloqueado un nuevo logro y puedes reclamar tu recompensa.'],
            ['id' => 3, 'name' => 'Advertencia de asistencia', 'description' => 'Tu porcentaje de asistencia ha bajado del umbral requerido.'],
            ['id' => 4, 'name' => 'Nuevo mensaje', 'description' => 'Tienes un nuevo mensaje en un chat directo o grupal.'],
            ['id' => 5, 'name' => 'Recordatorio', 'description' => 'Recordatorio de una práctica o evento programado.'],
            ['id' => 6, 'name' => 'Anuncio general', 'description' => 'Anuncio importante y general por parte de la administración del club.'],
        ];

        NotificationType::upsert($types, ['id'], ['name', 'description']);
    }
}
