<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(RegistrationApplicationSeeder::class);
        $this->call(ThemeAndQuestionSeeder::class);
        $this->call(GroupSeeder::class);

        User::factory()->count(20)->create();
    }
}
