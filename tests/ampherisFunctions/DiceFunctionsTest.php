<?php


namespace Tests\ampherisFunctions;

use Ampheris\Dice\DiceHand;
use Illuminate\Http\Request;
use Tests\TestCase;
use function Ampheris\Functions\{commandCheck, generateHTML};

/**
 * Test cases for the functions in src/diceFunctions.php.
 */
class DiceFunctionsTest extends TestCase
{
    /**
     * Init function for the dice game.
     */
    public function initSession()
    {
        // Session values
        $userInit = new DiceHand();
        $computer = new DiceHand();


        session(['gameIsInitiated' => false]);
        session(['gameUser' => $userInit]);
        session(['gameUserScore' => 0]);
        session(['gameWinner' => 'None']);
        session(['gameComputer' => $computer]);
        session(['gameIsInitiated' => false]);
        session(['gameGameRounds' => 0]);
        session(['gameDiceThrown' => false]);
        session(['gameComputerScore' => 0]);

        $request = new Request([
            'number' => 3
        ]);

        commandCheck('setDices', $request);
    }

    /**
     * Test the function updateUserDices()
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testUpdateUserDices()
    {
        session_start();

        $this->initSession();

        $expected = true;
        $actual = session()->get('gameIsInitiated');
        $this->assertEquals($expected, $actual);

        session()->flush();

    }

    /**
     * Test the function throwYourDices()
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testThrowYourDices()
    {
        session_start();

        $this->initSession();

        $expected = true;

        $request = new Request([
            'number' => 3
        ]);

        commandCheck('throw', $request);

        $actual = session()->get('gameDiceThrown');
        $this->assertEquals($expected, $actual);

        $expected = 0;
        $actual = session()->get('gameUserScore');
        $this->assertGreaterThan($expected, $actual);

        session()->flush();
    }

    /**
     * Test the function generateHTML()
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testGenerateHTML()
    {
        session_start();
        $this->initSession();

        $request = new Request([
            'number' => 3
        ]);

        commandCheck('throw', $request);

        $user = session()->get('gameUser');
        $actual = generateHTML($user);

        $this->assertNotEmpty($actual);

        session()->flush();
    }

    /**
     * Test the function checkScore()
     * Will not be 100% due to the fact that i cant know who the winner will be,
     * so will only check if the winner is not None and not if the winner can be
     * set to computer, player and NoWinner.
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testCheckScore()
    {
        session_start();
        $this->initSession();

        $request = new Request([
            'number' => 3
        ]);

        commandCheck('throw', $request);
        commandCheck('stop', $request);

        $actual = session()->get('gameWinner');
        $this->assertNotEquals('None', $actual);

        session()->flush();
    }

    /**
     * Test the function computersTurn()
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testComputersTurn()
    {
        session_start();
        $this->initSession();

        $request = new Request([
            'number' => 3
        ]);

        commandCheck('throw', $request);
        commandCheck('stop', $request);

        $actual = session()->get('gameComputerScore');

        $this->assertGreaterThan(0, $actual);

        session()->flush();
    }
}
