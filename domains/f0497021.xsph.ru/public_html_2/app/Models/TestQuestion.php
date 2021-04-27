<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TestQuestion extends Model
{
    use HasFactory;

    protected $guarded = [];

    const STATE_ACTIVE = 0;
    const STATE_COMPLETE = 1;
    const STATE_SKIPPED = 3;
    const STATE_ERROR_LATE = 11;
    const STATE_ERROR_MANY_ATTEMPT = 12;


    public function setState(int $state)
    {
        $this->state = $state;
        $this->update();
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
