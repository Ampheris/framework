<?php

declare(strict_types=1);

namespace Ampheris\ampController;

use Illuminate\Http\Request;
use function Ampheris\Functions\{commandCheck};

/**
 * Controller for the dice game routes.
 */
class DiceGame
{
    public function index()
    {
        return view('diceGame');
    }


    public function updateSession(Request $request)
    {
        commandCheck($request->input('command'), $request);
        return redirect('/diceGame');
    }
}
