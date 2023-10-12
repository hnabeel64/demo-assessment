<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permission = [
            ['name' => 'can_add_user'],
            ['name' => 'can_edit_user'],
            ['name' => 'can_delete_user'],
            ['name' => 'can_view_user'],
            ['name' => 'can_add_domain'],
            ['name' => 'can_edit_domain'],
            ['name' => 'can_delete_domain'],
            ['name' => 'can_view_domain'],
            ['name' => 'can_assign_domain'],
        ];
        foreach ($permission as $key => $value) {
            Permission::create($value);
        }
    }
}
