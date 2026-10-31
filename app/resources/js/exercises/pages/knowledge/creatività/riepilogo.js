import { all, on, ready } from "../../../dom.js";

ready(() => {
  on(".petal .body", "mouseenter", function () {
    all(".petal").forEach((el) => el.classList.add("blur"));
    this.parentElement.classList.add("active");
    this.parentElement.classList.remove("blur");
  });
  on(".petal .body", "mouseleave", () =>
    all(".petal").forEach((el) => el.classList.remove("blur", "active")),
  );
});
