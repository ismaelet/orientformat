import { all, one, ready, bindMatching } from "../dom.js";

ready(() => {
  all(".box").forEach((element) => {
    const connections = element.dataset.connections
      ? JSON.parse(element.dataset.connections)
      : null;
    if (!connections) return;
    Object.entries(connections).forEach(([index, anchors]) => {
      const target = one(".box:nth-child(" + index + ")");
      if (target)
        new LeaderLine(element, target, {
          path: "magnet",
          startSocket: anchors.split(",")[0],
          endSocket: anchors.split(",")[1],
          color: getComputedStyle(document.documentElement).getPropertyValue(
            "--color-secondary-400",
          ),
          size: 3,
        });
    });
  });
  bindMatching({
    targets: ".box",
    accept: (source, target) =>
      source.classList.contains("js-box--solid") === target.classList.contains("js-box--solid"),
  });
});
