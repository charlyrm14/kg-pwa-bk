<?php

namespace Database\Seeders;

use App\Models\SwimCategorySkill;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SwimCategorySkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categorySkills = [
            ['category_id' => 1, 'skill_id' => 1, 'percentage' => 20],
            ['category_id' => 1, 'skill_id' => 2, 'percentage' => 20],
            ['category_id' => 1, 'skill_id' => 3, 'percentage' => 20],

            ['category_id' => 2, 'skill_id' => 4, 'percentage' => 40],
            ['category_id' => 2, 'skill_id' => 5, 'percentage' => 40],
            ['category_id' => 2, 'skill_id' => 6, 'percentage' => 40],

            ['category_id' => 3, 'skill_id' => 7, 'percentage' => 60],
            ['category_id' => 3, 'skill_id' => 8, 'percentage' => 60],
            ['category_id' => 3, 'skill_id' => 9, 'percentage' => 60],

            ['category_id' => 4, 'skill_id' => 10, 'percentage' => 80],
            ['category_id' => 4, 'skill_id' => 11, 'percentage' => 80],
            ['category_id' => 4, 'skill_id' => 12, 'percentage' => 80],

            ['category_id' => 5, 'skill_id' => 13, 'percentage' => 100],
            ['category_id' => 5, 'skill_id' => 14, 'percentage' => 100],
            ['category_id' => 5, 'skill_id' => 15, 'percentage' => 100],
        ];

        foreach ($categorySkills as $data) {
            SwimCategorySkill::updateOrCreate(
                [
                    'swim_category_id' => $data['category_id'],
                    'skill_id' => $data['skill_id'],
                ],
                [
                    'percentage' => $data['percentage']
                ]
            );
        }
    }
}
