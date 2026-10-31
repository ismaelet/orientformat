import { all, one, on, ready, setField } from "../dom.js";

ready(() => {
  const count = Number(one(".js-count")?.dataset.count ?? 0);
  const fields = () => all(".filler-inp,.js-field");
  const progress = () => {
    const completed = fields().filter((input) =>
      ["checkbox", "radio"].includes(input.type)
        ? input.checked
        : input.value !== "" && input.value !== "0",
    ).length;
    all(".js-progressive-submit-button").forEach((button) => {
      button.style.setProperty("--progress", count ? `${(completed / count) * 100}%` : "0%");
      button.disabled = completed !== count;
    });
    all(".skip").forEach((button) => (button.disabled = completed === count));
  };
  on(".filler-inp,.js-field", "input change", progress);
  progress();
  on(".no-filler-inp", "input change", () => {
    const done = all(".no-filler-inp").filter((input) => Number(input.value) > 0).length === count;
    const button = one("#submit.progress");
    if (button) button.disabled = !done;
    all("#submit.progress .btn-fill").forEach((el) => {
      el.classList.add("static");
      el.style.width = done ? "100%" : "0";
    });
    all(".skip").forEach((button) => (button.disabled = done));
  });
  const quiz = one(".quiz-cont");
  if (quiz) {
    let position = Number(quiz.dataset.pos) || 1;
    let maximum = position;
    const total = Number(quiz.dataset.max);
    const locked = ["true", "1"].includes(quiz.dataset.locked);
    const slide = () => {
      const selected = one("#quiz" + position);
      if (!selected) return;
      const top = -selected.offsetTop;
      quiz.style.top = top + "px";
      let last = selected;
      all(".quiz").forEach((element) => {
        element.classList.remove("active", "step0", "step1", "step2", "step3");
        element.classList.add("step0");
        if (!locked) {
          all(".quiz-cbx", element).forEach((input) => (input.disabled = element !== selected));
          all(".quiz-scor-box", element).forEach((box) =>
            box.classList.toggle("disabled", element !== selected),
          );
        }
      });
      selected.classList.remove("step0");
      selected.classList.add("active");
      for (let distance = 1; distance <= 3; distance++) {
        const previous = one("#quiz" + (position - distance));
        if (previous) {
          previous.classList.remove("step0");
          previous.classList.add("step" + distance);
          last = previous;
        }
      }
      one(".quiz-pan")?.style.setProperty(
        "height",
        last.offsetTop + last.getBoundingClientRect().height + top + "px",
      );
      all(".quiz-arr.top").forEach((el) => el.classList.toggle("disabled", position >= maximum));
      all(".quiz-arr.bot").forEach((el) => el.classList.toggle("disabled", position <= 1));
    };
    slide();
    window.addEventListener("resize", slide);
    on(".quiz-arr", "click", function () {
      if (this.classList.contains("disabled")) return;
      position += this.classList.contains("top") ? 1 : -1;
      maximum = Math.max(maximum, position);
      quiz.classList.remove("no-trans");
      slide();
    });
    on(".quiz-cbx", "change", function () {
      if (this.disabled || locked) return;
      const question = this.closest(".quiz");
      all(".quiz-cbx", question).forEach((input) => (input.checked = input === this));
      setField(one(".field", question), this.value);
      if (position < total) {
        position++;
        maximum = Math.max(maximum, position);
        quiz.classList.remove("no-trans");
        slide();
      }
    });
  }
  const timerField = one(".js-time-passed");
  if (timerField) {
    let seconds = 0;
    setInterval(() => (timerField.value = String(++seconds)), 1000);
  }
});
