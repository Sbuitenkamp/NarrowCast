const timer = document.querySelector("div.footer>div.footer__timer>span.footer__timer__text");
const dateDiv = document.querySelector("div.footer>div.footer__date>span.footer__date__text");
// initial
const initialDate = new Date();
timer.innerHTML = `${initialDate.getHours()}:${initialDate.getMinutes()}:${initialDate.getSeconds()}`;
dateDiv.innerHTML = `${initialDate.getDay()}/${initialDate.getMonth()}/${initialDate.getFullYear()}`;
// timer
setInterval(() => {
    const date = new Date();
    timer.innerHTML = `${date.getHours()}:${date.getMinutes()}:${date.getSeconds()}`;
    dateDiv.innerHTML = `${date.getDay()}/${date.getMonth()}/${date.getFullYear()}`;
}, 1000);