document.addEventListener("DOMContentLoaded", function() {
  let currentIndex = 0;
  const slides = document.querySelectorAll(".slider ul li");
  const totalSlides = slides.length;
  const slideWidth = slides[0].offsetWidth;
  const slider = document.querySelector('.slider ul');

  // Move the first slide to the end to create a seamless loop
  const lastSlideClone = slides[0].cloneNode(true);
  slider.appendChild(lastSlideClone);

  function moveToNextSlide() {
    currentIndex = (currentIndex + 1) % (totalSlides + 1); // +1 to account for the cloned last slide
    const newTransformValue = -currentIndex * slideWidth;
    slider.style.transition = 'transform 1s ease-in-out'; // Equal time for each slide
    slider.style.transform = `translateX(${newTransformValue}px)`;
  }

  setInterval(moveToNextSlide, 3000); // Change slide every 5000 milliseconds (5 seconds)

  // Reset transition and move to the next slide when transition ends
  slider.addEventListener('transitionend', function() {
    if (currentIndex === totalSlides) {
      currentIndex = 0;
      slider.style.transition = 'none';
      slider.style.transform = `translateX(0)`;
      setTimeout(() => {
        slider.style.transition = 'transform 1s ease-in-out';
        slider.style.transform = `translateX(-${slideWidth}px)`; // Slide to the second slide with transition
      }, 3000); // Delay the transition to avoid immediate jump
    }
  });
});
