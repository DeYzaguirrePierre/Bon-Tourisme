// @ts-nocheck
document.addEventListener("DOMContentLoaded", () => {
  console.log("Swiper script for list initialized.");

  const mainSlider = new Swiper(".mySwiper2", {
    grabCursor: true,
    slidesPerView: 4, // Ajusté pour éviter le débordement
    spaceBetween: 70, // Ajuste l'espace entre les slides
    centeredSlides: true, // Permet de bien centrer la slide active
    initialSlide: 0, // Active la première slide par défaut
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
  });

  const panelImage = document.getElementById("active-slide-image");
  const panelTitle = document.getElementById("active-slide-title");
  const panelDescription = document.getElementById("active-slide-description");

  function updateActiveSlide(slider) {
    const activeSlide = slider.slides[slider.realIndex]; // `realIndex` empêche les glitchs
    if (activeSlide) {
      const imgElement = activeSlide.querySelector("img");
      if (imgElement) {
        panelImage.src = imgElement.src;
        panelImage.alt = imgElement.alt;
      }
      const name = activeSlide.getAttribute("data-name");
      const description = activeSlide.getAttribute("data-description");

      if (name) panelTitle.textContent = name;
      if (description) panelDescription.textContent = description;
    }
  }

  // Met à jour le panneau actif à chaque changement de slide
  mainSlider.on("slideChange", () => {
    updateActiveSlide(mainSlider);
  });

  // Permet de cliquer sur une slide pour la rendre active
  document.querySelectorAll(".swiper-slide").forEach((slide, index) => {
    slide.addEventListener("click", () => {
      mainSlider.slideTo(index, 500, false); // Passe à l'index cliqué avec transition fluide
    });
  });

  // Initialise l'affichage du panneau au premier chargement
  updateActiveSlide(mainSlider);
});
