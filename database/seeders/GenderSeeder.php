<?php

namespace Database\Seeders;

use App\Models\Gender;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Gender::updateOrCreate(['slug' => 'masculino'], ['name' => 'Masculino', 'slug' => 'masculino']);
        Gender::updateOrCreate(['slug' => 'femenino'], ['name' => 'Femenino', 'slug' => 'femenino']);
    }
}
