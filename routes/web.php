<?php

use Ampheris\ampController\Books;
use Ampheris\ampController\DiceGame;
use App\Models\Highscore;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route for the index page.
Route::get('/', function () {
    return view('index');
});

// Routes for the Dice game.
Route::get('/diceGame', [DiceGame::class, 'index']);
Route::post('/diceGame/updateSession', [DiceGame::class, 'updateSession']);

// Route that flushes the session values and redirects backt o the frontpage.
Route::get('/session', function () {
    session()->flush();
    return redirect('/');
});

// Route for the highscores, has database table directly connected to it in the Route.
Route::get('/highscore', function () {
    $dice21 = Highscore::find(1);

    return view('highscore', ['Dice21' => $dice21]);
});

// Route for the books, has a controller instead of a directly connected database table.
Route::get('/books', [Books::class, 'index']);
