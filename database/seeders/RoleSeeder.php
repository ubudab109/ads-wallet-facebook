<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::insert([
            ['name' => 'superadmin', 'guard_name' => 'web'],
            ['name' => 'member', 'guard_name' => 'web'],
        ]);
    }
}
