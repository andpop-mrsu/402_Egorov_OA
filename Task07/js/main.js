import {
    startGame,
    informationOutput,
    showGameOutput,
    menuGame
} from './View.js';

import {
    btn_nextMenuGame,
    btn_nextShowGame,
    btn_checkNumber,
    btn_replayGame,
    btn_newGame,
    btn_goMenu,
    checkNumber,
    btn_listAllGame,
    btn_listWinGame,
    btn_listLossGame
} from "./Model.js";

import {getAllGame, getLossGame, getWinGame, startDB} from "./DateBase.js";

startGame();

document.addEventListener("DOMContentLoaded", startDB);

btn_nextMenuGame.addEventListener("click", menuGame);//Переход в меню игры

btn_newGame.addEventListener("click", informationOutput);//При нажатии на новую игру переход на блок с информацией

btn_nextShowGame.addEventListener("click", showGameOutput);

btn_checkNumber.addEventListener("click", checkNumber);

btn_replayGame.addEventListener("click", showGameOutput);

btn_goMenu.addEventListener("click", menuGame);

btn_listAllGame.addEventListener("click", getAllGame);

btn_listWinGame.addEventListener("click", getWinGame);

btn_listLossGame.addEventListener("click", getLossGame);