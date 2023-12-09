const BTN_CREATE = 'building-create-btn';
const TABLE_BUILDINGS = 'buildingsList';

var createBtns = document.getElementsByClassName(BTN_CREATE);
// var lvlUpBtns = document.getElementsByClassName(BTN_LVL_UP);
var tableBuildings = document.getElementById(TABLE_BUILDINGS);

var globalTestValue = null;


function createBtnOnClickEvent(event) {
    console.log(event.target);
    globalTestValue = event;

    let villageId = parseInt(event.target.dataset.villageid);
    let buildingType = event.target.dataset.type;
    sendCreateRequest(villageId, buildingType);

    window.location.reload();
}

for (let btn of createBtns) {
    btn.onclick = createBtnOnClickEvent;
}

const URL_SERVER = 'http://localhost:8000';
const PATH_LVL_UP_BUILDING = '/building/up';
const PATH_CREATE_BUILDING = '/building/';
const PATH_VILLAGE_GET = '/village/';

window.addEventListener('load', () => onVillageLoad(tableBuildings.dataset.villageid));

/**
 * @param {int} villageId
 * @param {string} buildingType
 */
function sendCreateRequest(villageId, buildingType) {
    let requestModel = {
        "villageId": villageId,
        "buildingType": buildingType
    };

    fetch(URL_SERVER + PATH_CREATE_BUILDING, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(requestModel)
    })
        .then((response) => console.log(response))
        .catch((response) => console.log(response));
}

/**
 * @param {int} buildingId
 */
function sendLvlUpRequest(buildingId) {
    console.log('lvlup request function called with argument ')
    console.log(buildingId)

    let requestModel = {
        "buildingId": buildingId
    };

    fetch(URL_SERVER + PATH_LVL_UP_BUILDING, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(requestModel)
    })
        .then((response) => console.log(response))
        .catch((response) => console.log(response));
}

/**
 * @param {int} villageId
 * @param {function} onSuccessAction
 */
function getBuildingsRequest(villageId, onSuccessAction) {
    fetch(URL_SERVER + PATH_VILLAGE_GET + villageId, {
        method: 'GET',
        headers: {
            Accept: 'application/json',
            'Content-Type': 'application/json'
        }
    })
        .then((response) => {
            onSuccessAction(response)
        })
        .catch((response) => console.log(response));
}

function reloadBuildings(villageId) {
    getBuildingsRequest(villageId, reloadBuildingsView)
}

async function reloadBuildingsView(response) {
    clearBuildingsTable();

    const data = await response.json();

    console.log(data.buildings)
    globalTestValue = data
    data.buildings.reverse().forEach((b) => appendBuildingToTable(b));
}

function clearBuildingsTable() {
    while (tableBuildings.rows.length > 1) {
        tableBuildings.deleteRow(1);
    }
}

function onLvlUp(buildingId, villageId) {
    sendLvlUpRequest(buildingId)
    reloadBuildings(villageId)
}

function onVillageLoad(villageId) {
    reloadBuildings(villageId)
}

function appendBuildingToTable(building) {
    let row = tableBuildings.insertRow(1);
    let nameCell = row.insertCell(0);
    let levelCell = row.insertCell(1);
    let btnCell = row.insertCell(2);

    let btn = createButton("[ + ]", "building-lvl-up-btn", {id: building.id}, () => onLvlUp(building.id, tableBuildings.dataset.villageid));

    nameCell.innerText = building.name;
    levelCell.innerText = building.level;
    btnCell.append(btn);
}

function createButton(caption, className, dataset, onClickAction) {
    let button = document.createElement('button');
    if (className !== null) {
        button.className = className;
    }
    if (dataset !== null) {
        Object.assign(button.dataset, dataset);
    }
    if (caption !== null) {
        button.innerText = caption;
    }
    if (onClickAction !== null) {
        button.onclick = onClickAction
    }

    return button;
}