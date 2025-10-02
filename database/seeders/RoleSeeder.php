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
        Role::updateOrCreate(['slug' => 'admin'], ['name' => 'Admin', 'slug' => 'admin']);
        Role::updateOrCreate(['slug' => 'teacher'], ['name' => 'Teacher', 'slug' => 'teacher']);
        Role::updateOrCreate(['slug' => 'student'], ['name' => 'Admin', 'slug' => 'student']);
    }
}
