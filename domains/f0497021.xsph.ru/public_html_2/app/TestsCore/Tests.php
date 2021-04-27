<?php

namespace App\TestsCore;



use App\Models\Question;
use App\Models\Result;
use App\Models\Test;
use App\Models\TestQuestion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class Tests
{
    const SESSION_CONTAINER_NAME = 'js-test';
    const MAX_QUESTIONS_IN_TEST = 5;
    const STATE_EMPTY_QUESTION = 10;
    const STATE_NOT_HAS_ACTIVE_QUESTION = 11;
    const QUESTION_LIMIT_MINUTES = 2;
    const RELOAD_ATTEMPT = 3;

    private TestManipulator $testManipulator;
    private bool $userCompletedAllTest = false;
    private int $attemptCount = 0;

    public function __construct()
    {
        $user = Auth::user();
        $userHasNewTests = $user->hasNewTests;
        $userIsFinishedAllTests = $user->hasFinishedAllTests;
        $userHasActiveTest = $user->hasActiveTest;

        if ($userHasNewTests or $userHasActiveTest) {
            $this->testManipulator = new TestManipulator();

            if (!Session::has('redirected-from-answer')) {
                $this->attemptCount = Session::get(self::SESSION_CONTAINER_NAME)['attempt_count'] ?? 0;
            }

            Session::remove('redirected-from-answer');

        } else if ($userIsFinishedAllTests) {
            $this->userCompletedAllTest = true;

            if (Session::has(self::SESSION_CONTAINER_NAME)) {
                Session::remove(self::SESSION_CONTAINER_NAME);
            }
        }
    }

    public function startRound()
    {
        $firstTest = Test::prepareTests()[0];


        $firstTest->state = Test::STATE_STARTED;
        $firstTest->update();

        Session::put(Tests::SESSION_CONTAINER_NAME, ['attempt_count' => 0]);
    }

    public function startNextTest()
    {
        $nextTest = Auth::user()->newTests()->first();

        $nextTest->state = Test::STATE_STARTED;
        $nextTest->update();

        return $nextTest;
    }

    public function userIsCompletedAllTests(): bool
    {
        return $this->userCompletedAllTest;
    }

    public function allowedCreateNewQuestion(): bool
    {
        $user = Auth::user();

        return ((!$user->activeTest->hasActiveQuestion)
            and $user->hasStartedTest
            and $user->hasUniqueQuestions($this->testManipulator->getTest()->theme->id)
            and $this->getTestManipulator()->getCountFinishedQuestions() < self::MAX_QUESTIONS_IN_TEST);
    }
    public function hasActiveQuestion(): bool
    {
        return Auth::user()->activeTest->hasActiveQuestion;
    }

    public function allowedStartNextTest(): bool
    {
        $user = Auth::user();

        return $user->hasActiveTest and $user->hasNewTests;
    }

    public function finishRound()
    {
        $tests = Auth::user()->waitedTests()->with('testQuestion')->get();
        $result = Result::make(['state' => Result::STATUS_WAITED_CONFIRMATION]);
        $countValidAnswers = 0;

        $result->student()->associate(Auth::user());
        $result->save();
        $result->tests()->attach($tests);

        Auth::user()->waitedTests()->update([
            'state' => Test::STATE_COMPLETED
        ]);

        foreach ($tests as $test) {
            $countValidAnswers += $test->rating;
        }
        $result->rating = $countValidAnswers;


        $result->confirm();

        Session::remove(self::SESSION_CONTAINER_NAME);
    }


    public function finishActiveQuestion(string $answer): bool
    {
        return $this->testManipulator->finishActiveQuestion($answer);
    }

    public function finishRoundWithError(int $testError)
    {
        $tests = Auth::user()->waitedTests()->get();
        $result = Result::make(['state' => $testError === Test::STATE_ERROR_MANY_ATTEMPTS ? Result::STATE_ERROR_MANY_ATTEMPTS : Result::STATE_ERROR_QUESTION_LATE]);

        $result->student()->associate(Auth::user());
        $result->save();
        $result->tests()->attach($tests);


        Auth::user()->newTests()->update([
            'state' => Test::STATE_STOPPED
        ]);

        $this->testManipulator->getTest()->update(['state' => $testError]);

        if ($testError === Test::STATE_ERROR_MANY_ATTEMPTS) {
            $this->testManipulator->getTest()->activeTestQuestion->update(['state' => TestQuestion::STATE_ERROR_MANY_ATTEMPT]);
        }

        Session::remove(self::SESSION_CONTAINER_NAME);
    }

    public function skipActiveQuestion()
    {
        $this->testManipulator->getTest()->activeTestQuestion->update(['state' => TestQuestion::STATE_SKIPPED]);
    }

    public function updateAttemptCounter()
    {
        $sessionData = Session::get(Tests::SESSION_CONTAINER_NAME);
        $sessionData['attempt_count']++;
        Session::put(Tests::SESSION_CONTAINER_NAME, $sessionData);

        $this->attemptCount = $sessionData['attempt_count'];

        return $this->attemptCount;
    }

    /**
     * @return TestManipulator
     */
    public function getTestManipulator(): TestManipulator
    {
        return $this->testManipulator;
    }

    /**
     * @return int|mixed
     */
    public function getAttemptCount(): int
    {
        return $this->attemptCount;
    }

    /**
     * @return Question
     * @throws TestsException
     */
    public function createQuestion(): Question
    {
        return $this->testManipulator->createNextQuestion();
    }

    /**
     * @return Question
     * @throws TestsException
     */
    public function getActiveQuestion(): Question
    {
        return $this->testManipulator->getActiveQuestion();
    }

    public function finishActiveTest()
    {
        $this->testManipulator->finish();
    }
}
