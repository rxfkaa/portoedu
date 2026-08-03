/* ==========================================
   PortoEdu Landing Page
========================================== */

document.addEventListener("DOMContentLoaded", function () {

    // ==========================
    // Navbar Scroll Effect
    // ==========================

    const navbar = document.querySelector(".landing-navbar");

    window.addEventListener("scroll", function () {

        if (window.scrollY > 50) {

            navbar.style.background = "#0f172a";

            navbar.style.padding = "12px 0";

            navbar.style.boxShadow = "0 10px 30px rgba(0,0,0,.15)";

        } else {

            navbar.style.background = "rgba(15,23,42,.85)";

            navbar.style.padding = "18px 0";

            navbar.style.boxShadow = "none";

        }

    });

    // ==========================
    // Counter Animation
    // ==========================

    const counters = document.querySelectorAll(".hero-counter h3");

    counters.forEach(counter => {

        const target = parseInt(counter.innerText);

        let count = 0;

        const speed = target / 80;

        const updateCounter = () => {

            if (count < target) {

                count += speed;

                counter.innerText = Math.ceil(count) + "+";

                requestAnimationFrame(updateCounter);

            } else {

                counter.innerText = target + "+";

            }

        }

        updateCounter();

    });

    // ==========================
    // Fade In Animation
    // ==========================

    const observer = new IntersectionObserver(entries => {

        entries.forEach(entry => {

            if (entry.isIntersecting) {

                entry.target.classList.add("show");

            }

        });

    }, {

        threshold: .2

    });

    document.querySelectorAll(".feature-card,.about-section,.cta-section").forEach(el => {

        el.classList.add("hidden");

        observer.observe(el);

    });

});

/* ==========================================
Typing Effect
========================================== */

const words = [

    "Portfolio Digital",

    "Prestasi Terbaik",

    "Project Keren",

    "Sertifikat",

    "Karier Masa Depan"

];

let index = 0;

const typing = document.getElementById("typingText");

setInterval(() => {

    index++;

    if(index >= words.length){

        index = 0;

    }

    typing.style.opacity = 0;

    setTimeout(()=>{

        typing.innerHTML = words[index];

        typing.style.opacity = 1;

    },250);

},2500);

/* ==========================================
Back To Top
========================================== */

const topButton = document.getElementById("backToTop");

window.addEventListener("scroll",()=>{

if(window.scrollY>400){

topButton.classList.add("show");

}else{

topButton.classList.remove("show");

}

});

topButton.addEventListener("click",()=>{

window.scrollTo({

top:0,

behavior:"smooth"

});

});

/* ==========================================
Hero Image 3D
========================================== */

const heroImage=document.querySelector(".hero-image");

document.addEventListener("mousemove",(e)=>{

const x=(window.innerWidth/2-e.clientX)/35;

const y=(window.innerHeight/2-e.clientY)/35;

heroImage.style.transform=`rotateY(${x}deg) rotateX(${-y}deg)`;

});

/* ==========================================
Smooth Anchor
========================================== */

document.querySelectorAll('a[href^="#"]').forEach(anchor=>{

anchor.addEventListener("click",function(e){

e.preventDefault();

const target=document.querySelector(this.getAttribute("href"));

if(target){

target.scrollIntoView({

behavior:"smooth"

});

}

});

});