<?php

namespace Database\Seeders;

use App\Models\ContentType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contentType = [
            ['id' => 1, 'name' => 'Noticias', 'slug' => 'noticias'],
            ['id' => 2, 'name' => 'Eventos', 'slug' => 'eventos'],
            ['id' => 3, 'name' => 'Consejos', 'slug' => 'consejos'],
            ['id' => 4, 'name' => 'Nutrición', 'slug' => 'nutricion']
        ];
        
        ContentType::upsert($contentType, ['id'], ['name', 'slug']);
    }
}
