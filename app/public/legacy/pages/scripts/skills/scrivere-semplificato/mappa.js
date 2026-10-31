$(document).ready(function () {
  $(".square").hover(
    function () {
      const self = $(this);
      const horizontal = "." + self.data("hor");
      const vertical = "." + self.data("ver");

      $(".type" + horizontal + vertical).addClass("active");
      $(".category").addClass("blur");
      $(".category" + horizontal)
        .removeClass("blur")
        .addClass("active");
      $(".category" + vertical)
        .removeClass("blur")
        .addClass("active");
    },
    function () {
      $(".type").removeClass("active");
      $(".category").removeClass("active").removeClass("blur");
    },
  );
});
