<?php 
	namespace TicTac705\guessnumber\Controller;
	use function TicTac705\guessnumber\View\showGame;
	
	function startGame() {
		echo "Game started".PHP_EOL;
		showGame();
	}
?>