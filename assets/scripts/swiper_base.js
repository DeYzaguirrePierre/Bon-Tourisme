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
    slidesPerView: 4,
    spaceBetween: 70,
  });
});
