const emptyImageSelector = ".js-empty-image";
const answerSelector = ".js-answer";

document.addEventListener("DOMContentLoaded", function () {
  const answerInput = document.querySelector(fieldInput);

  $(answerSelector).draggable({
    revert: function (event) {
      if (!event) {
        $(this).animate({ top: "0px", left: "0px" }, 100);
      }
    },
  });

  $(emptyImageSelector).droppable({
    accept: answerSelector,

    drop: function (event, ui) {
      const elementId = "#" + ui.draggable.attr("id");
      const element = document.querySelector(elementId);
      const id = element.dataset.id;

      document.querySelectorAll(answerSelector).forEach((element) => {
        element.classList.remove("hidden");
        jqueryElement = $("#" + element.id);
        jqueryElement.animate({ top: "0px", left: "0px" }, 100);
      });

      element.classList.add("hidden");
      document.querySelector(emptyImageSelector).querySelector("img").src =
        element.querySelector("img").src;

      answerInput.value = id;
      answerInput.dispatchEvent(new Event("change"));
    },
  });
});
