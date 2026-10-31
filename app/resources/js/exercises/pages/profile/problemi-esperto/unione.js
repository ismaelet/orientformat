import { isOnSegment } from "../../../geometry.js";
import { all, one, on, ready, setField, offset } from "../../../dom.js";

ready(() => {
  const graph = one("#page-graph");
  const permanent = one("#canv-perm");
  const preview = one("#canv-draw");
  const field = one("#field");
  if (!graph || !permanent || !preview || !field) return;
  const dots = all(".dot");
  let path = field.value && field.value !== "0" ? field.value.split(",") : [];
  let completed = false;
  const point = (dot) => ({
    x: offset(dot).left - offset(graph).left + dot.clientWidth / 2,
    y: offset(dot).top - offset(graph).top + dot.clientHeight / 2,
  });
  const clear = (canvas) => canvas.getContext("2d").clearRect(0, 0, canvas.width, canvas.height);
  const line = (canvas, a, b) => {
    const context = canvas.getContext("2d");
    context.beginPath();
    context.moveTo(a.x, a.y);
    context.lineTo(b.x, b.y);
    context.lineWidth = 2;
    context.strokeStyle = "#fff";
    context.stroke();
  };
  const dotFor = (id) => one("#dot-space" + id + " .dot");
  const render = () => {
    clear(permanent);
    dots.forEach((dot) => {
      dot.dataset.active = "0";
      dot.classList.remove("active", "err");
    });
    for (let i = 1; i < path.length; i++) {
      const start = dotFor(path[i - 1]);
      const end = dotFor(path[i]);
      if (!start || !end) continue;
      line(permanent, point(start), point(end));
      const x1 = Number(start.dataset.x),
        y1 = Number(start.dataset.y),
        x2 = Number(end.dataset.x),
        y2 = Number(end.dataset.y);
      dots.forEach((dot) => {
        const x = Number(dot.dataset.x),
          y = Number(dot.dataset.y);
        if (isOnSegment({ x: x1, y: y1 }, { x: x2, y: y2 }, { x, y })) {
          dot.dataset.active = "1";
          dot.classList.add("active");
        }
      });
    }
    dots.forEach((dot) => setField(dot.previousElementSibling, dot.dataset.active));
    const segments = Math.max(0, path.length - 1);
    const score = dots.filter((dot) => dot.matches(".tar") && dot.dataset.active === "1").length;
    completed = segments === 4 && score === 9;
    graph.classList.toggle("disabled", completed);
    if (segments === 4 && !completed) all(".dot.tar").forEach((dot) => dot.classList.add("err"));
    if (one("#segments")) one("#segments").textContent = segments;
    if (one("#score")) one("#score").textContent = score;
    field.value = path.length ? path.join(",") : "0";
  };
  const resize = () => {
    for (const canvas of [permanent, preview]) {
      canvas.style.width = "100%";
      canvas.style.height = "100%";
      canvas.width = canvas.offsetWidth;
      canvas.height = canvas.offsetHeight;
    }
    render();
  };
  resize();
  window.addEventListener("resize", resize);
  on(".dot-space", "pointerup", function () {
    if (completed) return;
    const id = one(".dot", this).dataset.id;
    if (path.length >= 5) path = [];
    if (path.at(-1) !== id) path.push(id);
    clear(preview);
    render();
  });
  graph.addEventListener("pointermove", (event) => {
    if (completed || path.length === 0 || path.length >= 5) return;
    const dot = dotFor(path.at(-1));
    if (dot) {
      clear(preview);
      line(preview, point(dot), {
        x: event.pageX - offset(graph).left,
        y: event.pageY - offset(graph).top,
      });
    }
  });
  graph.addEventListener("pointerleave", () => {
    clear(preview);
    if (!completed) {
      path = [];
      render();
    }
  });
});
