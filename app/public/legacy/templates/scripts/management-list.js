$(document).ready(function () {
  $("#body .search-bar .icon-box").click(function () {
    $(this).parent().find("button").click();
  });

  $("#body .search-bar .inp").focus(function () {
    $(this).parent().addClass("active");
  });

  $("#body .search-bar .inp").blur(function () {
    $(this).parent().removeClass("active");
  });
});
