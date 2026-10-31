import { all, one, on, ready, setField, hide } from "../../../dom.js";

ready(() => {
  let start;
  on("#start", "click", function () {
    start = Date.now();
    hide(this);
    one("#concepts")?.classList.add("active");
    setTimeout(() => all(".concept").forEach((el) => el.classList.remove("loadA")), 100);
  });
  on("#stop", "click", () => {
    setField(one("#record-time"), Math.round((Date.now() - start) / 1000));
    window.scrollTo({ top: 0, behavior: "smooth" });
    one("#concepts")?.classList.remove("active");
    one("#answers")?.classList.add("active");
    one(".page-footer")?.classList.add("active");
  });
});
