document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll(".js-show-loading-panel").forEach((element) => {
    element.addEventListener("click", () => {
      document.querySelector(".js-loading-panel").classList.add("active");
    });
  });
});
