document.addEventListener("DOMContentLoaded", function () {
  const sliders = document.querySelectorAll(".slider");

  sliders.forEach((slider) => {
    slider.addEventListener("wheel", function (event) {
      // Cast explicitement l'événement en WheelEvent pour garantir que deltaY est reconnu
      const wheelEvent = /** @type {WheelEvent} */ (event);

      wheelEvent.preventDefault();
      slider.scrollBy({
        left: wheelEvent.deltaY < 0 ? -300 : 300,
        behavior: "smooth",
      });
    });
  });
});
