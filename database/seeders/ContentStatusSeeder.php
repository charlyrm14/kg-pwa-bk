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
            ['id' => 1,'name' => 'DRAFT', 'slug' => 'DRAFT', 'description' => 'El contenido está siendo creado'],
            ['id' => 2,'name' => 'PENDING REVIEW', 'slug' => 'PENDING-REVIEW', 'description' => 'El contenido está listo y el autor lo ha enviado para su aprobación'],
            ['id' => 3,'name' => 'REJECTED', 'slug' => 'REJECTED', 'description' => 'El moderador revisó el contenido y determino que necesita correcciones'],
            ['id' => 4,'name' => 'SCHEDULED', 'slug' => 'SCHEDULED', 'description' => 'Contenido con fecha de publicación futura'],
            ['id' => 5,'name' => 'PUBLISHED', 'slug' => 'PUBLISHED', 'description' => 'El Contenido es visible para todos los usuarios en la aplicación'],
            ['id' => 6,'name' => 'UNPUBLISHED', 'slug' => 'UNPUBLISHED', 'description' => 'El contenido fue publicado, pero fue retirado temporalmente'],
            ['id' => 7,'name' => 'DELETED', 'slug' => 'DELETED', 'description' => 'Contenido eliminado'],
        ];

        ContentStatus::upsert($contentStatus, ['id'], ['name', 'slug', 'description']);
    }
}
