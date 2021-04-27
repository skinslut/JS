<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Question extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'answers' => 'array'
    ];

    public function theme(): BelongsTo
    {
        return $this->belongsTo(Theme::class);
    }

    public function tests(): HasManyThrough
    {
        return $this->hasManyThrough(TestQuestion::class, Test::class);
    }

    public function testQuestion(): HasOne
    {
        return $this->hasOne(TestQuestion::class, 'question_id');
    }
}
