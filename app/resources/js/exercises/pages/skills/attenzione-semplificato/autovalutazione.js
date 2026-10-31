import { all, one, on, ready, setField } from "../../../dom.js";

ready(() => {
  on(".number", "mouseenter", function () {
    all(".question").forEach((el) =>
      el.classList.toggle("blur", el.id !== "question" + this.dataset.question),
    );
  });
  on(".number", "mouseleave", () => all(".question").forEach((el) => el.classList.remove("blur")));
  on(".number", "click", function () {
    all(".number")
      .filter((el) => el.dataset.question === this.dataset.question)
      .forEach((el) => el.classList.toggle("active", el === this));
    setField(one("#field" + this.dataset.question), this.dataset.val);
  });
});
