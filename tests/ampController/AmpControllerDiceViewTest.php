<?php

declare(strict_types=1);

namespace Tests\ampController;

use Ampheris\ampController\DiceGame;
use Illuminate\Http\Request;
use Tests\TestCase;

/**
 * Test cases for the controller Dice view.
 */
class AmpControllerDiceViewTest extends TestCase
{
    /**
     * Try to create the controller class.
     * @preserveGlobalState disabled
     */
    public function testCreateTheControllerClass()
    {
        $controller = new DiceGame();
        $this->assertInstanceOf("\Ampheris\ampController\DiceGame", $controller);
    }


    /**
     * Check that the controller returns correct response.
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testControllerUpdateReturnsResponse()
    {
        $controller = new DiceGame();
        $request = new Request([
            'command' => 'restart'
        ]);

        $exp = "Illuminate\Http\RedirectResponse";
        $res = $controller->updateSession($request);
        $this->assertInstanceOf($exp, $res);
    }
}
