document.addEventListener("DOMContentLoaded", function () {
  const scoreInput = document.querySelector(".js-score");

  let score = 0;

  document.querySelectorAll(".js-pattern").forEach((element) => {
    element.addEventListener("click", () => {
      if (!element.classList.contains("selected")) {
        element.classList.add("selected");

        score++;

        scoreInput.value = score;
      }
    });
  });
});
