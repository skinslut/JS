<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class RegistrationApplication extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function confirm()
    {
        User::create([
            'name' => $this->name,
            'surname' => $this->surname,
            'patronymic' => $this->patronymic,
            'email' => $this->email,
            'group' => $this->group,
            'password' => $this->password,
            'registration_application_id' => $this->id,
            'remember_token' => Str::random(10),
            'role_id' => Role::getForStudent()
        ]);

        $this->confirmed_at = now();
        $this->update();
    }

    public function setFioAttribute($fio)
    {
        preg_match('/^(?<surname>[\w]+) (?<name>[\w]+) (?<patronymic>[\w]+)$/u', $fio, $matches);

        $this->name = $matches['name'];
        $this->surname = $matches['surname'];
        $this->patronymic = $matches['patronymic'];
    }
}
