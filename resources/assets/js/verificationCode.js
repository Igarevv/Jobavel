document.addEventListener("DOMContentLoaded", function (event) {
    var scrollpos = localStorage.getItem('scrollpos');

    if (scrollpos) window.scrollTo(0, scrollpos);

    var button = document.getElementById('resendCodeBtn');
    var timeoutDuration = 60000;

    function showButton() {
        button.disabled = false;
    }

    function hideButton() {
        button.disabled = true;
        var hideTime = new Date().getTime();
        localStorage.setItem('hideTime', hideTime);
        setTimeout(showButton, timeoutDuration);
    }

    function checkButtonVisibility() {
        var hideTime = localStorage.getItem('hideTime');
        if (hideTime) {
            var currentTime = new Date().getTime();
            var elapsedTime = currentTime - hideTime;
            if (elapsedTime >= timeoutDuration) {
                showButton();
            } else {
                setTimeout(showButton, timeoutDuration - elapsedTime);
            }
        } else {
            showButton();
        }
    }

    checkButtonVisibility();

    button.addEventListener('click', hideButton);
});

window.onbeforeunload = function (e) {
    localStorage.setItem('scrollpos', window.scrollY);
};