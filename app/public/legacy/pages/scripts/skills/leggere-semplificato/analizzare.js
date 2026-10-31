$(document).ready(function () {
  var selecting = false;
  var type = "none";

  //start selecting
  $(".selector").click(function () {
    const self = $(this);

    if (!self.hasClass("disabled")) {
      $(".selector").removeClass("active");

      self.addClass("active");

      selecting = true;

      $("#text").removeClass(type);

      type = self.data("select");

      $("#text").addClass("selecting").addClass(type);
    }
  });

  //click on a selector
  $(".selectable").click(function () {
    const self = $(this);
    const selector = $(".selector." + type);
    const count = selector.data("count") - 1;

    if (selecting) {
      if (self.data("type") == type) {
        self.addClass("active");

        selector.data("count", count);

        if (!count) {
          selector.addClass("disabled");
        }

        $(".inp-" + type + ".inactive")
          .first()
          .removeClass("inactive")
          .val(1)
          .change();
      }
    }
  });

  //click on the text
  $("#text").click(function () {
    selecting = false;

    $("#text").removeClass("selecting");

    $(".selector").removeClass("active");
  });
});
