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
            ['id' => 1, 'name' => 'NEWS', 'slug' => 'NEWS'],
            ['id' => 2, 'name' => 'EVENTS', 'slug' => 'EVENTS'],
            ['id' => 3, 'name' => 'TIPS', 'slug' => 'TIPS'],
            ['id' => 4, 'name' => 'NUTRITION', 'slug' => 'NUTRITION']
        ];
        
        ContentType::upsert($contentType, ['id'], ['name', 'slug']);
    }
}
