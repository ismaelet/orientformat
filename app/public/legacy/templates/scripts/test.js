$(document).ready(function () {
  /**
   * Fill submit button
   */
  const count = $(".js-count").data("count");

  fill_submit();

  $(".filler-inp, .js-field").keyup(function () {
    fill_submit();
  });
  $(".filler-inp, .js-field").on("change", function () {
    fill_submit();
  });
  $(".no-filler-inp").keyup(function () {
    static_submit();
  });
  $(".no-filler-inp").on("change", function () {
    static_submit();
  });

  function fill_submit() {
    var i = 0;

    $(".filler-inp, .js-field").each(function () {
      if ($(this).is(":checkbox") || $(this).is(":radio")) {
        if ($(this).prop("checked")) {
          i++;
        }
      } else {
        if ($(this).val() && $(this).val() != "0") {
          i++;
        }
      }
    });

    $(".js-progressive-submit-button").css("--progress", (i / count) * 100 + "%");
    $(".js-progressive-submit-button").prop("disabled", !(i == count));

    $(".skip").prop("disabled", i == count);
  }

  function static_submit() {
    var i = 0;

    $(".no-filler-inp").each(function () {
      if ($(this).val() > 0) {
        i++;
      }
    });

    $("#submit.progress .btn-fill").addClass("static");
    $("#submit.progress").prop("disabled", !(i == count));
    if (i == count) {
      $("#submit.progress .btn-fill").css("width", "100%");
    } else {
      $("#submit.progress .btn-fill").css("width", "0");
    }
    $(".skip").prop("disabled", i == count);
  }

  /*** Quiz ***/
  if ($(".quiz-cont").length) {
    var start = false;
    var max = $(".quiz-cont").data("max");
    var pos = $(".quiz-cont").data("pos");
    var locked = $(".quiz-cont").data("locked");
    var posMax = pos;

    //set up
    slide_quiz();
    arrow_enabler();

    $(window).resize(function () {
      $(".quiz-cont").css("top", 0);

      slide_quiz();
    });

    //on arrow click
    $(".quiz-arr").click(function () {
      if (!$(this).hasClass("disabled")) {
        $(".quiz-cont").removeClass("no-trans");

        if ($(this).hasClass("top")) {
          pos++;

          if (pos > posMax) {
            posMax = pos;
          }
        } else {
          pos--;
        }

        slide_quiz();
        arrow_enabler();
      }
    });

    //on answering
    $(".quiz-cbx").on("change", function () {
      const self = $(this);
      const question = self.parents(".quiz");

      if (!self.prop("disabled") && !locked) {
        //enable slide transition
        $(".quiz-cont").removeClass("no-trans");

        //select the answer
        question.find(".quiz-cbx").prop("checked", false);

        self.prop("checked", true);

        question.find(".field").val(self.val()).change();

        //slide
        if (pos < max) {
          pos++;

          if (pos > posMax) {
            posMax = pos;
          }

          slide_quiz();
          arrow_enabler();
        }
      }
    });

    //slide the panel
    function slide_quiz() {
      const box = $(".quiz-cont");
      const panel = $(".quiz-pan");
      const ele = $("#quiz" + pos);

      var last = pos;
      var i = 0;
      var top = -ele.position().top;

      box.css("top", top + "px");

      $(".quiz").removeClass().addClass("step0").addClass("quiz");
      ele.removeClass("step0").addClass("active");

      if (!locked) {
        $(".quiz-cbx").prop("disabled", true);

        $(".quiz")
          .not("#quiz" + pos)
          .find(".quiz-scor-box")
          .addClass("disabled");

        ele.find(".quiz-scor-box").removeClass("disabled");

        ele.find(".quiz-cbx").prop("disabled", false);
      }

      while (i < 3) {
        i++;

        if ($("#quiz" + (pos - i)).length) {
          $("#quiz" + (pos - i)).removeClass("step0");
          $("#quiz" + (pos - i)).addClass("step" + i);

          last = pos - i;
        }
      }

      var lastPos = $("#quiz" + last).position().top + $("#quiz" + last).outerHeight() + top;

      panel.css("height", lastPos + "px");

      if (!start) {
        $(".quiz").addClass("no-trans");
      }
    }

    function arrow_enabler() {
      if (pos == posMax) {
        $(".quiz-arr.top").addClass("disabled");
      } else {
        $(".quiz-arr.top").removeClass("disabled");
      }

      if (pos == 1) {
        $(".quiz-arr.bot").addClass("disabled");
      } else {
        $(".quiz-arr.bot").removeClass("disabled");
      }
    }
  }

  //timer
  var time = 0;

  window.setInterval(function () {
    time++;

    $(".js-time-passed").val(time);
  }, 1000);
});
