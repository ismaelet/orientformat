import { all, on, ready } from "../../../dom.js";

ready(() => {
  on(".score", "click", function () {
    all(".filler-inp", this.closest(".score-box")).forEach((el) => {
      el.checked = false;
      el.dispatchEvent(new Event("change", { bubbles: true }));
    });
    all(".filler-inp", this).forEach((el) => {
      el.checked = true;
      el.dispatchEvent(new Event("change", { bubbles: true }));
    });
  });
});
