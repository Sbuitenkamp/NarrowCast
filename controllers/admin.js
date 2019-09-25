// global vars
const Sortable = require("sortablejs");
let order = [];
const sortContainer = document.querySelector('div.sort-container>ul.sort-container__list');
const sortItemContainer = document.querySelector('div.sort-items>ul.sort-items__list');
const container = document.querySelector('div.settings-container');
console.log(sortContainer);
console.log(sortItemContainer);

// sortable
const sortable = new Sortable(sortContainer, {
    animation: 150,
    group: 'shared',
    onRemove: evt => {
        // console.log(evt);
    },
});
const sortList = new Sortable(sortItemContainer, {
    animation: 150,
    group: {
        name: 'shared',
        pull: 'clone',
        put: false
    },
    sort: false,
    onClone: evt => {
        console.log(evt);
        evt.item.innerHTML += '<button onclick="deleteElement(this);"><i class="fa fa-times"></i></button>';
    }
});

// websocket
conn.onopen = () => {
    console.log('Connection established!');
    conn.send(JSON.stringify({ type: 'admin' }));
};
conn.onmessage = e => {
    const data = JSON.parse(e.data);
    // console.log(data);
    if (data.type === 'admin') {
        // animations
        const animation = data.generalSettings.currentAnimation.toString();
        document.querySelector('form.animations-container').innerHTML += `
            <input type="radio" value="0" name="animation" ${animation === '0' ? 'checked' : ''}>Geen
            <input type="radio" value="1" name="animation" ${animation === '1' ? 'checked' : ''}>Fade
            <input type="radio" value="2" name="animation" ${animation === '2' ? 'checked' : ''}>Swipe
            <button type="button" onclick="changeAnimation(this)">Verstuur</button>
        `;
        // order
        loadSortedItems(data);
        // setting panels
        for (const setting of data.moduleSettings) {
            container.innerHTML += `
                <div class="settings-container__item">
                    <form class="module" action="">
                        <input type="text" name="id" value="${setting.id}" hidden>
                        <input type="text" name="name" value="${setting.name}">
                        <input type="radio" name="activated" value="1" ${setting.activated ? "checked" : null}>Geactiveerd
                        <input type="radio" name="activated" value="0" ${!setting.activated ? "checked" : null}>Gedeactiveerd
                        Interval in seconden: <input type="text" name="timeout" value="${setting.timeout}">
                        <button type="button" onclick="submitModule(this)">Opslaan</button>
                    </form>
                </div>
            `;
            loadSortItems(setting);

        }
    } else if (data.type === 'updatedModule') {
        sortItemContainer.innerHTML = '';
        loadSortedItems(data);
        for (const setting of data.moduleSettings) loadSortItems(setting);
        orderOnClick();
    }
};

function loadSortItems(setting) {
    if (setting.activated) sortItemContainer.innerHTML += `
        <li class="sort-items__list__item">
            <span hidden>${setting.id}</span>
            ${setting.name}
        </li>
    `;
}

function loadSortedItems(data) {
    sortContainer.innerHTML = '';
    order = data.generalSettings.loadOrder.split(/,+/g).map(item => Number(item));
    for (const id of order) {
        const moduleSetting = data.moduleSettings.find(e => e.id === id);
        console.log(moduleSetting);
        if (moduleSetting.activated) sortContainer.innerHTML += `
            <li class='sort-container__list__item'>
                <span hidden>${id}</span>
                ${moduleSetting.name}
                <button onclick="deleteElement(this);"><i class="fa fa-times"></i></button>
            </li>
        `;
    }
}
