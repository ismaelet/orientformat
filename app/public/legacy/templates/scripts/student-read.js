$(document).ready(function () {
  scroll_btn();

  $(window).resize(function () {
    scroll_btn();
  });
  $(window).scroll(function () {
    scroll_btn();
  });

  function scroll_btn() {
    const scrolled = $(window).scrollTop();
    const height = $(window).height();
    const top = $("#content").offset().top;
    const bottom = $("footer").offset().top - height;

    if (scrolled > top) {
      $("#scroll").removeClass("top");
    } else {
      $("#scroll").addClass("top");
    }

    if (scrolled < bottom) {
      $("#scroll").removeClass("bottom");
    } else {
      $("#scroll").addClass("bottom");
    }
  }
});
