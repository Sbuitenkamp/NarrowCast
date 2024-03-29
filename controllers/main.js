const conn = new WebSocket('ws://localhost:8080');
const sortContainer = document.querySelector('div.sort-container>ul.sort-container__list');
const sortItemContainer = document.querySelector('div.sort-items>ul.sort-items__list');
const container = document.querySelector('div.settings-container');
let order = [];
// submit functions
function submitModule(element) {
    const data = { type: 'updateModule' };
    data.values = formToJSON(element.parentElement.children);
    data.id = Number(data.values.id);
    delete data.values.id;
    data.values.activated = Number(data.values.activated);
    conn.send(JSON.stringify(data));
}

function orderOnClick() {
    order = [];
    const elements = sortContainer.children;
    for (const element of elements) order.push(element.children[0].innerHTML);
    conn.send(JSON.stringify({
        type: "updateSettings",
        values: { load_order: order.join(',') }
    }))
}

function deleteElement(element) {
    element.parentElement.remove();
}

function logOut() {
    window.location = './logout.php';
}

function toAddUser() {
    window.location = './add-user.php';
}

function toHome() {
    window.location = './admin.php';
}

function changeAnimation(element) {
    const data = formToJSON(element.parentElement.children);
    data.type = 'updateAnimation';
    conn.send(JSON.stringify(data));
}

function createModule(element) {
    const data = formToJSON(element.parentElement.children);
    data.type = 'createModule';
    conn.send(JSON.stringify(data));
    window.location = './admin.php';
}

function deleteModule(element) {
    const data = formToJSON(element.parentElement.children);
    if (confirm(`Weet u zeker dat u de instellingen voor de module "${data.name}" wilt verwijderen? U moet zelf nog de bestanden uit het systeem halen.`)) {
        data.type = 'deleteModule';
        conn.send(JSON.stringify(data));
    }
}

function createUser(element) {
    const data = formToJSON(element.parentElement.children);
    data.type = 'createUser';
    conn.send(JSON.stringify(data));
    window.location = './admin.php';
}

// form to json. again, if you touch this: your dreams, haunted
const isValidElement = element => element.name && element.value;
const isValidValue = element => (!['checkbox', 'radio'].includes(element.type) || element.checked);
const isCheckbox = element => element.type === 'checkbox';
const getSelectValues = options => [].reduce.call(options, (values, option) => option.selected ? values.concat(option.value) : values, []);
const isMultiSelect = element => element.options && element.multiple;
const formToJSON = elements => [].reduce.call(elements, (data, element) => {
    if (isValidElement(element) && isValidValue(element)) {
        if (isCheckbox(element)) data[element.name] = (data[element.name] || []).concat(element.value);
        else if (isMultiSelect(element)) data[element.name] = getSelectValues(element);
        else data[element.name] = element.value;
    }
    return data;
}, {});