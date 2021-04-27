<?php


namespace App\TestsCore;


use App\Models\Question;
use App\Models\Test;
use App\Models\TestQuestion;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class TestManipulator
{
    private Test $test;
    private int $countLateQuestions = 0;
    private int $countFinishedQuestions = 0;

    public function __construct()
    {
        $this->test = Auth::user()->activeTest()->with(['questions', 'questions.testQuestion', 'questions.theme'])->first();
        $this->countLateQuestions = $this->test->countLateQuestions;
        $this->countFinishedQuestions = $this->test->countFinishedQuestions;
    }

    /**
     * @return Question
     * @throws TestsException
     */
    public function getActiveQuestion()
    {
        $question = $this->test->activeQuestion;
        if ($question) {
            return $question;
        }

        throw new TestsException('', Tests::STATE_NOT_HAS_ACTIVE_QUESTION);
    }

    /**
     * @return Question
     * @throws TestsException
     */
    public function createNextQuestion(): Question
    {
        $questions = Auth::user()->getUniqueQuestions($this->test->theme_id)->inRandomOrder()->get();

        if ($questions->count() === 0) {
            throw new TestsException('', Tests::STATE_EMPTY_QUESTION);
        }

        $question = $questions[0];

        $this->test->questions()->attach($question, ['state' => TestQuestion::STATE_ACTIVE]);

        $sessionData = Session::get(Tests::SESSION_CONTAINER_NAME);
        $sessionData['start_time'] = now();

        Session::put(Tests::SESSION_CONTAINER_NAME, $sessionData);

        return $question;
    }

    public function finish()
    {
        $this->test->state = Test::STATE_WAITED;

        foreach ($this->test->questions as $question) {
            if ($question->testQuestion->is_valid) {
                $this->test->rating++;
            }
        }

        $this->test->update();
    }

    /**
     * @return Test
     */
    public function getTest(): Test
    {
        return $this->test;
    }

    public function getTimeQuestionStart(): Carbon
    {
        return Session::get(Tests::SESSION_CONTAINER_NAME)['start_time'];
    }

    public function questionIsLate(): bool
    {
        $questionStartTime = $this->getTimeQuestionStart();

        return $questionStartTime->addSeconds((Tests::QUESTION_LIMIT_MINUTES * 60 ) + 5) <= now();
    }

    public function finishActiveQuestion(string $answer): bool
    {
        $testQuestion = Auth::user()->activeQuestion->testQuestion;

        $testQuestion->state = TestQuestion::STATE_COMPLETE;
        $testQuestion->answer = $answer;
        $testQuestion->is_valid = $testQuestion->question->answer === $answer;

        return $testQuestion->update();
    }

    public function finishActiveQuestionWithError($stateCode)
    {
        $testQuestion = Auth::user()->activeQuestion->testQuestion;

        $testQuestion->state = $stateCode;

        return $testQuestion->update();
    }

    /**
     * @return int|mixed
     */
    public function getCountFinishedQuestions(): int
    {
        return $this->countFinishedQuestions;
    }

    /**
     * @return int|mixed
     */
    public function getCountLateQuestions(): int
    {
        return $this->countLateQuestions;
    }
}

