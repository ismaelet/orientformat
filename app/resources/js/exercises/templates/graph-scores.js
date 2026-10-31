import { all, one, on, ready, setField } from "../dom.js";

ready(() => {
  const update = (column, value) =>
    all(".graph-ele", column).forEach((el) => {
      el.classList.toggle("active", Number(el.dataset.val) <= Number(value));
      el.classList.toggle("last", Number(el.dataset.val) === Number(value));
    });
  all(".graph-col").forEach((column) => update(column, one("input", column)?.value));
  on(".graph-ele:not(.disabled)", "click", function () {
    const column = this.closest(".graph-col");
    update(column, this.dataset.val);
    all("input", column).forEach((el) => setField(el, this.dataset.val));
  });
  on(".graph-ele:not(.disabled)", "mouseenter", function () {
    update(this.closest(".graph-col"), this.dataset.val);
  });
  on(".graph-ele:not(.disabled)", "mouseleave", function () {
    const column = this.closest(".graph-col");
    update(column, one("input", column)?.value);
  });
  on(".ele-box", "mouseenter", function () {
    const id = this.closest(".graph-col").dataset.id;
    all(".js-field-info").forEach((el) => el.classList.toggle("active", el.dataset.id === id));
  });
  on(".ele-box", "mouseleave", () =>
    all(".js-field-info").forEach((el) => el.classList.remove("active")),
  );
});
