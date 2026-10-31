import { all, one, on, ready, setField, show, hide } from "../../../dom.js";

ready(() => {
  let pos = 1;
  const count = Number(one(".js-count")?.dataset.count);
  on(".answer", "click", function () {
    const question = this.parentElement;
    const correct = this.dataset.answer === question.dataset.answer;
    all(".result").forEach(hide);
    show(one(correct ? ".result.right" : ".result.wrong"));
    pos = correct ? pos + 1 : 1;
    if (correct) all(".filler-inp", question).forEach((el) => setField(el, this.dataset.answer));
    else all(".filler-inp").forEach((el) => setField(el, 0));
    all(".question").forEach((el) => el.classList.toggle("active", el.id === "question" + pos));
    if (pos > count) {
      all(".result").forEach(hide);
      show(one("#end"));
    }
  });
});
