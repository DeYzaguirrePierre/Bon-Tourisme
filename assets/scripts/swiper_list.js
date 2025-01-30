// @ts-nocheck
document.addEventListener("DOMContentLoaded", () => {
  console.log("Swiper script for list initialized.");

  const mainSlider = new Swiper(".mySwiper2", {
    grabCursor: true,
    slidesPerView: 4,
    spaceBetween: 70,
    centeredSlides: true,
    initialSlide: 0,
  });

  const panelImage = document.getElementById("active-slide-image");
  const panelTitle = document.getElementById("active-slide-title");
  const panelDescription = document.getElementById("active-slide-description");
  const panelRating = document.getElementById("active-slide-rating");
  const panelReviews = document.getElementById("active-slide-reviews");

  function updateActiveSlide(slider) {
    const activeSlide = slider.slides[slider.realIndex];

    if (activeSlide) {
      const imgElement = activeSlide.querySelector("img");
      if (imgElement) {
        panelImage.src = imgElement.src;
        panelImage.alt = imgElement.alt;
      }

      const name = activeSlide.getAttribute("data-name");
      const description = activeSlide.getAttribute("data-description");
      const rating = parseFloat(activeSlide.getAttribute("data-rating"));
      const reviews = activeSlide.getAttribute("data-reviews");

      if (name) panelTitle.textContent = name;
      if (description) panelDescription.textContent = description;
      if (reviews) panelReviews.textContent = `(${reviews} avis)`;

      // **Forcer la mise à jour des étoiles**
      if (panelRating) {
        panelRating.innerHTML = ""; // **Vider le contenu actuel pour éviter les duplications**
        panelRating.innerHTML = generateStars(rating);
      }
    }
  }

  function generateStars(rating) {
    let starsHtml = "";
    for (let i = 1; i <= 5; i++) {
      if (i <= rating) {
        starsHtml += '<i class="fas fa-star text-yellow-500 text-xl"></i>';
      } else if (i - 0.5 <= rating) {
        starsHtml +=
          '<i class="fas fa-star-half-alt text-yellow-500 text-xl"></i>';
      } else {
        starsHtml += '<i class="far fa-star text-gray-300 text-xl"></i>';
      }
    }
    return starsHtml;
  }

  mainSlider.on("slideChange", () => {
    setTimeout(() => updateActiveSlide(mainSlider), 100);
  });

  document.querySelectorAll(".swiper-slide").forEach((slide, index) => {
    slide.addEventListener("click", () => {
      mainSlider.slideTo(index, 500, false);
      setTimeout(() => updateActiveSlide(mainSlider), 100);
    });
  });

  updateActiveSlide(mainSlider);
});
