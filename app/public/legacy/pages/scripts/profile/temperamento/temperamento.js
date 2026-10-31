$(document).ready(function () {
  const count = $(".js-count").data("count");

  var pos = 1;

  $(".dot").click(function () {
    const self = $(this);
    const block = self.parents(".score");

    $(".dot").removeClass("active");
    self.addClass("active");
    block.find(".confirm").addClass("active");
    block.find(".field").val(self.data("score"));
  });

  $(".confirm").click(function () {
    $(".score").removeClass("active");

    $("#score" + pos).addClass("done");

    if (pos == count) {
      $("#submit").click();
    } else {
      pos++;

      $("#score" + pos).addClass("active");
    }
  });
});
