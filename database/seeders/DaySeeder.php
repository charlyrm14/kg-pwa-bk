<?php

namespace Database\Seeders;

use App\Models\Day;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $days = [
            ['id' => 1, 'name' => 'LUNES'],
            ['id' => 2, 'name' => 'MARTES'],
            ['id' => 3, 'name' => 'MIÉRCOLES'],
            ['id' => 4, 'name' => 'JUEVES'],
            ['id' => 5, 'name' => 'VIERNES'],
            ['id' => 6, 'name' => 'SÁBADO'],
            ['id' => 7, 'name' => 'DOMINGO'],
        ];

        Day::upsert($days, ['id'], ['name']);
    }
}
