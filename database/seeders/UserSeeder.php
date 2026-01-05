<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Carlos I',
                'last_name' => 'Ramos',
                'mother_last_name' => null,
                'email' => 'charlyrm14@gmail.com',
                'uuid' => '771f8eb5-a52e-40e4-af21-af947bf76048',
                'student_code' => null,
                'role_id' => 1,
            ],
            [
                // Usuario IA del sistema
                'name' => 'AI',
                'last_name' => 'Assistant',
                'mother_last_name' => null,
                'email' => 'aiassistant@kg-dreams.com',
                'uuid' => 'd0773c98-ae77-49ad-8464-96d5b2ec0715',
                'student_code' => null,
                'role_id' => 2,
            ],
            [
                'name' => 'Virginia',
                'last_name' => 'Morales',
                'mother_last_name' => null,
                'email' => 'gusi_allison@gmail.com',
                'uuid' => '9a0b431d-e720-4231-9b90-5d46d5ee280d',
                'student_code' => null,
                'role_id' => 1,
            ],
            [
                'name' => 'Gregorio',
                'last_name' => 'Morales',
                'mother_last_name' => null,
                'email' => 'gmoraleskg@gmail.com',
                'uuid' => '6364579a-3820-4d5e-9845-fef582d70d27',
                'student_code' => null,
                'role_id' => 2,
            ],
            [
                'name' => 'Valentina E',
                'last_name' => 'Hérnandez',
                'mother_last_name' => null,
                'email' => 'vhernandezkg@gmail.com',
                'uuid' => '4f507188-2b7e-4263-9e06-dcb01ea9c0e4',
                'student_code' => 'STU-20251013-8656',
                'role_id' => 3,
            ],
            [
                'name' => 'Héctor A',
                'last_name' => 'Hérnandez',
                'mother_last_name' => null,
                'email' => 'handrekg@gmail.com',
                'uuid' => 'ab310b2d-aee4-4f20-945b-a4f38acb76c4',
                'student_code' => 'STU-20251013-2061',
                'role_id' => 3,
            ]
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(
                [
                    'email' => $userData['email']
                ],
                [
                    'name' => $userData['name'],
                    'last_name' => $userData['last_name'],
                    'mother_last_name' => $userData['mother_last_name'],
                    'password' => Str::random(12),
                    'force_password_change' => false,
                    'uuid' => $userData['uuid'],
                    'student_code' => $userData['student_code'],
                    'role_id' => $userData['role_id'],
                    'remember_token' => null,
                    'email_verified_at' => null,
                ]
            );
        }
    }
}
