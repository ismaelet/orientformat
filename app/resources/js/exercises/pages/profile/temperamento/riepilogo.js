import { all, one, on, ready } from "../../../dom.js";

ready(() => {
  on(".responsive", "mouseenter", function () {
    one("#section" + this.dataset.id)?.classList.add("active");
    one("#result" + this.dataset.id)?.classList.add("active");
  });
  on(".responsive", "mouseleave", () =>
    all(".section,.result").forEach((el) => el.classList.remove("active")),
  );
  const colors = [1, 2, 3, 4, 5].map((i) =>
    getComputedStyle(document.documentElement).getPropertyValue("--color-" + i + "-of-5"),
  );
  let lines = [];
  const draw = () => {
    lines.forEach((line) => line.remove());
    lines = [];
    for (let i = 1; i < 5; i++) {
      const start = one("#result" + i + " .score.active");
      const end = one("#result" + (i + 1) + " .score.active");
      if (start && end)
        lines.push(
          new LeaderLine(start, end, {
            dash: { animation: true },
            endPlug: "behind",
            size: 4,
            startPlugColor: colors[i - 1],
            endPlugColor: colors[i],
            gradient: true,
          }),
        );
    }
  };
  draw();
  window.addEventListener("resize", draw);
});
