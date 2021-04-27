<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleNames = ['TEACHER', 'STUDENT', 'ADMIN'];

        foreach ($roleNames as $name) {
            \App\Models\Role::create(['name' => $name]);
        }
    }
}
