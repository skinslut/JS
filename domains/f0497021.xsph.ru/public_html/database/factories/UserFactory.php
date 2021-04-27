<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $groups = ["ПИ/б-17-1-о", "ИС/б-17-1-о", "ИС/б-17-2-о", "ИВТ/б-17-1-о", "УТС/б-17-1-о"];

        return [
            'name' => $this->faker->text(rand(6, 14)),
            'surname' => $this->faker->text(rand(6, 14)),
            'patronymic' => $this->faker->text(rand(6, 14)),
            'group' => $groups[array_rand($groups)],
            'email' => $this->faker->email,
            'password' => Hash::make($this->faker->text(rand(8, 25))),
            'remember_token' => Str::random(10),
            'role_id' => \App\Models\Role::getForStudent()
        ];
    }
}
