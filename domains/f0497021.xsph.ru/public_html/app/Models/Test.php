<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;

class Test extends Model
{
    use HasFactory;

    const STATE_NEW = 0;
    const STATE_STARTED = 1;
    const STATE_WAITED = 3;
    const STATE_COMPLETED = 4;
    const STATE_STOPPED = 5;
    const STATE_ERROR_LATE_QUESTION = 12;
    const STATE_ERROR_MANY_ATTEMPTS = 11;

    protected $guarded = [];

    public static function prepareTests(): array
    {
        $user = Auth::user();
        $themes = Theme::select(['id'])->get();
        $tests = [];

        foreach ($themes as $theme) {
            $test = Test::make();

            $test->state = self::STATE_NEW;
            $test->student()->associate($user);
            $test->theme()->associate($theme);

            $test->save();
            $tests[] = $test;
        }



        return $tests;
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function theme(): BelongsTo
    {
        return $this->belongsTo(Theme::class);
    }

    public function questions(): BelongsToMany
    {
        return $this->belongsToMany(Question::class, TestQuestion::class);
    }

    public function testQuestion(): HasOne
    {
        return $this->hasOne(TestQuestion::class);
    }
    public function testQuestions(): HasMany
    {
        return $this->hasMany(TestQuestion::class);
    }

    public function completedTestQuestions()
    {
        return $this->hasMany(TestQuestion::class)->whereState(TestQuestion::STATE_COMPLETE);
    }

    public function getHasActiveQuestionAttribute()
    {
        return $this->testQuestions()->whereState(TestQuestion::STATE_ACTIVE)->exists();
    }

    public function getCountLateQuestionsAttribute()
    {
        return $this->testQuestions()->whereState(TestQuestion::STATE_ERROR_LATE)->count();
    }
    public function getCountFinishedQuestionsAttribute()
    {
        return $this->testQuestions()->whereIn('state', [TestQuestion::STATE_COMPLETE, TestQuestion::STATE_ERROR_LATE])->count();
    }

    public function getActiveQuestionAttribute()
    {
        return $this->testQuestion()->whereState(TestQuestion::STATE_ACTIVE)->with('question')->first()->question;
    }

    public function getActiveTestQuestionAttribute()
    {
        return $this->testQuestion()->whereState(TestQuestion::STATE_ACTIVE)->first();
    }
}
