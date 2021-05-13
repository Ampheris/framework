<?php

declare(strict_types=1);

namespace Ampheris\Functions;

use Ampheris\Dice\DiceHand;
use Illuminate\Http\Request;

/**
 * Functions.
 * @param string $command
 * @param Request $request
 */
function commandCheck(string $command, Request $request)
{

    /** @var DiceHand $user */
    $user = session()->get('gameUser');

    /** @var DiceHand $computer */
    $computer = session()->get('gameComputer');

    switch ($command) {
        case 'setDices':
            $number = intval($request->input('number'));
            updateUserDices($number, $user);
            break;
        case 'throw':
            throwYourDices($user);
            break;
        case 'stop':
            computersTurn($computer);
            checkScore();
            break;
        case 'restart':
            resetGame();
            session(['gameUser' => new DiceHand()]);
            session(['gameComputer' => new DiceHand()]);
            break;
    }
}

/**
 * @param int $number
 * @param DiceHand $user
 */
function updateUserDices(int $number, DiceHand $user)
{
    session(['gameIsInitiated' => true]);
    $user->initDices(intval($number));
}

/**
 * @param DiceHand $user
 */
function throwYourDices(DiceHand $user)
{
    session(['gameDiceThrown' => true]);
    $user->rollAllDices();
    $user_score = session()->get('gameUserScore');
    session(['gameUserScore' => $user_score + $user->getAllRolledValues()]);
}

/**
 * @param DiceHand $user
 */

function generateHTML(DiceHand $user): string
{
    $arrList = $user->getGraphicDices();
    $result = '';

    foreach ($arrList as $dice) {
        $result .= '<i class="dice-sprite ' . $dice . '"></i>';
    }
    return $result;
}

function checkScore()
{

    $userScore = session()->get('gameUserScore');
    $computerScore = session()->get('gameComputerScore');

    if ($userScore == 21 or ($userScore < 21 and $computerScore > 21)) {
        session(['gameWinner' => 'User']);
    }

    // If computer has score 21 it wins, even if user got 21 in score.
    if ($computerScore == 21) {
        session(['gameWinner' => 'Computer']);
    }

    if ($computerScore > 21 and $userScore > 21) {
        session(['gameWinner' => 'NoWinner']);
    }
}

function resetGame()
{
    session()->increment('gameGameRounds');
    session(['gameUserScore' => 0]);
    session(['gameComputerScore' => 0]);
    session(['gameIsInitiated' => false]);
    session(['gameWinner' => 'None']);
    session(['gameDiceThrown' => false]);

    /*$_SESSION['game']['gameRounds'] += 1;
    $_SESSION['game']['userScore'] = 0;
    $_SESSION['game']['computerScore'] = 0;
    $_SESSION['game']['isInitiated'] = false;
    $_SESSION['game']['winner'] = 'None';
    $_SESSION['game']['diceThrown'] = false;*/
}

/**
 * @param DiceHand $computer
 */
function computersTurn(DiceHand $computer)
{

    //Init computer with 1 dice
    $computer->initDices(1);

    // Run while computer is not stopped.
    while (true) {
        $computerScore = session()->get('gameComputerScore');

        if ($computerScore < 21) {
            $computer->rollAllDices();
            session(['gameComputerScore' => $computerScore + $computer->getAllRolledValues()]);
        }

        if ($computerScore > 21 or $computerScore == 21) {
            break;
        }
    }
}
