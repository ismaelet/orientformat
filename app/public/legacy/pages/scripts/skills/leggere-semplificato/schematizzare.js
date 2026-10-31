$(document).ready(function () {
  $(".cause").draggable({
    revert: function (event) {
      if (!event) {
        $(this).animate({ top: "0px", left: "0px" }, 100);
      }
    },
  });

  $(".droppable").droppable({
    accept: ".cause",

    drop: function (event, ui) {
      const eleID = "#" + ui.draggable.attr("id");
      const ele = $(eleID);

      if ($(this).hasClass("droppable")) {
        const text = ele.find("p").html();

        ele.hide();

        $(this).find(".filler-inp").val(ele.data("id")).change();
        $(this).data("attached", eleID);
        $(this).addClass("active").removeClass("droppable");
        $(this).find("p").html(text);
      } else {
        ele.animate({ top: "0px", left: "0px" }, 100);
      }
    },
  });

  $(".reset").click(function () {
    const box = $(this).parent();
    const ele = $(box.data("attached"));

    box.removeClass("active").addClass("droppable");
    box.find(".filler-inp").val(0).change();

    ele.css("top", 0).css("left", 0);
    ele.show();
  });
});
