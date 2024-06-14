document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector(".search-form");
    form.addEventListener("submit", function(event) {
        event.preventDefault();
        form.submit();
        setTimeout(function() {
            document.getElementById("results").scrollIntoView({ behavior: 'smooth' });
        }, 500); 
    });
});

let slideIndex = 0;
const slides = document.querySelectorAll('.slide');

function showSlides() {
    slides.forEach((slide, index) => {
        slide.style.display = index === slideIndex ? 'block' : 'none';
    });
    slideIndex = (slideIndex + 1) % slides.length;
    setTimeout(showSlides, 3000);
}

document.addEventListener('DOMContentLoaded', showSlides);
