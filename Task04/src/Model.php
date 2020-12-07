<?php

namespace TicTac705\guessnumber\Model;

use function TicTac705\guessnumber\View\greeting;
use function TicTac705\guessnumber\View\endGame;
use function TicTac705\guessnumber\View\MenuGame;
use function TicTac705\guessnumber\DataBase\insertNewGame;
use function TicTac705\guessnumber\DataBase\addAttemptInDB;
use function TicTac705\guessnumber\DataBase\outputListGame;
use function TicTac705\guessnumber\DataBase\updateInfoGame;
use function TicTac705\guessnumber\DataBase\outputListGameTop;
use function TicTac705\guessnumber\DataBase\checkGameid;

function setting()
{
    define("MAX_NUM", 8);
    define("NUM_ATTEMPT", 4);
}

function showGame($user_name)
{
    $hidden_num = mt_rand(1, MAX_NUM);
    echo "Попробуй угадать." . PHP_EOL;

    $attempt = 1;

    $idNewGame = insertNewGame($user_name, $hidden_num, MAX_NUM);

    while ($attempt <= NUM_ATTEMPT) {
        $get_num = readline();

        while (is_numeric($get_num) === false) {
            echo "Некрректное число! " . PHP_EOL;
            $get_num = readline();
        }

        if ($get_num == $hidden_num) {
            addAttemptInDB($idNewGame, $get_num, "guessed", $attempt);
            updateInfoGame($idNewGame, "win");
            endGame($hidden_num, $attempt);
            break;
        }

        if ($get_num < $hidden_num) {
            echo 'Твое число слишком маленькое' . PHP_EOL;
            addAttemptInDB($idNewGame, $get_num, "number is small", $attempt);
        } elseif ($get_num > $hidden_num) {
            echo 'Твое число слишком большое' . PHP_EOL;
            addAttemptInDB($idNewGame, $get_num, "number is large", $attempt);
        }

        $attempt++;
    }

    if ($attempt > NUM_ATTEMPT) {
        updateInfoGame($idNewGame, "loss");
        endGame($hidden_num);
    }
}

function replayGame($user_name)
{
    echo $user_name . ', попробуем еще разок? (y ="Да" / n = "Нет")' . PHP_EOL;
    echo 'Или в следующий раз? (--exit - Выход из игры | --menu - Меню игры)' . PHP_EOL;
    $replay_game = readline();

    if ($replay_game === 'y' || $replay_game === 'Y') {
        showGame($user_name);
    } elseif ($replay_game === 'n' || $replay_game === 'N') {
        echo 'Очень жаль, ' . $user_name . '. До скорой встречи.' . PHP_EOL;
    } elseif ($replay_game === '--exit') {
        exit();
    } elseif ($replay_game === '--menu') {
        MenuGame();
    } else {
        replayGame($user_name);
    }
}

function commandHandler($getCommand)
{
    $checkCommand = false;

    while ($checkCommand === false) {
        if ($getCommand === "--new") {
            greeting();

            $checkCommand = true;
        } elseif ($getCommand === "--list") {
            outputListGame();
        } elseif ($getCommand === "--list win") {
            outputListGame("win");
        } elseif ($getCommand === "--list loose") {
            outputListGame("loss");
        } elseif ($getCommand === "--top") {
            outputListGameTop();
        } elseif (preg_match('/(^--replay [0-9]+$)/', $getCommand) != 0) {
            $temp = explode(' ', $getCommand);
            $id = $temp[1];

            unset($temp);

            $checkId = checkGameid($id);

            if ($checkId) {
                showGame($checkId);
            } else {
                echo "Такой игры не существует" . PHP_EOL;
            }
        } elseif ($getCommand === "--exit") {
            exit;
        }

        $getCommand = \cli\prompt("Введите ключ");
    }
}
