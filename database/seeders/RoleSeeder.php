<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['id' => 1, 'name' => 'ADMIN', 'slug' => 'ADMIN'],
            ['id' => 2, 'name' => 'TEACHER', 'slug' => 'TEACHER'],
            ['id' => 3, 'name' => 'STUDENT', 'slug' => 'STUDENT']
        ];

        Role::upsert($roles, ['id'], ['name', 'slug']);
    }
}
