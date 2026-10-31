import { all, on, ready } from "../../../dom.js";

ready(() => {
  on(".shape-inp", "input", () => {
    const full = all(".shape-inp").every((el) => el.value);
    all(".btn-box").forEach((el) => el.classList.toggle("hide", !full));
  });
});
