import { all, one, on, ready, setField } from "../../../dom.js";

ready(() => {
  on(".answer", "click", function () {
    all("input", this.closest(".answers")).forEach((el) => {
      el.checked = false;
      el.dispatchEvent(new Event("change", { bubbles: true }));
    });
    const input = this.previousElementSibling;
    if (input) {
      input.checked = true;
      input.dispatchEvent(new Event("change", { bubbles: true }));
    }
  });
  on(".emotion", "click", function () {
    const box = this.closest(".emotions");
    this.previousElementSibling?.click();
    const value = all('input[type="checkbox"]:checked', box)
      .map((el) => el.dataset.val)
      .join("+");
    setField(one(".filler-inp", box), value);
  });
});
