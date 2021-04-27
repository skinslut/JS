<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::create([
            'name' => 'Admin',
            'surname' => 'Admin',
            'patronymic' => 'Admin',
            'email' => 'admin@email.ru',
            'group' => '',
            'password' => Hash::make('qwert12345'),
            'remember_token' => Str::random(10),
            'role_id' => \App\Models\Role::getForAdmin()
        ]);
        \App\Models\User::create([
            'name' => 'Андрей',
            'surname' => 'Забаштанский',
            'patronymic' => 'Константинович',
            'email' => 'teacher@email.ru',
            'group' => '',
            'password' => Hash::make('qwert12345'),
            'remember_token' => Str::random(10),
            'role_id' => \App\Models\Role::getForTeacher()
        ]);
    }
}
