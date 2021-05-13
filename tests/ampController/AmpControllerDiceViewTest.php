<?php

declare(strict_types=1);

namespace Tests\ampController;


use Ampheris\ampController\DiceGame;
use Tests\TestCase;
use Illuminate\Http\Request;


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

//    /**
//     * Check that the controller returns a response.
//     * @preserveGlobalState disabled
//     */
//    public function testControllerReturnsResponse()
//    {
//        $controller = new DiceGame();
//
//        $exp = "Illuminate\View\View";
//        $res = $controller->index();
//        $this->assertInstanceOf($exp, $res);
//    }

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
