<?php

namespace TicTac705\guessnumber\Controller;

use function TicTac705\guessnumber\Model\setting;
use function TicTac705\guessnumber\View\MenuGame;
use function TicTac705\guessnumber\DataBase\openDatabase;

function startGame()
{
    setting();
    openDatabase();
    MenuGame();
}
