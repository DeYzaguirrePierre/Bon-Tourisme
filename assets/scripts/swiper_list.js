// @ts-nocheck
document.addEventListener("DOMContentLoaded", () => {
  console.log("Swiper script for list initialized.");

  const mainSlider = new Swiper(".mySwiper2", {
    loop: true,
    spaceBetween: 30,
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
  });

  const panelImage = document.getElementById("active-slide-image");
  const panelTitle = document.getElementById("active-slide-title");
  const panelDescription = document.getElementById("active-slide-description");

  if (panelImage && panelTitle && panelDescription) {
    mainSlider.on("slideChange", () => {
      const activeSlide = mainSlider.slides[mainSlider.activeIndex];
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
    });
  }
});
