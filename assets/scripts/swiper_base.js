// @ts-nocheck
document.addEventListener("DOMContentLoaded", () => {
  console.log("Initializing Swiper for base sliders");

  if (typeof Swiper === "undefined") {
    console.error("Swiper is not defined. Ensure the CDN is included.");
    return;
  }

  new Swiper(".mySwiper", {
    grabCursor: true,
    loop: true,
    centeredSlides: true,
    spaceBetween: 10,
    slidesPerView: 4,
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
  });
});
