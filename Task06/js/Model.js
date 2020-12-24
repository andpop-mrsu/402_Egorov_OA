import {
    messageOutput
} from "./View.js";

export const
    block_greeting = document.getElementById("greeting"),
    block_information = document.getElementById("information"),
    block_showGame = document.getElementById("show-game"),
    block_message = document.getElementById("message"),
    block_result = document.getElementById("result"),
    block_resultText = document.getElementById("resultText");

export const
    btn_nextInfo = document.getElementById("nextInfo"),
    btn_nextShowGame = document.getElementById("nextShowGame"),
    btn_checkNumber = document.getElementById("checkNumber"),
    btn_replayGame = document.getElementById("replayGame");

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
        if (var_num_attempt !== 1) {
            getNumber = Number(field_getNumber.value);
            if (getNumber < hidden_number) {
                var_num_attempt--;
                messageOutput("less");
            }
            if (getNumber > hidden_number) {
                var_num_attempt--;
                messageOutput("more");
            }
            if (getNumber === hidden_number) {
                messageOutput("win");
            }
        } else {
            messageOutput("loss");
        }
    }
}

export function makeNumber() {
    hidden_number = Math.floor(Math.random() * (max_num - 1)) + 1;
    var_num_attempt = num_attempt;
}