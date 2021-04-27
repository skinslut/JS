<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RegistrationApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\RegistrationApplication::create([
            'name' => 'Стефанов',
            'surname' => 'Александр',
            'patronymic' => 'Эдуардович',
            'email' => 'i.am.alex2k@mail.ru',
            'group' => 'ИС/б-17-1-о',
            'password' => Hash::make('qwert12345'),
        ])->confirm();
    }
}
