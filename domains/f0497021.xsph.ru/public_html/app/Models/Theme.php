<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Theme extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }
    public function tests(): HasMany
    {
        return $this->hasMany(Test::class);
    }
}
