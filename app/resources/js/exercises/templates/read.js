import { one, ready, offset } from "../dom.js";

ready(() => {
  const content = one("#content");
  const scroll = one("#scroll");
  const footer = one("footer");
  if (!content || !scroll || !footer) return;
  const update = () => {
    scroll.classList.toggle("top", window.scrollY <= offset(content).top);
    scroll.classList.toggle("bottom", window.scrollY >= offset(footer).top - window.innerHeight);
  };
  update();
  window.addEventListener("scroll", update, { passive: true });
  window.addEventListener("resize", update);
});
