<?php

namespace TicTac705\guessnumber\View;

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
    echo "--list win - Вывод списка всех игр, в которых победил человек." . PHP_EOL;
    echo "--list loose - Вывод списка всех игр, в которых человек проиграл." . PHP_EOL;
    echo "--top - Вывод статистики по игрокам. Для каждого игрока нужно посчитать количество побед и проигрышей,
     список отсортировать по количеству побед (чемпионы располагаются вверху списка)." . PHP_EOL;
    echo "--replay id - Повтор игры с идентификатором id." . PHP_EOL;
    echo "--exit - Выход из игры." . PHP_EOL;
    echo PHP_EOL;

    $getCommand = \cli\prompt("Введите ключ");

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
    if (empty($row[6])) {
        $row[6] = "not completed";
    }

    \cli\line(
        "ID: $row[0] | Дата: $row[1] $row[2] | Имя игрока: $row[3] | Максимальное число: "
        . "$row[4] | Сгенерированное число: $row[5] | Исход: $row[6]"
    );
}

function outputTurnInfo($row)
{
    \cli\line("----- Номер попытки: $row[0] | предложенное число: $row[1] | Ответ компьютера: $row[2]");
}

function outputGamesInfoTop($row)
{
    \cli\line(
        "Имя игрока: $row[0] | Кол-во побед: $row[1] | Кол-во проигрышей: $row[2]"
    );
}

function exitOrMenu()
{
    echo PHP_EOL . "(--exit - Выход из игры | --menu - Меню игры)" . PHP_EOL;

    $command = readline();

    if ($command === '--exit') {
        exit();
    } elseif ($command === '--menu') {
        MenuGame();
    } else {
        exitOrMenu();
    }
}
