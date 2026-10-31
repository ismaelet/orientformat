const drawingWrapperSelector = ".js-drawing-wrapper";
const characterSelector = ".js-character";
const layerSelector = ".js-layer";
const infoSelector = ".js-drawing-info";
const infoTextSelector = ".js-info-text";
const selectedInfoSelector = ".js-selected-info";
const selectedInfoTextSelector = ".js-selected-info-text";

document.addEventListener("DOMContentLoaded", function () {
  const drawingWapper = document.querySelector(drawingWrapperSelector);
  const info = document.querySelector(infoSelector);
  const selectedInfo = document.querySelector(selectedInfoSelector);
  const selectedInfoText = document.querySelector(selectedInfoTextSelector);

  document.querySelectorAll(characterSelector).forEach((element) => {
    element.addEventListener("mouseenter", () => {
      const id = element.dataset.id;
      const infoText = document.querySelector(infoTextSelector + '[data-id="' + id + '"]').value;

      document.querySelector(layerSelector + '[data-id="' + id + '"]').classList.add("hovering");

      info.innerHTML = infoText;
      info.classList.add("active");
    });

    element.addEventListener("mouseleave", () => {
      document.querySelectorAll(layerSelector).forEach((element) => {
        element.classList.remove("hovering");
        info.classList.remove("active");
      });
    });

    element.addEventListener("mousemove", (e) => {
      var rect = drawingWapper.getBoundingClientRect();
      var x = e.clientX - rect.left;
      var y = e.clientY - rect.top;

      if (x < drawingWapper.clientWidth / 2) {
        info.style.translate = x + 16 + "px " + y + "px";
      } else {
        info.style.translate = "calc(-100% + " + (x - 16) + "px) " + y + "px";
      }
    });
  });

  document.querySelectorAll(fieldInput).forEach((element) => {
    element.addEventListener("change", () => {
      const id = element.value;
      const infoText = document.querySelector(infoTextSelector + '[data-id="' + id + '"]').value;

      // selectedInfoText.innerHTML = '<span>' + id + '.</span> ' + infoText
      selectedInfoText.innerHTML = infoText;
      selectedInfo.classList.add("active");
    });
  });
});
