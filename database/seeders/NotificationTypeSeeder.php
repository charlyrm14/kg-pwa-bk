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
            [
                'id' => 1, 
                'name' => 'Nuevo contenido', 
                'slug' => 'nuevo-contenido',
                'description' => 'Un nuevo contenido ha sido publicado.'
            ],
            [
                'id' => 2, 
                'name' => 'Logro desbloqueado', 
                'slug' => 'logro-desbloqueado',
                'description' => 'Has desbloqueado un nuevo logro'
            ],
            [
                'id' => 3, 
                'name' => 'Asistencia', 
                'slug' => 'asistencia',
                'description' => 'Tenemos un aviso importante sobre tus asistencias'
            ],
            [
                'id' => 4, 
                'name' => 'Nuevo mensaje', 
                'slug' => 'nuevo-mensaje',
                'description' => 'Tienes un nuevo mensaje por parte de King Dreams'
            ],
            [
                'id' => 5, 
                'name' => 'Recordatorio', 
                'slug' => 'recordatorio',
                'description' => 'Recordatorio de una práctica o evento programado.'
            ],
            [
                'id' => 6, 
                'name' => 'Anuncio general', 
                'slug' => 'anuncio-general',
                'description' => 'Anuncio importante y general por parte de la administración del club.'
            ],
        ];

        NotificationType::upsert($types, ['id'], ['name', 'slug', 'description']);
    }
}
