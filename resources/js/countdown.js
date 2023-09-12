function countdownRedirect(seconds, url) {
    const countdown_seconds = document.querySelector('.countdown_seconds');
    const countdown_word = document.querySelector('.countdown_word');
    const countdown_dots = document.querySelector('.countdown_dots');

    let countdown_interval;
    let dots_interval;

    const updateCountdown = () => {
        countdown_seconds.textContent = seconds;
        countdown_word.textContent = seconds === 1 ? 'second' : 'seconds';
    };

    countdown_interval = setInterval(() => {
        seconds--;
        updateCountdown();

        if (seconds === 0) {
            clearInterval(countdown_interval);
            clearInterval(dots_interval);
            window.location.href = url;
        }
    }, 1000);

    dots_interval = setInterval(() => {
        countdown_dots.textContent = countdown_dots.textContent === '...' ? '.' : countdown_dots.textContent + '.';
    }, 500);

    updateCountdown();
}