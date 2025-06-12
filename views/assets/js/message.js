setTimeout(function () {
    window.location.href = '/';
}, 10000);

document.addEventListener('DOMContentLoaded', function () {
    var goBack = document.getElementById('goBack');
    if (goBack) {
        goBack.addEventListener('click', function () {
            window.location.href = '/login';
        });
    }
    var goHome = document.getElementById('goHome');
    if (goHome) {
        goHome.addEventListener('click', function () {
            window.location.href = '/';
        });
    }
});