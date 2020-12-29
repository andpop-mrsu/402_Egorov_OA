import {
    writeAllGame
} from "./View.js";

let idbSupported = false;
let db;

let dbName = "guess-number";
let dbVersion = 1;

let game,
    idLastGame;

export function startDB() {
    if ("indexedDB" in window) {
        idbSupported = true;
    }

    if (idbSupported) {
        const openRequest = indexedDB.open(dbName, dbVersion);

        openRequest.onupgradeneeded = function (e) {
            console.log("Upgrading...");
            const thisDB = e.target.result;

            if (!thisDB.objectStoreNames.contains("gamesinfo")) {
                thisDB.createObjectStore("gamesinfo", {autoIncrement: true}).createIndex('idxOutcome', 'outcome');
            }

            if (!thisDB.objectStoreNames.contains("attempts")) {
                thisDB.createObjectStore("attempts", {autoIncrement: true}).createIndex('idx', 'idGame');
            }
        }

        openRequest.onsuccess = function (e) {
            console.log("Success!");
            db = e.target.result;
        }

        openRequest.onerror = function (e) {
            console.log("Error");
            console.dir(e);
        }
    }
}

export function addNewGame(name, max_num, num_attempt, hidden_number) {
    const transaction = db.transaction(["gamesinfo"], "readwrite");
    const store = transaction.objectStore("gamesinfo");

    game = {
        date: new Date().toLocaleDateString(),
        userName: name,
        maxNumber: max_num,
        numAttempt: num_attempt,
        hiddenNumber: hidden_number,
        outcome: null
    }

    let request = store.add(game);

    request.onerror = function (e) {
        console.log("Error", e.target.error.name, ":", e.target.error);
    }

    request.onsuccess = function (e) {
        console.log("Запись о новой игре добавлена!");
    }

    getLastIdGame()
}

export function getLastIdGame() {
    const transaction = db.transaction(["gamesinfo"], "readonly");
    const store = transaction.objectStore("gamesinfo");

    let request = store.openCursor(null, "prev");

    request.onsuccess = function (event) {
        let cursor = request.result;

        idLastGame = cursor.key;
    }
}

export function editGame(outcome) {
    const transaction = db.transaction(["gamesinfo"], "readwrite");
    const store = transaction.objectStore("gamesinfo");

    game.outcome = outcome;

    let request = store.put(game, idLastGame);

    request.onerror = function (e) {
        console.log("Error", e.target.error.name, ":", e.target.error);
    }

    request.onsuccess = function (e) {
        console.log("Игра " + idLastGame + " отредактирована");
    }

}

export function addAttempt(numAttempt, number, ansComp) {
    const transaction = db.transaction(["attempts"], "readwrite");
    const store = transaction.objectStore("attempts");

    let attempt = {
        idGame: idLastGame,
        numAttempt: numAttempt,
        getNumber: number,
        ansComp: ansComp
    };

    let request = store.add(attempt);

    request.onerror = function (e) {
        console.log("Error", e.target.error.name, ":", e.target.error);
    }

    request.onsuccess = function (e) {
        console.log("Запись о попытке добавлена!");
    }

}

export function getAllGame() {
    getGame("all");
}

export function getWinGame() {
    getGame("win");
}

export function getLossGame() {
    getGame("loss");
}

async function getGame(out) {

    const gamesinfo = db.transaction(["gamesinfo"], "readonly");
    const store_gamesinfo = gamesinfo.objectStore("gamesinfo");

    const index = store_gamesinfo.index("idxOutcome");

    let cursor_gamesinfo;

    if (out === "all") {
        cursor_gamesinfo = await store_gamesinfo.openCursor();
    } else {
        cursor_gamesinfo = await index.openCursor(out);
    }

    let result = "<table><tr>" +
        "<th>Ник</th>" +
        "<th>Максимальное число</th>" +
        "<th>Кол-во попыток</th>" +
        "<th>Загаданное число</th>" +
        "<th>Исход</th>" +
        "<th>Дата</th>" +
        "<th></th></tr>";

    cursor_gamesinfo.onsuccess = async function (e) {
        let res = e.target.result;

        if (res) {

            result += "<tr>" +
                "<td>" + res.value.userName + "</td>" +
                "<td>" + res.value.maxNumber + "</td>" +
                "<td>" + res.value.numAttempt + "</td>" +
                "<td>" + res.value.hiddenNumber + "</td>" +
                "<td>" + res.value.outcome + "</td>" +
                "<td>" + res.value.date + "</td>" +
                "<td><button>Run</button></td>" +
                "</tr>";

            result += await getAttempts(res.key);

            res.continue();
        } else {
            result += "</table>";
            writeAllGame(result);
        }
    }
}

let resGetAttempts;

function getAttempts(id) {
    const attempts = db.transaction(["attempts"], "readonly");
    const store_attempts = attempts.objectStore("attempts");
    const gameIndex = store_attempts.index("idx");

    let request = gameIndex.getAll(id);

    request.onsuccess = function () {
        if (request.result !== undefined) {
            resGetAttempts = "<tr>" +
                "<th>&raquo;</th>" +
                "<th colspan=\"2\" style='background-color: #FAFAD2;'>№</th>" +
                "<th colspan=\"2\" style='background-color: #FAFAD2;'>Число</th>" +
                "<th colspan=\"2\" style='background-color: #FAFAD2;'>Ответ</th>" +
                "</tr>";
            request.result.forEach(function (entry) {
                resGetAttempts += "<tr>" +
                    "<td>&raquo;</td>" +
                    "<td colspan=\"2\" style='background-color: #FAFAD2;'>" + entry.numAttempt + "</td>" +
                    "<td colspan=\"2\" style='background-color: #FAFAD2;'>" + entry.getNumber + "</td>" +
                    "<td colspan=\"2\" style='background-color: #FAFAD2;'>" + entry.ansComp + "</td>" +
                    "</tr>";
            });
        } else {
            console.log("Попыток нет!");
        }
    };

    return resGetAttempts;
}