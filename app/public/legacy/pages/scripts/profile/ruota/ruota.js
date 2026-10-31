document.addEventListener("DOMContentLoaded", function () {
  const arrow = document.querySelector(".js-arrow");
  const fieldEmotion = document.querySelector(".js-field-emotion");
  const fieldIntensity = document.querySelector(".js-field-intensity");

  let free = fieldEmotion.value ? false : true;

  if (fieldEmotion.value) {
    emotion = document.querySelector(
      '.js-emotion[data-emotion="' +
        fieldEmotion.value +
        '"], .chosen[data-emotion="' +
        fieldEmotion.value +
        '"]',
    );
    fixedArrow(emotion);
  }

  function getCenter(element) {
    const { left, top, width, height } = element.getBoundingClientRect();

    return { x: left + width / 2, y: top + height / 2 };
  }

  function fixedArrow(element) {
    const arrowCenter = getCenter(arrow);
    const elementCenter = getCenter(element);
    const angle = Math.atan2(elementCenter.y - arrowCenter.y, elementCenter.x - arrowCenter.x);

    arrow.style.transition = `transform .4s`;
    arrow.style.transform = `rotate(${angle}rad)`;
  }

  document.querySelector(".js-wheel").addEventListener("mousemove", ({ clientX, clientY }) => {
    const arrowCenter = getCenter(arrow);
    const angle = Math.atan2(clientY - arrowCenter.y, clientX - arrowCenter.x);

    if (free) {
      arrow.style.transform = `rotate(${angle}rad)`;
    }
  });

  document.querySelectorAll(".js-emotion-dot").forEach((element) => {
    element.addEventListener("click", () => {
      const emotion = element.closest(".js-emotion");

      document.querySelectorAll(".js-emotion").forEach((emotionElement) => {
        if (emotionElement != emotion) {
          emotionElement.classList.remove("active");
        }
      });

      emotion.classList.toggle("active");
    });
  });

  document.querySelectorAll(".js-emotion-score").forEach((element) => {
    element.addEventListener("click", () => {
      const event = new Event("change");
      const emotion = element.closest(".js-emotion");
      const emotionName = emotion.dataset.emotion;
      const emotionValue = element.dataset.value;

      fieldEmotion.value = emotionName;
      fieldIntensity.value = emotionValue;

      fieldEmotion.dispatchEvent(event);

      document.querySelectorAll(".js-emotion-value").forEach((element) => {
        element.innerHTML = "";
      });

      document.querySelectorAll(".js-emotion").forEach((element) => {
        element.classList.remove("chosen");
      });

      emotion.querySelector(".js-emotion-value").innerHTML = emotionValue;
      emotion.dataset.intensity = emotionValue;
      emotion.classList.add("chosen");
      emotion.classList.remove("active");

      free = false;

      fixedArrow(emotion);
    });
  });
});
