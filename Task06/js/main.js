import {
    startGame,
    informationOutput,
    showGameOutput
} from './View.js';

import {
    btn_nextInfo,
    btn_nextShowGame,
    btn_checkNumber,
    btn_replayGame,
    checkNumber
} from "./Model.js";


startGame();

btn_nextInfo.addEventListener("click", informationOutput);
btn_nextShowGame.addEventListener("click", showGameOutput);
btn_checkNumber.addEventListener("click", checkNumber);
btn_replayGame.addEventListener("click", showGameOutput);