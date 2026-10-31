import { all, on, ready } from "../../../dom.js";

ready(() => {
  on("#questions .block", "click", function () {
    all(".cbx-mirror", this.closest(".question")).forEach((el) => (el.checked = false));
    all(".cbx-mirror", this).forEach((el) => {
      el.checked = true;
      el.dispatchEvent(new Event("change", { bubbles: true }));
    });
  });
});
