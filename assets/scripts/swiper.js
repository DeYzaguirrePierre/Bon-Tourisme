import Swiper from "swiper/bundle"; // Import Swiper avec tous les modules

document.addEventListener("DOMContentLoaded", () => {
  console.log("Swiper script loaded");

  const sliders = document.querySelectorAll(".mySwiper");

  sliders.forEach((slider) => {
    if (slider instanceof HTMLElement) {
      console.log("Initializing Swiper for:", slider);

      new Swiper(slider, {
        slidesPerView: 3,
        spaceBetween: 20,
        navigation: {
          nextEl: ".swiper-button-next",
          prevEl: ".swiper-button-prev",
        },
        pagination: {
          el: ".swiper-pagination",
          clickable: true,
        },
        breakpoints: {
          640: {
            slidesPerView: 1,
          },
          768: {
            slidesPerView: 2,
          },
          1024: {
            slidesPerView: 1,
          },
        },
      });
    } else {
      console.warn("Slider is not an HTMLElement:", slider);
    }
  });
});
