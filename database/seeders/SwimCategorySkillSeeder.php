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
            ['category_id' => 1, 'skill_id' => 1],
            ['category_id' => 1, 'skill_id' => 2],
            ['category_id' => 1, 'skill_id' => 3],

            ['category_id' => 2, 'skill_id' => 4],
            ['category_id' => 2, 'skill_id' => 5],
            ['category_id' => 2, 'skill_id' => 6],

            ['category_id' => 3, 'skill_id' => 7],
            ['category_id' => 3, 'skill_id' => 8],
            ['category_id' => 3, 'skill_id' => 9],

            ['category_id' => 4, 'skill_id' => 10],
            ['category_id' => 4, 'skill_id' => 11],
            ['category_id' => 4, 'skill_id' => 12],

            ['category_id' => 5, 'skill_id' => 13],
            ['category_id' => 5, 'skill_id' => 14],
            ['category_id' => 5, 'skill_id' => 15],
        ];

        foreach ($categorySkills as $data) {
            SwimCategorySkill::updateOrCreate(
                [
                    'swim_category_id' => $data['category_id'],
                    'skill_id' => $data['skill_id'],
                ]
            );
        }
    }
}
