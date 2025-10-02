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
        Hobby::updateOrCreate(['slug' => 'ver-peliculas-series'], ['name' => 'Ver Películas/Series', 'slug' => 'ver-peliculas-series']);
        Hobby::updateOrCreate(['slug' => 'cocinar-hornear'], ['name' => 'Cocinar o Hornear', 'slug' => 'cocinar-hornear']);
        Hobby::updateOrCreate(['slug' => 'leer-libros'], ['name' => 'Leer Libros', 'slug' => 'leer-libros']);
        Hobby::updateOrCreate(['slug' => 'jugar-videojuegos'], ['name' => 'Jugar Videojuegos', 'slug' => 'jugar-videojuegos']);
        Hobby::updateOrCreate(['slug' => 'viajar-explorar'], ['name' => 'Viajar y Explorar', 'slug' => 'viajar-explorar']);
        Hobby::updateOrCreate(['slug' => 'fotografia'], ['name' => 'Fotografía', 'slug' => 'fotografia']);
        Hobby::updateOrCreate(['slug' => 'escuchar-musica'], ['name' => 'Escuchar Música', 'slug' => 'escuchar-musica']);
        Hobby::updateOrCreate(['slug' => 'tocar-instrumentos'], ['name' => 'Tocar Instrumentos', 'slug' => 'tocar-instrumentos']);
        Hobby::updateOrCreate(['slug' => 'hacer-yoga-meditar'], ['name' => 'Hacer Yoga o Meditar', 'slug' => 'hacer-yoga-meditar']);
        Hobby::updateOrCreate(['slug' => 'bailar'], ['name' => 'Bailar', 'slug' => 'bailar']);
        Hobby::updateOrCreate(['slug' => 'pintar-dibujar'], ['name' => 'Pintar y Dibujar', 'slug' => 'pintar-dibujar']);
        Hobby::updateOrCreate(['slug' => 'ir-a-la-playa'], ['name' => 'Ir a la Playa', 'slug' => 'ir-a-la-playa']);
        Hobby::updateOrCreate(['slug' => 'jugar-futbol'], ['name' => 'Jugar futbol', 'slug' => 'jugar-futbol']);
        Hobby::updateOrCreate(['slug' => 'correr-trotar'], ['name' => 'Correr o Trotar', 'slug' => 'correr-trotar']);
        Hobby::updateOrCreate(['slug' => 'jardineria'], ['name' => 'Jardinería', 'slug' => 'jardineria']);
        Hobby::updateOrCreate(['slug' => 'aprender-idiomas'], ['name' => 'Aprender Idiomas', 'slug' => 'aprender-idiomas']);
        Hobby::updateOrCreate(['slug' => 'pasear-mascotas'], ['name' => 'Pasear mascotas', 'slug' => 'pasear-mascotas']);
        Hobby::updateOrCreate(['slug' => 'andar-en-bicicleta'], ['name' => 'Andar en bicicleta', 'slug' => 'andar-en-bicicleta']);
        Hobby::updateOrCreate(['slug' => 'nadar'], ['name' => 'Nadar', 'slug' => 'nadar']);
        Hobby::updateOrCreate(['slug' => 'conciertos'], ['name' => 'Conciertos', 'slug' => 'conciertos']);
    }
}
