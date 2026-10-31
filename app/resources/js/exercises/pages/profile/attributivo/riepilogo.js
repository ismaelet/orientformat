import { all, one, on, ready, show, hide } from "../../../dom.js";

ready(() => {
  on(".bar", "mouseenter", function () {
    const id = this.parentElement.dataset.id;
    all(".column").forEach((el) => {
      el.classList.toggle("blur", !el.classList.contains("column" + id));
      el.classList.toggle("active", el.classList.contains("column" + id));
    });
    show(one("#desc" + id));
  });
  on(".bar", "mouseleave", () => {
    all(".column").forEach((el) => el.classList.remove("blur", "active"));
    all(".desc").forEach(hide);
  });
});
