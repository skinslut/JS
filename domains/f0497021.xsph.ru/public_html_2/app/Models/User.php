<?php

namespace App\Models;

use App\TestsCore\Tests;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

/**
 * @property bool hasStartedOrNewTests
 */

class User extends Authenticatable
{
    use HasFactory, Notifiable;


    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setFioAttribute($fio)
    {
        preg_match('/^(?<surname>[\w]+) (?<name>[\w]+) (?<patronymic>[\w]+)$/u', $fio, $matches);

        $this->name = $matches['name'];
        $this->surname = $matches['surname'];
        $this->patronymic = $matches['patronymic'];
    }

    public function results(): HasMany
    {
        return $this->hasMany(Result::class, 'student_id');
    }

    public function tests(): HasMany
    {
        return $this->hasMany(Test::class, 'student_id');
    }

    public function getHasStartedOrNewTestsAttribute(): bool
    {
        return $this->tests()->where('state', Test::STATE_NEW)->whereOr('state', Test::STATE_STARTED)->exists();
    }
    public function getHasStartedTestAttribute(): bool
    {
        return $this->tests()->where('state', Test::STATE_STARTED)->exists();
    }

    public function getHasNewTestsAttribute(): bool
    {
        return $this->tests()->where('state', Test::STATE_NEW)->exists();
    }

    public function getHasBadTestsAttribute(): bool
    {
        return $this->tests()->where('state', Test::STATE_ERROR_MANY_ATTEMPTS)->exists();
    }

    public function getHasFinishedAllTestsAttribute(): bool
    {
        return !$this->tests()->where('state', Test::STATE_STARTED)->where('state', Test::STATE_NEW)->exists();
    }

    public function getHasActiveTestAttribute (): bool
    {
        return $this->activeTest()->exists();
    }


    public function hasUniqueQuestions($themeId): bool
    {
        return $this->getUniqueQuestions($themeId)->exists();
    }

    public function getActiveQuestionAttribute() {
        return $this->tests()->select('id')->whereState(Test::STATE_STARTED)->with(['testQuestion' => function ($query) {
            $query->whereState(TestQuestion::STATE_ACTIVE);
        }, 'testQuestion.question', 'testQuestion.question.testQuestion' => function ($query) {
            $query->whereState(TestQuestion::STATE_ACTIVE);
        }])->first()->testQuestion->question;
    }

    public function activeTest() {
        return $this->hasOne(Test::class, 'student_id')->whereState(Test::STATE_STARTED);
    }

    public function newTests() {
        return $this->hasOne(Test::class, 'student_id')->whereState(Test::STATE_NEW);
    }

    public function getCompletedQuestions(): Builder
    {
        $testId = $this->activeTest()->select('id')->first()->id;
        return Question::select('questions.*')->join('test_questions', function ($join) use ($testId) {
            $join->on('questions.id', '=', 'test_questions.question_id')
                ->where('test_questions.test_id', $testId)
                ->where('test_questions.state', TestQuestion::STATE_COMPLETE);
        });
    }
    public function getSkippedQuestions(): Builder
    {
        $testId = $this->activeTest()->select('id')->first()->id;
        return Question::select('questions.*')->join('test_questions', function ($join) use ($testId) {
            $join->on('questions.id', '=', 'test_questions.question_id')
                ->where('test_questions.test_id', $testId)
                ->where('test_questions.state', TestQuestion::STATE_SKIPPED)
                ->where('test_questions.state', TestQuestion::STATE_ERROR_LATE);
        });
    }

    public function getUniqueQuestions($themeId)
    {
        return Question::where('theme_id', $themeId)
            ->whereNotIn('id',
                Auth::user()->getCompletedQuestions()->select('questions.id')->get()
                    ->merge(Auth::user()->getSkippedQuestions()->select('questions.id')->get())
            );
    }

    public function waitedTests()
    {
        return $this->tests()->whereState(Test::STATE_WAITED);
    }
}
