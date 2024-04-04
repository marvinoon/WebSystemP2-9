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
    activateMenu();
  });

  document.addEventListener("DOMContentLoaded", function() {
    const bookContent = document.getElementById('textContent');
    const pageNumberSpan = document.getElementById('pageNumber');
    let currentPage = 1;
    let totalPages = 1;

    function updatePagination() {
        const pageHeight = bookContent.offsetHeight;
        const contentHeight = bookContent.scrollHeight;
        totalPages = Math.ceil(contentHeight / pageHeight);
        updatePageNumber();
    }

    function updatePageNumber() {
        pageNumberSpan.innerText = `Page ${currentPage} of ${totalPages}`;
    }

    function flipPage(direction) {
        // Calculate new page number within bounds
        const newPage = currentPage + direction;
        if (newPage >= 1 && newPage <= totalPages) {
            currentPage = newPage;
            // Scroll the content to the new page position
            const newPosition = (currentPage - 1) * bookContent.offsetHeight;
            bookContent.scrollTop = newPosition;
            updatePageNumber();
        }
    }

    // Initial setup
    updatePagination();

    // Event listeners for pagination buttons
    document.getElementById('nextPage').addEventListener('click', function() {
        flipPage(1);
    });

    document.getElementById('prevPage').addEventListener('click', function() {
        flipPage(-1);
    });

    // Optional: Re-calculate pagination if the window resizes
    window.addEventListener('resize', updatePagination);
});
  
  
  function activateMenu()
  { 
      const navLinks = document.querySelectorAll('nav a');
      navLinks.forEach(link =>
      {   
          if (link.href === location.href)
          { 
            link.classList.add('active');
          } 
      });
  } 




