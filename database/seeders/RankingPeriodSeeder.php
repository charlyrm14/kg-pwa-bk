<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\{
    PeriodType,
    RankingPeriod
};
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RankingPeriodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $weekly = PeriodType::where('slug', 'semanal')->first();
        $monthly = PeriodType::where('slug', 'mensual')->first();
        $annual = PeriodType::where('slug', 'anual')->first();

        $periods = [];


        $periods[] = [
            'period_type_id' => $weekly ? $weekly->id : 2,
            'start_date'     => $now->copy()->startOfWeek()->toDateString(),
            'end_date'       => $now->copy()->endOfWeek()->toDateString(),
            'calculated_at'  => null,
            'status'         => 'pending',
            'created_at'     => now(),
            'updated_at'     => now(),
        ];

        $periods[] = [
            'period_type_id' => $monthly ? $monthly->id : 3,
            'start_date'     => $now->copy()->startOfMonth()->toDateString(),
            'end_date'       => $now->copy()->endOfMonth()->toDateString(),
            'calculated_at'  => null,
            'status'         => 'pending',
            'created_at'     => now(),
            'updated_at'     => now(),
        ];

        $periods[] = [
            'period_type_id' => $annual ? $annual->id : 5,
            'start_date'     => $now->copy()->startOfYear()->toDateString(),
            'end_date'       => $now->copy()->endOfYear()->toDateString(),
            'calculated_at'  => null,
            'status'         => 'pending',
            'created_at'     => now(),
            'updated_at'     => now(),
        ];

        RankingPeriod::upsert(
            $periods,
            ['period_type_id', 'start_date', 'end_date'],
            ['status', 'calculated_at', 'updated_at']
        );
    }
}
