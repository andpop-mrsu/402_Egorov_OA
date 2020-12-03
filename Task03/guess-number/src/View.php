<?php

namespace TicTac705\guessnumber\View;

function setting()
{
    define("MAX_NUM", 8);
    define("NUM_ATTEMPT", 4);
}

function greeting()
{
    global $user_name;
    echo 'Привет! Как тебя зовут?' . PHP_EOL;
    $user_name = readline();
    echo 'Рад познакомиться, ' . $user_name . '!' . PHP_EOL . 'Давай сыграем в игру "Угадай число".'
        . ' Ее суть состоит в том, что я загадываю число от 1 до ' . MAX_NUM . ' и ты должен отгадать число за ' . NUM_ATTEMPT . ' попыток.' . PHP_EOL;
}

function showGame()
{
    $hidden_num = rand(1, MAX_NUM);
    echo "Попробуй угадать." . PHP_EOL;

    $attempt = 1;
    while ($attempt <= NUM_ATTEMPT) {
        $get_num = readline();

        if ($get_num == $hidden_num) {
            endGame($hidden_num, $attempt);
            break;
        } elseif ($get_num < $hidden_num) {
            echo 'Твое число слишком маленькое' . PHP_EOL;
        } elseif ($get_num > $hidden_num) {
            echo 'Твое число слишком большое' . PHP_EOL;
        }

        $attempt++;
    }

    if ($attempt > NUM_ATTEMPT) {
        endGame($hidden_num);
    }
}

function endGame($hidden_num, $attempt = false)
{
    if ($attempt) {
        echo 'Поздравляю! Ты справился за ' . $attempt . ' попыток.' . PHP_EOL;
        replayGame();
    } else {
        echo 'Увы, ты не справился. Я загадал число: ' . $hidden_num . PHP_EOL;
        replayGame();
    }
}

function replayGame()
{
    global $user_name;

    echo $user_name . ', попробуем еще разок? (y ="Да" / n = "Нет")' . PHP_EOL;
    $replay_game = readline();

    if ($replay_game == 'y' || $replay_game == 'Y') {
        showGame();
    } elseif ($replay_game == 'n' || $replay_game == 'N') {
        echo 'Очень жаль, ' . $user_name . '. До скорой встречи.' . PHP_EOL;
    } else {
        replayGame();
    }
}

?>