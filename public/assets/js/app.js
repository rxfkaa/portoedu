document.addEventListener('DOMContentLoaded', () => {
    const sidebar = document.querySelector('.sidebar');
    const menuToggle = document.querySelector('.menu-toggle');
    const sidebarToggle = document.getElementById('toggleSidebar');
    const darkModeButton = document.getElementById('darkMode');
    const darkToggle = document.getElementById('darkToggle');
    const themeSwitch = document.getElementById('themeSwitch');

    /* =============================
       THEME (dark/light)
    ============================= */
    const setTheme = (isDark) => {
        document.documentElement.classList.toggle('dark-mode', isDark);
        document.body.classList.toggle('dark', isDark);
        document.body.classList.toggle('dark-mode', isDark);
        localStorage.setItem('dsp-theme', isDark ? 'dark' : 'light');
        if (darkModeButton) {
            darkModeButton.innerHTML = `<i class="bi bi-${isDark ? 'sun' : 'moon-stars'}"></i>`;
            darkModeButton.setAttribute('aria-label', isDark ? 'Gunakan mode terang' : 'Gunakan mode gelap');
        }
        if (darkToggle) {
            darkToggle.innerHTML = `<i class="bi bi-${isDark ? 'sun' : 'moon-stars-fill'}"></i>`;
        }
        if (themeSwitch) themeSwitch.checked = isDark;
    };

    const savedTheme = localStorage.getItem('dsp-theme') || localStorage.getItem('theme');
    setTheme(savedTheme === 'dark');

    darkModeButton?.addEventListener('click', () => setTheme(!document.body.classList.contains('dark')));
    darkToggle?.addEventListener('click', () => setTheme(!document.body.classList.contains('dark')));
    themeSwitch?.addEventListener('change', (event) => setTheme(event.target.checked));

    /* =============================
       SIDEBAR TOGGLE / COLLAPSE
    ============================= */
    const toggleSidebar = () => {
        if (window.innerWidth <= 992) {
            sidebar?.classList.toggle('show');
        } else {
            sidebar?.classList.toggle('collapse');
        }
    };
    menuToggle?.addEventListener('click', toggleSidebar);
    sidebarToggle?.addEventListener('click', toggleSidebar);

    document.addEventListener('click', (event) => {
        if (window.innerWidth <= 992 && sidebar?.classList.contains('show')
            && !sidebar?.contains(event.target) && !menuToggle?.contains(event.target)
            && !sidebarToggle?.contains(event.target)) {
            sidebar.classList.remove('show');
        }
    });

    /* =============================
       GREETING
    ============================= */
    const greeting = document.getElementById('greeting');
    if (greeting) {
        const hour = new Date().getHours();
        const timeGreeting = hour < 11 ? 'Selamat pagi' : hour < 15 ? 'Selamat siang' : hour < 18 ? 'Selamat sore' : 'Selamat malam';
        greeting.textContent = `${timeGreeting}, ${greeting.dataset.name || 'Pengguna'} 👋`;
    }
});

/* =============================
   LOADING SCREEN
============================= */
window.addEventListener('load', () => {
    const loading = document.getElementById('loadingScreen');
    if (loading) {
        setTimeout(() => loading.classList.add('fade-out'), 400);
        setTimeout(() => loading.remove(), 900);
    }
});

/* =============================
   TOAST AUTO-DISMISS
============================= */
document.querySelectorAll('.toast-modern').forEach((toast) => {
    setTimeout(() => {
        toast.style.transition = 'opacity .4s ease, transform .4s ease';
        toast.style.opacity = '0';
        toast.style.transform = 'translateX(120%)';
        setTimeout(() => toast.remove(), 400);
    }, 3500);
});
