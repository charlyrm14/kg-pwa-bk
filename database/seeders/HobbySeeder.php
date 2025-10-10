<?php

namespace Database\Seeders;

use App\Models\Hobby;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HobbySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hobbies = [
            ['id' => 1, 'name' => 'Ver Películas/Series', 'slug' => 'ver-peliculas-series'],
            ['id' => 2, 'name' => 'Cocinar o Hornear', 'slug' => 'cocinar-hornear'],
            ['id' => 3, 'name' => 'Leer Libros', 'slug' => 'leer-libros'],
            ['id' => 4, 'name' => 'Jugar Videojuegos', 'slug' => 'jugar-videojuegos'],
            ['id' => 5, 'name' => 'Viajar y Explorar', 'slug' => 'viajar-explorar'],
            ['id' => 6, 'name' => 'Fotografía', 'slug' => 'fotografia'],
            ['id' => 7, 'name' => 'Escuchar Música', 'slug' => 'escuchar-musica'],
            ['id' => 8, 'name' => 'Tocar Instrumentos', 'slug' => 'tocar-instrumentos'],
            ['id' => 9, 'name' => 'Hacer Yoga o Meditar', 'slug' => 'hacer-yoga-meditar'],
            ['id' => 10, 'name' => 'Bailar', 'slug' => 'bailar'],
            ['id' => 11, 'name' => 'Pintar y Dibujar', 'slug' => 'pintar-dibujar'],
            ['id' => 12, 'name' => 'Ir a la Playa', 'slug' => 'ir-a-la-playa'],
            ['id' => 13, 'name' => 'Jugar futbol', 'slug' => 'jugar-futbol'],
            ['id' => 14, 'name' => 'Correr o Trotar', 'slug' => 'correr-trotar'],
            ['id' => 15, 'name' => 'Jardinería', 'slug' => 'jardineria'],
            ['id' => 16, 'name' => 'Aprender Idiomas', 'slug' => 'aprender-idiomas'],
            ['id' => 17, 'name' => 'Pasear mascotas', 'slug' => 'pasear-mascotas'],
            ['id' => 18, 'name' => 'Andar en bicicleta', 'slug' => 'andar-en-bicicleta'],
            ['id' => 19, 'name' => 'Nadar', 'slug' => 'nadar'],
            ['id' => 20, 'name' => 'Conciertos', 'slug' => 'conciertos'],
        ];

        Hobby::upsert($hobbies, ['id'], ['name', 'slug']);
    }
}
