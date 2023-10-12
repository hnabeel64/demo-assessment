<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role_permission = [
            [
                'role_id' => 2,
                'permission_id' => 1,
                'created_at' => now(),
            ],
            [
                'role_id' => 2,
                'permission_id' => 2,
                'created_at' => now(),
            ],
            [
                'role_id' => 2,
                'permission_id' => 3,
                'created_at' => now(),
            ],
            [
                'role_id' => 2,
                'permission_id' => 4,
                'created_at' => now(),
            ],
            [
                'role_id' => 2,
                'permission_id' => 8,
                'created_at' => now(),
            ],
            [
                'role_id' => 2,
                'permission_id' => 9,
                'created_at' => now(),
            ],
        ];
        DB::table('role_permission')->insert($role_permission);
    }
}
