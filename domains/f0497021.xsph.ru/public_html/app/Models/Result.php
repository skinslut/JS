<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Result extends Model
{
    use HasFactory;

    const STATUS_WAITED_CONFIRMATION = 0;
    const STATE_CONFIRMED = 1;
    const STATE_ERROR_QUESTION_LATE = 11;
    const STATE_ERROR_MANY_ATTEMPTS = 12;

    protected $guarded = [];

    public function tests(): BelongsToMany
    {
        return $this->belongsToMany(Test::class, ResultTests::class);
    }

    public function getDisplayStateAttribute()
    {
        switch ($this->state) {
            case self::STATUS_WAITED_CONFIRMATION: {
                return 'Ожидает подтверждения';
            }
            case self::STATE_CONFIRMED: {
                return 'Подтвержден';
            }
            case self::STATE_ERROR_QUESTION_LATE: {
                return 'Не завершен - истекло время';
            }
            case self::STATE_ERROR_MANY_ATTEMPTS: {
                return 'Не завершен - много перезагрузок страницы';
            }
        }
    }

    public function setRating($rating = null){
        $this->rating = $rating ? $rating : $this->rating;

        $this->update();
    }

    public function confirm()
    {
        $this->confirmed_at = now();
        $this->state = self::STATE_CONFIRMED;

        $this->update();
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
