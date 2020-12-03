<?php

namespace TicTac705\guessnumber\Controller;

use function TicTac705\guessnumber\View\showGame;
use function TicTac705\guessnumber\View\setting;
use function TicTac705\guessnumber\View\greeting;
use function TicTac705\guessnumber\View\endGame;
use function TicTac705\guessnumber\View\replayGame;

function startGame()
{
    setting();
    greeting();
    showGame();
}

?>