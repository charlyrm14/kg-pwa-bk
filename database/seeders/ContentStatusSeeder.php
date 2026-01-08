<?php

namespace Database\Seeders;

use App\Models\ContentStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contentStatus = [
            ['id' => 1,'name' => 'Borrador', 'slug' => 'borrador', 'description' => 'El contenido está siendo creado'],
            ['id' => 2,'name' => 'Pendiente de revisión', 'slug' => 'pendiente-de-revision', 'description' => 'El contenido está listo y el autor lo ha enviado para su aprobación'],
            ['id' => 3,'name' => 'Rechazado', 'slug' => 'rechazado', 'description' => 'El moderador revisó el contenido y determino que necesita correcciones'],
            ['id' => 4,'name' => 'Programado', 'slug' => 'programado', 'description' => 'Contenido con fecha de publicación futura'],
            ['id' => 5,'name' => 'Publicado', 'slug' => 'publicado', 'description' => 'El Contenido es visible para todos los usuarios en la aplicación'],
            ['id' => 6,'name' => 'No publicado', 'slug' => 'no-publicado', 'description' => 'El contenido fue publicado, pero fue retirado temporalmente'],
            ['id' => 7,'name' => 'Eliminado', 'slug' => 'eliminado', 'description' => 'Contenido eliminado'],
        ];

        ContentStatus::upsert($contentStatus, ['id'], ['name', 'slug', 'description']);
    }
}
