document.addEventListener("DOMContentLoaded", function() {
    let slides = document.querySelectorAll("#slideshow img");
    let currentSlide = 0;
  
    // Function to go to the next slide
    function nextSlide() {
      // Fade out the current slide
      slides[currentSlide].style.opacity = 0;
  
      // Increment `currentSlide`, reset if at the end
      currentSlide = (currentSlide + 1) % slides.length;
  
      // Fade in the next slide
      slides[currentSlide].style.opacity = 1;
    }
  
    // Set the interval for changing slides
    setInterval(nextSlide, 4000); // Change slide every 4 seconds
  });
  
