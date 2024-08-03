document.addEventListener("DOMContentLoaded", function (event) {
    const button = document.getElementById('resendCodeBtn');
    const disableTime = localStorage.getItem('disableTime');

    if (disableTime) {
        const currentTime = new Date().getTime();
        const timeDifference = currentTime - disableTime;

        if (timeDifference < 60000) {
            button.disabled = true;
            document.getElementById('message').classList.replace('d-none', 'd-block');
            setTimeout(() => {
                button.disabled = false;
                document.getElementById('message').classList.replace('d-block', 'd-none');
                localStorage.removeItem('disableTime');
            }, 60000 - timeDifference);
        } else {
            localStorage.removeItem('disableTime');
        }
    }

    function disableButton() {
        button.disabled = true;
        document.getElementById('message').classList.replace('d-none', 'd-block');
        const disableTime = new Date().getTime();
        localStorage.setItem('disableTime', disableTime);

        setTimeout(() => {
            button.disabled = false;
            document.getElementById('message').classList.replace('d-block', 'd-none');
            localStorage.removeItem('disableTime');
        }, 60000);
    }

    button.addEventListener('click', () => {
        const route = button.getAttribute('data-route');
        const token = button.getAttribute('data-token');
        console.log(route, token);

        fetch(route, {
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': token,
            }
        }).then(response => {

        });

        disableButton();
    });
});

window.onbeforeunload = function (e) {
    localStorage.setItem('scrollpos', window.scrollY);
};

window.onload = function (e) {
    const scrollpos = localStorage.getItem('scrollpos');
    if (scrollpos) {
        window.scrollTo(0, scrollpos);
        localStorage.removeItem('scrollpos');
    }
};