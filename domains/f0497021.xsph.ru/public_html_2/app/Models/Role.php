<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function getForAdmin(): int {
        return Role::select('id')->whereName('ADMIN')->first()->id;
    }
    public static function getForStudent(): int {
        return Role::select('id')->whereName('STUDENT')->first()->id;
    }
    public static function getForTeacher(): int {
        return Role::select('id')->whereName('TEACHER')->first()->id;
    }

    public $timestamps = false;
}
