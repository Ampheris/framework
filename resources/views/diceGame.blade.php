@extends('base')

<?php
namespace Ampheris\Dice;


use function Ampheris\Functions\generateHTML;

// Session values
$userInit = new DiceHand();
$computer = new DiceHand();


if (session()->missing('gameUser')) {
    session(['gameIsInitiated' => false]);
    session(['gameUser' => $userInit]);
    session(['gameUserScore' => 0]);
    session(['gameWinner' => 'None']);
    session(['gameComputer' => $computer]);
    session(['gameIsInitiated' => false]);
    session(['gameGameRounds' => 0]);
    session(['gameDiceThrown' => false]);
    session(['gameComputerScore' => 0]);
}

/*$_SESSION['game'] = $_SESSION['game'] ?? [
        'isInitiated' => false,
        'user' => serialize($userInit),
        'userScore' => 0,
        'winner' => 'None',
        'computer' => serialize($computer),
        'computerScore' => 0,
        'gameRounds' => 0,
        'diceThrown' => false
    ];*/

/**
 * @param DiceHand $user
 */
$user = session()->get('gameUser');

?>
@section('content')
    <h1>Dice 21 Game, round <?= session()->get('gameGameRounds'); ?></h1>
    <?php if (session()->get('gameIsInitiated') == false) { ?>
        <h2>Choose 1 or 2 dices</h2>
        <button class="num-dices" value="1">One dice</button>
        <button class="num-dices" value="2">Two dices</button>
    <?php } ?>

    <?php if (session()->get('gameWinner') == 'None') { ?>
    <h2>Throw your dice/dices!</h2>
    <?php if (session()->get('gameDiceThrown') == true) { ?>
    <p>Dice(s) thrown:</p>
    <p>
        <?= generateHTML($user); ?>
    </p>
    <?php } ?>
    <p>Your current score: <?= session()->get('gameUserScore'); ?></p>
    <button id="throw-dices">Throw dice/dices</button>
    <button id="stop">Stop</button>
    <?php } ?>

    <?php if (session()->get('gameWinner') != 'None') { ?>
    <h2>Game completed!</h2>
    <p>Your score: <?= session()->get('gameUserScore') ?></p>
    <p>Computers score: <?= session()->get('gameComputerScore') ?></p>
    <?php if (session()->get('gameWinner')  == 'User') { ?>
    <p>Congratulations, you have won the round!</p>
    <?php } elseif (session()->get('gameWinner')  == 'Computer') { ?>
    <p>Sorry, the computer have won the round!</p>
    <?php } elseif (session()->get('gameWinner')  == 'NoWinner') { ?>
    <p>Sorry, no one has won the round!</p>
    <?php } ?>
    <button id="restart">Restart</button>
    <?php } ?>

    <script type="text/javascript">
        $('.num-dices').click(function () {
            const num = $(this).val();

            $.ajax({
                type: 'POST',
                url: '{{url('/diceGame/updateSession')}}',
                data: {'command': 'setDices', 'number': parseInt(num)},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function () {
                    location.reload();
                }
            });
        });

        $('#throw-dices').click(() => {
            $.ajax({
                type: 'POST',
                url: '{{url('/diceGame/updateSession')}}',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {'command': 'throw'},
                success: function () {
                    location.reload();
                }
            });
        });

        $('#stop').click(() => {
            $.ajax({
                type: 'POST',
                url: '{{url('/diceGame/updateSession')}}',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {'command': 'stop'},
                success: function () {
                    location.reload();
                }
            });
        });

        $('#restart').click(() => {
            $.ajax({
                type: 'POST',
                url: '{{url('/diceGame/updateSession')}}',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {'command': 'restart'},
                success: function () {
                    location.reload();
                }
            });
        });
    </script>
@endsection
