let subMenu = document.getElementById("subMenu");

    function toggleMenu() {
      subMenu.classList.toggle("open-menu");
    }

    document.addEventListener("DOMContentLoaded", function() {
      let slides = document.querySelectorAll('.slide');
      let currentSlide = 0;
      let slideInterval = setInterval(nextSlide, 5000); // Change slide every 5 seconds

      function nextSlide() {
          slides[currentSlide].classList.remove('active');
          currentSlide = (currentSlide + 1) % slides.length;
          slides[currentSlide].classList.add('active');
      }
    });

    function prevSlide() {
        slides[currentSlide].classList.remove('active');
        currentSlide = (currentSlide - 1 + slides.length) % slides.length;
        slides[currentSlide].classList.add('active');
    }


    