<?php

namespace App\Http\Controllers;

use App\Facades\Tests;
use App\Models\Question;
use App\Models\Test;
use App\Models\TestQuestion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;


class TestsController extends Controller
{
    public function index(): RedirectResponse
    {
        Tests::startRound();

        return redirect()->route('test.start');
    }

    public function test()
    {

        $question = null;

        if (Tests::getAttemptCount() >= 3) {
            Tests::finishRoundWithError(Test::STATE_ERROR_MANY_ATTEMPTS);

            return redirect()->route('home');

        } elseif (Tests::allowedCreateNewQuestion()) {
            $question = Tests::createQuestion();

        } elseif (Tests::hasActiveQuestion()) {
            Tests::skipActiveQuestion();
            $question = Tests::createQuestion();
            Tests::updateAttemptCounter();

        } elseif (Tests::allowedStartNextTest()) {
            Tests::finishActiveTest();
            Tests::startNextTest();

            return redirect()->route(Route::currentRouteName());

        } else {
            Tests::finishActiveTest();
            Tests::finishRound();

            return redirect()->route('home');
        }

        return view('tests.index')->with(compact([
            'question'
        ]));
    }

    public function answer(Request $request, Question $question): RedirectResponse
    {
        $testManipulator = Tests::getTestManipulator();

        if ($testManipulator->questionIsLate() or !$request->has('SUBMITTED')) {
            $testManipulator->finishActiveQuestionWithError(TestQuestion::STATE_ERROR_LATE);
        } else {
            $testManipulator->finishActiveQuestion($request->answer);
        }

        Session::put('redirected-from-answer', true);

        return redirect()->route('test.start')->with('redirected', true);
    }
}
