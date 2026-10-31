$(document).ready(function () {
  $(".graph-col").each(function () {
    update($(this));
  });

  //score
  $(".graph-ele:not(.disabled)").click(function () {
    const self = $(this);
    const val = self.data("val");

    //set the score
    self
      .parent()
      .find(".graph-ele")
      .each(function () {
        if ($(this).data("val") <= val) {
          $(this).addClass("active");
        } else {
          $(this).removeClass("active");
        }

        if ($(this).data("val") == val) {
          $(this).addClass("last");
        } else {
          $(this).removeClass("last");
        }
      });

    self.parents(".graph-col").find("input").val(val).change();
  });

  $(".graph-ele:not(.disabled)").hover(
    function () {
      const self = $(this);
      const val = self.data("val");

      //set the score
      self
        .parent()
        .find(".graph-ele")
        .each(function () {
          if ($(this).data("val") <= val) {
            $(this).addClass("active");
          } else {
            $(this).removeClass("active");
          }

          if ($(this).data("val") == val) {
            $(this).addClass("last");
          } else {
            $(this).removeClass("last");
          }
        });
    },
    function () {
      update($(this).parents(".graph-col"));
    },
  );

  function update(column) {
    const val = column.find("input").val();

    //set the score
    column.find(".graph-ele").each(function () {
      if ($(this).data("val") <= val) {
        $(this).addClass("active");
      } else {
        $(this).removeClass("active");
      }

      if ($(this).data("val") == val) {
        $(this).addClass("last");
      } else {
        $(this).removeClass("last");
      }
    });
  }

  // description
  $(".ele-box").hover(
    function () {
      const id = parseInt($(this).parents(".graph-col").data("id"));

      document.querySelectorAll(".js-field-info").forEach((element) => {
        element.classList.remove("active");
      });

      document.querySelector('.js-field-info[data-id="' + id + '"]').classList.add("active");
    },
    function () {
      document.querySelectorAll(".js-field-info").forEach((element) => {
        element.classList.remove("active");
      });
    },
  );
});
