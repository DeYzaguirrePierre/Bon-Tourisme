import "./styles/app.css"; // Importez vos styles
import "slick-carousel/slick/slick.css";
import "slick-carousel/slick/slick-theme.css";
import $ from "jquery";
import "slick-carousel";

$(document).ready(function () {
  $(".your-slider-class").slick({
    infinite: true,
    slidesToShow: 3,
    slidesToScroll: 1,
  });
});
