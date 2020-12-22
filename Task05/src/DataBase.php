<?php

namespace TicTac705\guessnumber\DataBase;

use function TicTac705\guessnumber\View\outputGamesInfo;
use function TicTac705\guessnumber\View\outputTurnInfo;
use function TicTac705\guessnumber\View\outputGamesInfoTop;
use RedBeanPHP\R;

function openDatabase()
{
    if (!file_exists(DB_NAME)) {
        new \SQLite3(DB_NAME);
    }

    if (!R::testConnection()) {
        R::setup('sqlite:' . DB_NAME);
    }
}

function insertNewGame($user_name, $hidden_num, $MAX_NUM)
{
    if (!R::testConnection()) {
        R::setup('sqlite:' . DB_NAME);
    }

    date_default_timezone_set("Europe/Moscow");

    $gameData = date("d") . "." . date("m") . "." . date("Y");
    $gameTime = date("H") . ":" . date("i") . ":" . date("s");

    $gamesInfo = R::dispense('gamesinfo');

    $gamesInfo->gameData = $gameData;
    $gamesInfo->gameTime = $gameTime;
    $gamesInfo->playerName = $user_name;
    $gamesInfo->maxNumber = $MAX_NUM;
    $gamesInfo->generatedNumber = $hidden_num;
    $gamesInfo->gameOutcome = "...";

    R::store($gamesInfo);

    $lastGameID = R::getCol("SELECT id FROM gamesinfo ORDER BY id DESC LIMIT 1");

    return $lastGameID[0];
}

function addAttemptInDB($idGame, $proposedNumber, $computerResponds, $numberAttempts)
{
    if (!R::testConnection()) {
        R::setup('sqlite:' . DB_NAME);
    }

    $attempts = R::dispense('attempts');

    $attempts->idGame = $idGame;
    $attempts->numberAttempts = $numberAttempts;
    $attempts->proposedNumber = $proposedNumber;
    $attempts->computerResponds = $computerResponds;

    R::store($attempts);
    R::close();
}

function updateInfoGame($idGame, $gameOutcome)
{
    if (!R::testConnection()) {
        R::setup('sqlite:' . DB_NAME);
    }

    $gamesInfo = R::load('gamesinfo', $idGame);

    $gamesInfo->gameOutcome = $gameOutcome;

    R::store($gamesInfo);
    R::close();
}

function outputListGame($gameOutcome = false)
{
    if (!R::testConnection()) {
        R::setup('sqlite:' . DB_NAME);
    }

    if ($gameOutcome === "win") {
        $result = R::getAll('SELECT * FROM gamesinfo WHERE game_outcome = :gameOutcome',
            array(':gameOutcome' => $gameOutcome)
        );
    } elseif ($gameOutcome === "loss") {
        $result = R::getAll('SELECT * FROM gamesinfo WHERE game_outcome = :gameOutcome',
            array(':gameOutcome' => $gameOutcome)
        );
    } else {
        $result = R::getAll('SELECT * FROM gamesinfo');
    }

    foreach ($result as $value) {
        outputGamesInfo($value);

        $gameTurns = R::getAll("SELECT
            number_attempts,
            proposed_number,
            computer_responds
            FROM attempts
            WHERE id_game = :id
            ", array(':id' => $value['id']));

        foreach ($gameTurns as $values) {
            outputTurnInfo($values);
        }
    }

    R::close();
}

function outputListGameTop()
{
    if (!R::testConnection()) {
        R::setup('sqlite:' . DB_NAME);
    }

    $result = R::getAll("SELECT player_name, 
    (SELECT COUNT(*) FROM gamesinfo as b WHERE a.player_name = b.player_name AND game_outcome = 'win') as countWin,
    (SELECT COUNT(*) FROM gamesinfo as c WHERE a.player_name = c.player_name AND game_outcome = 'loss') 
    as countLoss FROM gamesinfo as a
    GROUP BY player_name ORDER BY countWin DESC, countLoss");

    foreach ($result as $value) {
        outputGamesInfoTop($value);
    }

    R::close();
}

function checkGameId($id)
{
    if (!R::testConnection()) {
        R::setup('sqlite:' . DB_NAME);
    }

    $checkGameID = R::getCol("SELECT player_name FROM gamesinfo WHERE id = :id", array(':id' => $id));

    if (!empty($checkGameID[0])) {
        return $checkGameID[0];
    }

    R::close();

    return false;
}
