$(window).ready(function () {
  $(".info-icon").click(function () {
    $(this).parents(".section").find(".section-info").toggleClass("active");
  });
});
