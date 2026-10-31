import { on, ready } from "../../../dom.js";

ready(() => {
  on(".filler-inp", "focus", function () {
    this.previousElementSibling?.classList.add("focus");
  });
  on(".filler-inp", "blur", function () {
    this.previousElementSibling?.classList.remove("focus");
  });
});
