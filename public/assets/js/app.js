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

document.addEventListener("DOMContentLoaded", () => {

    console.log("Project Module Loaded");

});

document.addEventListener("DOMContentLoaded", function(){

const sidebar=document.querySelector(".sidebar");

const btn=document.getElementById("toggleSidebar");

if(btn){

btn.addEventListener("click",()=>{

sidebar.classList.toggle("collapse");

});

}

});

// ===========================
// DARK MODE
// ===========================

const darkBtn=document.getElementById("darkToggle");

if(localStorage.theme==="dark"){

document.body.classList.add("dark-mode");

}

darkBtn?.addEventListener("click",()=>{

document.body.classList.toggle("dark-mode");

if(document.body.classList.contains("dark-mode")){

localStorage.theme="dark";

}else{

localStorage.theme="light";

}

});

/* ======================================
Dashboard Chart
====================================== */

const chartCanvas = document.getElementById("achievementChart");

if(chartCanvas){

new Chart(chartCanvas,{

type:"line",

data:{

labels:[

"Jan",

"Feb",

"Mar",

"Apr",

"Mei",

"Jun",

"Jul"

],

datasets:[{

label:"Prestasi",

data:[

1,

3,

4,

6,

8,

10,

12

],

fill:true,

borderColor:"#2563eb",

backgroundColor:"rgba(37,99,235,.15)",

tension:.4

}]

},

options:{

responsive:true,

plugins:{

legend:{

display:false

}

},

scales:{

y:{

beginAtZero:true

}

}

}

});

}
