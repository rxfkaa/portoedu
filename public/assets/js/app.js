document.addEventListener('DOMContentLoaded', () => {
    const sidebar = document.querySelector('.sidebar');
    const menuToggle = document.querySelector('.menu-toggle');
    const darkModeButton = document.getElementById('darkMode');
    const themeSwitch = document.getElementById('themeSwitch');

    const setTheme = (isDark) => {
        document.body.classList.toggle('dark', isDark);
        localStorage.setItem('dsp-theme', isDark ? 'dark' : 'light');
        if (darkModeButton) {
            darkModeButton.innerHTML = `<i class="bi bi-${isDark ? 'sun' : 'moon-stars'}"></i>`;
            darkModeButton.setAttribute('aria-label', isDark ? 'Gunakan mode terang' : 'Gunakan mode gelap');
        }
        if (themeSwitch) themeSwitch.checked = isDark;
    };

    setTheme(localStorage.getItem('dsp-theme') === 'dark');
    darkModeButton?.addEventListener('click', () => setTheme(!document.body.classList.contains('dark')));
    themeSwitch?.addEventListener('change', (event) => setTheme(event.target.checked));
    menuToggle?.addEventListener('click', () => sidebar?.classList.toggle('show'));

    document.addEventListener('click', (event) => {
        if (window.innerWidth <= 992 && sidebar?.classList.contains('show') && !sidebar.contains(event.target) && !menuToggle?.contains(event.target)) sidebar.classList.remove('show');
    });

    const greeting = document.getElementById('greeting');
    if (greeting) {
        const hour = new Date().getHours();
        const timeGreeting = hour < 11 ? 'Selamat pagi' : hour < 15 ? 'Selamat siang' : hour < 18 ? 'Selamat sore' : 'Selamat malam';
        greeting.textContent = `${timeGreeting}, ${greeting.dataset.name || 'Rafka'} 👋`;
    }
});
