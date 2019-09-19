let settings;
let order = [];
let prevIndex = 0;
const conn = new WebSocket('ws://localhost:8080');
conn.onopen = e => {
    console.log("Connection established!");
    conn.send(JSON.stringify({
        type: "init"
    }));
};

conn.onmessage = e => {
    const data = JSON.parse(e.data);
    if (data.type === "html") {
        if (data.settings) {
            settings = data.settings;
            // turn em into numbers
            order = settings.loadOrder.split(/,+/g).map(item => Number(item));
        }
        // carousel logic, DON'T change the order of these ifs or I will come to haunt you in your sleep
        if (prevIndex === undefined ) prevIndex = 0;
        else prevIndex++;
        if (prevIndex > order.length - 1) prevIndex = 0;
        loadModule(data.html, order[prevIndex], data.timeout);
    }
};

function loadModule(html, id, timeout) {
    document.querySelector("div.container").innerHTML = html;
    setTimeout(() => {
        conn.send(JSON.stringify({
            type: "module",
            id
        }));
    }, timeout * 1000);
}