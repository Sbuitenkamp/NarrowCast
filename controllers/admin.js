let settings;
const conn = new WebSocket('ws://localhost:8080');
conn.onopen = e => {
    console.log("Connection established!");
    conn.send(JSON.stringify({
        type: "admin"
    }));
};
conn.onmessage = e => {
    const data = JSON.parse(e.data);
    if (data.type === "admin") {
        const container = document.querySelector("div.settings-container");
        for (const setting of data.moduleSettings) {
            // todo: add frequency
            container.innerHTML += `
                <div class="settings-container__item">
                    <form action="">
                        <input type="text" name="id" value="${setting.id}" hidden>
                        <input type="text" name="name" value="${setting.name}">
                        <input type="radio" name="activated" value="1" ${setting.activated ? "checked" : null}>Geactiveerd
                        <input type="radio" name="activated" value="0" ${!setting.activated ? "checked" : null}>Gedeactiveerd
                        Interval in seconden: <input type="text" name="timeout" value="${setting.timeout}">
                        <button type="button" onclick="onClick(this)">Opslaan</button>
                    </form>
                </div>
            `;
        }
    } else if (data.type === "updateResult") {
        if (data.result) console.log("Success"); // todo add visible success message (*cough* teshale)
        else console.log("no changes made");
    }
};

function onClick(element) {
    const data = { type: "updateModule" };
    data.values = formToJSON(element.parentElement.children);
    data.id = Number(data.values.id);
    delete data.values.id;
    data.values.activated = Number(data.values.activated);
    conn.send(JSON.stringify(data));
}

function changeAnimation(element) {
    const data = formToJSON(element.parentElement.children);
    data.type = "updateAnimation";
    conn.send(JSON.stringify(data));
}

function logOut() {
    console.log("todo lmao");
}

// form to json again, if you touch this: your dreams, haunted
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