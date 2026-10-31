$(document).ready(function () {
  fix_height();

  $(window).resize(function () {
    fix_height();
  });

  function fix_height() {
    if ($(window).width() > $(window).height()) {
      $("#slider").css("height", "calc(100vh - " + $("header").outerHeight() + "px)");
    } else if ($(window).width() <= 400) {
      $("#slider").css("min-height", $(window).height() - $("header").outerHeight() + "px");
    } else if ($(window).width() <= 480) {
      $("#slider").css("min-height", $(window).height() - $("header").outerHeight() - 120 + "px");
    } else {
      $("#slider").css("height", "auto");
    }
  }
});
