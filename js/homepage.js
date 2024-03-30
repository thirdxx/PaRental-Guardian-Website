document.addEventListener('DOMContentLoaded', function() {
  const slideshowImage = document.getElementById('slideshow-image');
  const slideshowImages = document.querySelectorAll('.slideshow-images img');
  let currentIndex = 0;

  function showImage(index) {
    slideshowImage.src = slideshowImages[index].src;
  }

  function nextSlide() {
    currentIndex = (currentIndex + 1) % slideshowImages.length;
    showImage(currentIndex);
  }

  // Show the first image initially
  showImage(currentIndex);

  // Start the slideshow
  setInterval(nextSlide, 2000); // Change 2000 to adjust the slideshow speed (in milliseconds)
});
