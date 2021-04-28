
// Darkmode lg version
// Set theme when click
$(document).on('click', '.do-darkmode', function (e) {
    $(this).removeClass('do-darkmode', true);
    if (document.documentElement.getAttribute('data-theme') == 'light') {
        $(`.fa-moon`).addClass('active');
        setTimeout(() => {
            $(`.fa-moon`).replaceWith(`<i class="fas fa-sun join text-yellow-500"></i>`);
            setTimeout(() => {
                $(`.fa-sun`).removeClass('join');
            }, 1000);
        }, 2500);
        document.documentElement.setAttribute('data-theme', 'dark');
        localStorage.setItem('theme', 'dark');
    }
    else {
        $(`.fa-sun`).addClass('active');
        setTimeout(() => {
            $(`.fa-sun`).replaceWith(`<i class="fas fa-moon join"></i>`);
            setTimeout(() => {
                $(`.fa-moon`).removeClass('join');
            }, 1000);
        }, 2500);
        document.documentElement.setAttribute('data-theme', 'light');
        localStorage.setItem('theme', 'light');
    }
    setTimeout(() => {
        $(this).addClass('do-darkmode');
    }, 4000);
})
