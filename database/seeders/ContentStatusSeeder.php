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
        ContentStatus::updateOrCreate([
            'slug' => 'draft'
        ], [
            'name' => 'Draft', 
            'slug' => 'draft',
            'description' => 'El contenido está siendo creado'
        ]);

        ContentStatus::updateOrCreate([
            'slug' => 'pending-review'
        ], [
            'name' => 'Pending Review', 
            'slug' => 'pending-review',
            'description' => 'El contenido está listo y el autor lo ha enviado para su aprobación'
        ]);

        ContentStatus::updateOrCreate([
            'slug' => 'rejected'
        ], [
            'name' => 'Rejected', 
            'slug' => 'rejected',
            'description' => 'El moderador revisó el contenido y determino que necesita correcciones'
        ]);

        ContentStatus::updateOrCreate([
            'slug' => 'scheduled'
        ], [
            'name' => 'Scheduled', 
            'slug' => 'scheduled',
            'description' => 'Contenido con fecha de publicación futura'
        ]);

        ContentStatus::updateOrCreate([
            'slug' => 'published'
        ], [
            'name' => 'Published', 
            'slug' => 'published',
            'description' => 'Contenido es visible para todos los usuarios en la aplicación'
        ]);

        ContentStatus::updateOrCreate([
            'slug' => 'unpublished'
        ], [
            'name' => 'Unpublished', 
            'slug' => 'unpublished',
            'description' => 'El contenido fue publicado, pero fue retirado temporalmente'
        ]);

        ContentStatus::updateOrCreate([
            'slug' => 'deleted'
        ], [
            'name' => 'Deleted', 
            'slug' => 'deleted',
            'description' => 'Contenido eliminado'
        ]);
    }
}
