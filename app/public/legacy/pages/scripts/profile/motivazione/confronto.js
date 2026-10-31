$(document).ready(function () {
  $(".filler-inp").focus(function () {
    $(this).prev().addClass("focus");
  });
  $(".filler-inp").blur(function () {
    $(this).prev().removeClass("focus");
  });
});
