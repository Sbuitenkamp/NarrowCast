let settings;
let prevIndex = 0;
conn.onopen = () => {
    console.log("Connection established!");
    conn.send(JSON.stringify({ type: "init" }));
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
        loadCarousel(order);
        if (prevIndex > order.length - 1) prevIndex = 0;
        loadModule(data.html, order[prevIndex], data.timeout, data.currentAnimation);
    }
};

function loadModule(html, id, timeout, currentAnimation) {
    switchAnimation(currentAnimation);
    switchModules(html);
    setTimeout(() => {
        conn.send(JSON.stringify({
            type: "module",
            id
        }));
    }, timeout * 1000);
}

function switchModules(html) {
    const currentModule = document.getElementById("current-module");
    const nextModule = document.getElementById("next-module");
    nextModule.innerHTML = html;
    currentModule.innerHTML = html;
    if (currentModule.style.display === "none") {
        nextModule.style.display = "none";
        currentModule.style.display = "block";
    } else {
        if (nextModule.style.display === "none") {
            currentModule.style.display = "none";
            nextModule.style.display = "block";
        } else {
            nextModule.style.display = "none";
            currentModule.style.display = "block";
        }
    }
}

function switchAnimation(currentAnimation) {
    const currentModule = document.getElementById("current-module");
    const nextModule = document.getElementById("next-module");
    currentAnimation = settings.currentAnimation;
    if (currentAnimation === 0) return;
    else if (currentAnimation === 1){
        currentModule.classList.add("fadeIn");
        nextModule.classList.add("fadeIn");
    } else if (currentAnimation === 2){
        currentModule.classList.add("swipe");
        nextModule.classList.add("swipe");
    }

}

function loadCarousel(carousel) {
    const footerCarousel = document.querySelector("div.footer>div.footer__carousel");
    document.querySelector("div.footer>div.footer__carousel").innerHTML = "";
    for (let i = 1; i < carousel.length+1; i++) {
        console.log('i ' + i);
        console.log(prevIndex);
        if (prevIndex === i) footerCarousel.innerHTML += "<span class='footer__carousel__dot footer__carousel__dot--active'></span>";
        else footerCarousel.innerHTML += "<span class='footer__carousel__dot'></span>";
    }
}
