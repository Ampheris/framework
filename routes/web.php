<?php

use Ampheris\ampController\Books;
use Ampheris\ampController\DiceGame;
use Illuminate\Support\Facades\Route;
use App\Models\Highscore;

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

Route::get('/', function () {
    return view('index');
});

Route::get('/diceGame', [DiceGame::class, 'index']);
Route::post('/diceGame/updateSession', [DiceGame::class, 'updateSession']);

Route::get('/session', function () {
   session()->flush();
   return redirect('/');
});

Route::get('/highscore', function () {
    $dice21 = Highscore::find(1);

    return view('highscore', ['Dice21' => $dice21]);
});

Route::get('/books', [Books::class, 'index']);
