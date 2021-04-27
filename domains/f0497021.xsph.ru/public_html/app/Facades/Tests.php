<?php


namespace App\Facades;


use App\TestsCore\TestManipulator;
use Illuminate\Support\Facades\Facade;

/**
 * Class Tests
 * @package App\Facades
 *
 * @method static TestManipulator getTestManipulator
 * @method static finishActiveTest
 * @method static startNextTest
 * @method static getActiveQuestion
 * @method static createQuestion
 * @method static startRound
 * @method static finishRound
 * @method static updateAttemptCounter
 * @method static skipActiveQuestion
 * @method static finishRoundWithError(int $testError)
 *
 * @method static bool finishActiveQuestion(string $answer)
 *
 * @method static bool allowedStartNextTest
 * @method static bool hasActiveQuestion
 * @method static bool allowedCreateNewQuestion
 * @method static int getAttemptCount
 */

class Tests extends Facade
{

    protected static function getFacadeAccessor(): string
    {
        return 'Tests';
    }
}
