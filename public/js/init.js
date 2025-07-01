function updateCountdown() {
    const now = new Date();
    const date = String(now.getDate()).padStart(2, '0');
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const seconds = String(now.getSeconds()).padStart(2, '0');

    document.querySelector('.countdown-title.days').textContent = date;
    document.querySelector('.countdown-title.hours').textContent = hours;
    document.querySelector('.countdown-title.minutes').textContent = minutes;
    document.querySelector('.countdown-title.seconds').textContent = seconds;
}

$(document).ready(function() {
    setInterval(updateCountdown, 1000);
    updateCountdown();
});