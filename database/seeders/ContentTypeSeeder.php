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
        ContentType::updateOrCreate(['slug' => 'news'], ['name' => 'News', 'slug' => 'news']);
        ContentType::updateOrCreate(['slug' => 'events'], ['name' => 'Events', 'slug' => 'events']);
        ContentType::updateOrCreate(['slug' => 'tips'], ['name' => 'Tips', 'slug' => 'tips']);
        ContentType::updateOrCreate(['slug' => 'nutrition'], ['name' => 'Nutrition', 'slug' => 'nutrition']);
    }
}
