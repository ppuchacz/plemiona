const ID_RESOURCE_AMOUNT_WOOD = 'resource-wood-amount';
const ID_RESOURCE_AMOUNT_IRON = 'resource-iron-amount';
const ID_RESOURCE_AMOUNT_STONE = 'resource-stone-amount';

window.addEventListener('load', () => reloadResources());

setInterval(function () {
    reloadResources()
}, 1000);

function reloadResources() {
    let villageId = parseInt(getData('villageid'));
    getResourcesRequest(villageId);
}

/**
 * @param {int} villageId
 */
function getResourcesRequest(villageId) {
    fetch(getVillageResourcesUrl(villageId), {
        method: 'GET',
        headers: {
            Accept: 'application/json',
            'Content-Type': 'application/json'
        }
    })
        .then((response) => {
            reloadResourcesView(response)
        })
        .catch((response) => console.log(response));
}

async function reloadResourcesView(response) {
    let resource_labels = {
        'wood': document.getElementById(ID_RESOURCE_AMOUNT_WOOD),
        'iron': document.getElementById(ID_RESOURCE_AMOUNT_IRON),
        'stone': document.getElementById(ID_RESOURCE_AMOUNT_STONE),
    };

    const data = await response.json();

    data.forEach((r) => {
        resource_labels[r.type].innerText = r.amount;
    })

    console.log(data)
    globalTestValue = data
}