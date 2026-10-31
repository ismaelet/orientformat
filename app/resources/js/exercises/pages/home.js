import { all, on, ready } from "../dom.js";

ready(() => {
  let current = 1;
  const resize = () => {
    const boxes = all(".title-box");
    boxes.forEach((el) => (el.style.height = "auto"));
    const height = Math.max(0, ...boxes.map((el) => el.getBoundingClientRect().height));
    boxes.forEach((el) => (el.style.height = height + "px"));
  };
  resize();
  window.addEventListener("resize", resize);
  on(".piece-area", "mouseenter", function () {
    all(".piece-area").forEach((el) => {
      if (el.id !== "piece-area" + current) el.classList.remove("active");
    });
    this.classList.add("active");
  });
  on(".piece-area", "mouseleave", () =>
    all(".piece-area").forEach((el) => {
      if (el.id !== "piece-area" + current) el.classList.remove("active");
    }),
  );
  on(".piece-area", "click", function () {
    current = Number(this.dataset.pos);
    all(".piece-area").forEach((el) => el.classList.toggle("active", el === this));
    all(".title-box").forEach((el) =>
      el.classList.toggle("active", el.id === "title-box" + current),
    );
  });
});
