
// Check dark mode
const currentTheme = localStorage.getItem('theme') ? localStorage.getItem('theme') : 'dark';
let btnDarkmode = document.querySelectorAll(".btn-darkmode");
if (currentTheme) {
    document.documentElement.setAttribute('data-theme', currentTheme);
    if (currentTheme == 'dark') {
        for (i = 0; i < btnDarkmode.length; i++) {
            btnDarkmode[i].innerHTML = `<i class="fas fa-sun text-yellow-500"></i>`;
        }
    } else {
        for (i = 0; i < btnDarkmode.length; i++) {
            btnDarkmode[i].innerHTML = `<i class="fas fa-moon"></i>`;
        }
    }
}