export function initNavigation() {
  const panel = document.getElementById("h-pan");
  const menu = document.getElementById("h-navM");
  if (!panel) return;
  const resize = () => {
    const height = panel.getBoundingClientRect().height;
    panel.closest("header")?.style.setProperty("height", `${height}px`);
    menu?.style.setProperty("top", `${height}px`);
    menu?.style.setProperty("height", `calc(100% - ${height}px)`);
  };
  resize();
  if ("ResizeObserver" in window) new ResizeObserver(resize).observe(panel);
  else window.addEventListener("resize", resize);
  document.querySelector("#survey-prompt .icon")?.addEventListener("click", () => {
    document.getElementById("survey-prompt")?.style.setProperty("display", "none");
  });
}
