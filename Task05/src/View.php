<?php

namespace TicTac705\guessnumber\View;

use function cli\line;
use function cli\prompt;
use function TicTac705\guessnumber\Model\showGame;
use function TicTac705\guessnumber\Model\replayGame;
use function TicTac705\guessnumber\Model\commandHandler;

function MenuGame()
{
    echo PHP_EOL;
    echo "****************************************************************" . PHP_EOL;
    echo "Главное меню:" . PHP_EOL;
    echo "--new - Новая игра." . PHP_EOL;
    echo "--list - Вывод списка всех сохраненных игр." . PHP_EOL;
    echo "--list win - Вывод списка всех игр, в которых победили" . PHP_EOL;
    echo "--list loose - Вывод списка всех игр, в которых проиграли." . PHP_EOL;
    echo "--top - Вывод статистики по игрокам." . PHP_EOL;
    echo "--replay id - Повтор игры с идентификатором id." . PHP_EOL;
    echo "--exit - Выход из игры." . PHP_EOL;
    echo PHP_EOL;

    $getCommand = prompt("Введите ключ");

    commandHandler($getCommand);
}

function greeting()
{
    global $user_name;

    echo 'Привет! Как тебя зовут?' . PHP_EOL;

    $user_name = readline();

    if (!empty($user_name)) {
        echo 'Рад познакомиться, ' . $user_name . '!' . PHP_EOL . 'Давай сыграем в игру "Угадай число".'
            . ' Ее суть состоит в том, что я загадываю число от 1 до ' . MAX_NUM .
            ' и ты должен отгадать число за ' . NUM_ATTEMPT . ' попыток.' . PHP_EOL;

        showGame($user_name);
    } else {
        greeting();
    }
}

function endGame($hidden_num, $attempt = false)
{
    global $user_name;

    if ($attempt) {
        echo 'Поздравляю! Ты справился за ' . $attempt . ' попыток.' . PHP_EOL;
        replayGame($user_name);
    } else {
        echo 'Увы, ты не справился. Я загадал число: ' . $hidden_num . PHP_EOL;
        replayGame($user_name);
    }
}

function outputGamesInfo($row)
{
    if ($row['game_outcome'] === '...') {
        $row['game_outcome'] = "not completed";
    }

    line("ID: {$row['id']} | Дата: {$row['game_data']} {$row['game_time']} | " .
        "Имя игрока: {$row['player_name']} | Максимальное число: {$row['max_number']} | " .
        "Сгенерированное число: {$row['generated_number']} | Исход: {$row['game_outcome']}");
}

function outputTurnInfo($row)
{
    line("----- Номер попытки: {$row['number_attempts']} | "
        . "предложенное число: {$row['proposed_number']} | "
        . "Ответ компьютера: {$row['computer_responds']}");
}

function outputGamesInfoTop($row)
{
    line(
        "Имя игрока: {$row['player_name']} | Кол-во побед: {$row['countWin']} |"
        . " Кол-во проигрышей: {$row['countLoss']}"
    );
}

function exitOrMenu()
{
    echo PHP_EOL . "(--exit - Выход из игры | --menu - Меню игры)" . PHP_EOL;

    $command = readline();

    if ($command === '--exit') {
        exit();
    }

    if ($command === '--menu') {
        MenuGame();
    } else {
        exitOrMenu();
    }
}
