<?php

namespace Database\Seeders;

use App\Models\AchievementFrequency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AchievementFrequencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $frequencies = [
            ['id' => 1, 'name' => 'ONE_TIME', 'description' => 'El logro solo se puede obtener una única vez.'],
            ['id' => 2, 'name' => 'DAILY', 'description' => 'El logro se puede repetir o restablecer cada día.'],
            ['id' => 3, 'name' => 'WEEKLY', 'description' => 'El logro se puede repetir o restablecer cada semana.'],
            ['id' => 4, 'name' => 'MONTHLY', 'description' => 'El logro se puede repetir o restablecer cada mes.'],
            ['id' => 5, 'name' => 'SEASONAL', 'description' => 'El logro está ligado a un evento o temporada específica.'],
        ];

        AchievementFrequency::upsert($frequencies, ['id'], ['name', 'description']);
    }
}
