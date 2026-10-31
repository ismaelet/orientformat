import { on, ready } from "../dom.js";

ready(() =>
  on(".restart", "click", function () {
    this.nextElementSibling?.click();
  }),
);
