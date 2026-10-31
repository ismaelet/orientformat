import { all, on, ready } from "../../../dom.js";

ready(() => {
  on(".answer", "click", function () {
    const question = this.closest(".question-box");
    all(".cbx-mirror", question).forEach((input) => (input.checked = false));
    all(".cbx-mirror", this).forEach((input) => {
      input.checked = true;
      input.dispatchEvent(new Event("change", { bubbles: true }));
    });
    document
      .getElementById("question" + (Number(question.dataset.id) + 1))
      ?.scrollIntoView({ behavior: "smooth" });
  });
});
