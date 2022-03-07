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
        Role::create([
        'name' => 'admin',
        'guard_name' => 'web',
        'created_by' => 1,
        'deleted_by' => 0,
        'updated_by' => 0,

        ]);

        Role::create([
            'name' => 'user',
            'guard_name' => 'web',
            'created_by' => 1,
            'deleted_by' => 0,
            'updated_by' => 0,
            
        ]);
    }
}
