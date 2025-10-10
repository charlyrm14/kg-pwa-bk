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
        $gender = [
            ['id' => 1, 'name' => 'MASCULINO', 'slug' => 'MASCULINO'],
            ['id' => 2, 'name' => 'FEMENINO', 'slug' => 'FEMENINO']
        ];

        Gender::upsert($gender, ['id'], ['name', 'slug']);
    }
}
