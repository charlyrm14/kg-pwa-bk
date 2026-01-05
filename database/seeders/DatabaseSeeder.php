<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            GenderSeeder::class,
            HobbySeeder::class,
            ContentTypeSeeder::class,
            ContentStatusSeeder::class,
            SwimCategorySeeder::class,
            SkillSeeder::class,
            SwimCategorySeeder::class,
            SwimCategorySkillSeeder::class,
            ProgressStatusSeeder::class,
            ChatTypeSeeder::class,
            SenderTypeSeeder::class,
            AttendanceStatusSeeder::class,
            DaySeeder::class,
            AchievementFrequencySeeder::class,
            AchievementStatusSeeder::class,
            AchievementSeeder::class,
            NotificationTypeSeeder::class,
            PaymentTypeSeeder::class,
            PeriodTypeSeeder::class,
            UserSeeder::class,
        ]);
    }
}
