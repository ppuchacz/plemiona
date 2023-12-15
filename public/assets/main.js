var globalTestValue = null;

const URL_SERVER = 'http://localhost:8000';
const PATH_LVL_UP_BUILDING = '/building/up';
const PATH_CREATE_BUILDING = '/building/';
const PATH_VILLAGE_GET = '/village/';

/**
 * @param {int} villageId
 * @returns {string}
 */
function getVillageResourcesUrl(villageId) {
    return URL_SERVER + '/village/' + villageId + '/resource/';
}

var dataBagElement = document.getElementById('data-bag');

function getData(id) {
    return dataBagElement.dataset[id];
}
