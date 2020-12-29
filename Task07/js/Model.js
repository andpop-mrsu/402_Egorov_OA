import {
    messageOutput
} from "./View.js";

import {
    addAttempt,
    editGame
} from "./DateBase.js";

export const
    block_greeting = document.getElementById("greeting"),
    block_information = document.getElementById("information"),
    block_showGame = document.getElementById("show-game"),
    block_message = document.getElementById("message"),
    block_result = document.getElementById("result"),
    block_resultText = document.getElementById("resultText"),
    block_menuGame = document.getElementById("menuGame"),
    block_list = document.getElementById("list"),
    block_text_list = document.getElementById("text_list");

export const
    btn_goMenu = document.getElementById("goMenu"),
    btn_nextMenuGame = document.getElementById("nextInfo"),
    btn_nextShowGame = document.getElementById("nextShowGame"),
    btn_checkNumber = document.getElementById("checkNumber"),
    btn_replayGame = document.getElementById("replayGame"),
    btn_newGame = document.getElementById("newGame"),
    btn_listAllGame = document.getElementById("listAllGame"),
    btn_listWinGame = document.getElementById("listWinGame"),
    btn_listLossGame = document.getElementById("listLossGame");

export const
    field_name = document.getElementById("name"),
    field_getNumber = document.getElementById("getNumber");

export const
    text_info = document.getElementById("info");

export const
    num_attempt = 5,
    max_num = 10;

export let
    var_num_attempt = num_attempt,
    hidden_number;

let getNumber;

export function checkNumber() {
    if (field_getNumber.value === "") {
        alert("Введите число!");
    } else {
        getNumber = Number(field_getNumber.value);
        if (var_num_attempt !== 1) {
            if (getNumber < hidden_number) {
                var_num_attempt--;
                messageOutput("less");
                addAttempt((num_attempt - var_num_attempt), getNumber, "less");
            }
            if (getNumber > hidden_number) {
                var_num_attempt--;
                messageOutput("more");
                addAttempt((num_attempt - var_num_attempt), getNumber, "more");
            }
            if (getNumber === hidden_number) {
                messageOutput("win");
                addAttempt((num_attempt - var_num_attempt), getNumber, "win");
                editGame("win");
            }
        } else {
            messageOutput("loss");
            editGame("loss");
            addAttempt((num_attempt - var_num_attempt + 1), getNumber, "loss");
        }
    }
}

export function makeNumber() {
    hidden_number = Math.floor(Math.random() * (max_num - 1)) + 1;
    var_num_attempt = num_attempt;
}