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
            ['id' => 1, 'name' => 'Lunes'],
            ['id' => 2, 'name' => 'Martes'],
            ['id' => 3, 'name' => 'Miércoles'],
            ['id' => 4, 'name' => 'Jueves'],
            ['id' => 5, 'name' => 'Viernes'],
            ['id' => 6, 'name' => 'Sábado'],
            ['id' => 7, 'name' => 'Domingo'],
        ];

        Day::upsert($days, ['id'], ['name']);
    }
}
