import { all, one, on, ready, setField, show, hide } from "../../../dom.js";

ready(() => {
  const cycle = (pos) => {
    hide(one("#image" + (pos - 1)));
    show(one("#image" + pos));
    setTimeout(() => {
      if (pos < 6) cycle(pos + 1);
      else {
        hide(one("#slider"));
        show(one("#solutions"));
      }
    }, 6000);
  };
  on(".js-start", "click", () => {
    hide(one("#example"));
    show(one("#slider"));
    setTimeout(() => cycle(1), 1000);
  });
  on(".solution", "click", function () {
    all(".solution").forEach((el) => el.classList.toggle("active", el === this));
    all(".filler-inp").forEach((el) => setField(el, this.dataset.val));
  });
});
