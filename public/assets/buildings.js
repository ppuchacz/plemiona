const TABLE_BUILDINGS = 'buildingsList';
const TABLE_NON_EXISTENT_BUILDINGS = 'availableList';

// var lvlUpBtns = document.getElementsByClassName(BTN_LVL_UP);
var tableBuildings = document.getElementById(TABLE_BUILDINGS);
var nonExistentBuildingsTable = document.getElementById(TABLE_NON_EXISTENT_BUILDINGS);

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
    clearAvailableTable();

    const data = await response.json();

    console.log(data.buildings)
    globalTestValue = data
    data.buildings.reverse().forEach((b) => appendBuildingToTable(b));
    data.available.reverse().forEach((b) => appendAvailableToTable(b));
}

function clearBuildingsTable() {
    while (tableBuildings.rows.length > 1) {
        tableBuildings.deleteRow(1);
    }
}

function clearAvailableTable() {
    while (nonExistentBuildingsTable.rows.length > 1) {
        nonExistentBuildingsTable.deleteRow(1);
    }
}

/**
 * @param {int} villageId
 * @param {string} buildingType
 */
function onCreate(villageId, buildingType) {
    sendCreateRequest(villageId, buildingType)
    reloadBuildings(villageId)
}

/**
 * @param {int} buildingId
 * @param {int} villageId
 */
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

function appendAvailableToTable(building) {
    let row = nonExistentBuildingsTable.insertRow(1);
    let nameCell = row.insertCell(0);
    let levelCell = row.insertCell(1);
    let btnCell = row.insertCell(2);

    let btn = createButton("[ + ]", "building-create-btn", null, () => onCreate(parseInt(nonExistentBuildingsTable.dataset.villageid), building.type));

    nameCell.innerText = building.name;
    levelCell.innerText = 0;
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