const selectorItemClass = ".js-test-selector";
const selectableItemClass = ".js-selectable";

document.addEventListener("DOMContentLoaded", function () {
  let selecting = false;
  let type = null;

  // start selecting
  document.querySelectorAll(selectorItemClass).forEach((element) => {
    element.addEventListener("click", () => {
      if (!element.classList.contains("disabled")) {
        $("#text").removeClass(type);

        selecting = true;
        type = element.dataset.type;

        document.querySelectorAll(selectorItemClass).forEach((item) => {
          item.classList.remove("active");
        });

        element.classList.add("active");

        $("#text").addClass("selecting").addClass(type);
      }
    });
  });

  // click on a selector
  document.querySelectorAll(selectableItemClass).forEach((element) => {
    element.addEventListener("click", () => {
      const selector = document.querySelector(selectorItemClass + '[data-type="' + type + '"]');
      const count = selector.dataset.count - 1;

      if (selecting) {
        if (element.dataset.type == type) {
          element.classList.add("active");
          selector.dataset.count = count;

          if (!count) {
            selector.classList.add("disabled");
          }

          $(".inp-" + type + ".inactive")
            .first()
            .removeClass("inactive")
            .val(1)
            .change();
        }
      }
    });
  });

  // click on the text
  $("#text").click(function () {
    selecting = false;

    $("#text").removeClass("selecting");

    $(".js-test-selector").removeClass("active");
  });
});
