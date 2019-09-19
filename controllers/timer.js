const timer = document.querySelector("div.footer>div.footer__timer>span.footer__timer__text");
const dateDiv = document.querySelector("div.footer>div.footer__date>span.footer__date__text");
// initial
const initialDate = new Date();
timer.innerHTML = `${initialDate.getHours()}:${initialDate.getMinutes()}:${initialDate.getSeconds()}`;
dateDiv.innerHTML = `${initialDate.getDate()}/${initialDate.getMonth() + 1}/${initialDate.getFullYear()}`;
// timer
setInterval(() => {
    const date = new Date();
    timer.innerHTML = `${date.getHours()}:${date.getMinutes()}:${date.getSeconds()}`;
    dateDiv.innerHTML = `${date.getDate()}/${date.getMonth() + 1}/${date.getFullYear()}`;
}, 1000);