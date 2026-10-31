import { all, on, ready } from "../../../dom.js";

ready(() => {
  on(".square", "mouseenter", function () {
    const hor = "." + this.dataset.hor;
    const ver = "." + this.dataset.ver;
    all(".type" + hor + ver).forEach((el) => el.classList.add("active"));
    all(".category").forEach((el) => el.classList.add("blur"));
    all(".category" + hor + ", .category" + ver).forEach((el) => {
      el.classList.remove("blur");
      el.classList.add("active");
    });
  });
  on(".square", "mouseleave", () => {
    all(".type").forEach((el) => el.classList.remove("active"));
    all(".category").forEach((el) => el.classList.remove("active", "blur"));
  });
});
