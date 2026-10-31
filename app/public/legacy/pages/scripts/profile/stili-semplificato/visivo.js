const startButtonSelector = ".js-start";
const imagesSelector = ".js-images";
const answersSelector = ".js-answers";
const imageSetSelector = ".js-image-set";

document.addEventListener("DOMContentLoaded", function () {
  const images = document.querySelector(imagesSelector);
  const answers = document.querySelector(answersSelector);
  const startButton = document.querySelector(startButtonSelector);
  const setCount = document.querySelectorAll(imageSetSelector).length;

  const speed = 6000;

  let activeSet = 0;

  startButton.addEventListener("click", () => {
    startButton.classList.add("inactive");
    images.classList.add("active");

    runActivity();

    setInterval(() => {
      runActivity();

      if (activeSet == setCount) {
        clearInterval(this);

        setTimeout(function () {
          images.classList.remove("active");
          answers.classList.add("active");
        }, speed);
      }
    }, speed);
  });

  function runActivity() {
    activeSet++;

    document.querySelectorAll(imageSetSelector).forEach((element) => {
      element.classList.remove("active");
    });

    document
      .querySelector(imageSetSelector + ":nth-child(" + activeSet + ")")
      .classList.add("active");
    document.querySelector('.js-audio[data-id="' + activeSet + '1"]').play();

    setTimeout(function () {
      document.querySelector('.js-audio[data-id="' + activeSet + '2"]').play();
    }, speed / 2);
  }
});
