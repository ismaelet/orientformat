import { all, on, ready } from "../../../dom.js";

ready(() => {
  on(".page-graph-box input", "focus blur", function (event) {
    all(".line-g" + this.dataset.group).forEach((el) =>
      el.classList.toggle("active", event.type === "focus"),
    );
  });
});
