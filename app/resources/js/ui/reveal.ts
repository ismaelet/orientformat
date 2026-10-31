export function initReveal() {
  const reveal = (element: Element) => {
    element.classList.remove("load", "js-load");
    if (element instanceof HTMLImageElement && element.dataset.lazySrc) {
      element.src = element.dataset.lazySrc;
      element.classList.remove("lazy-loading");
    }
  };
  const elements = document.querySelectorAll<HTMLElement>(".js-load, .load, .lazy-loading");
  const revealAlways = () =>
    elements.forEach((element) => {
      if (element.dataset.loadType === "always") reveal(element);
    });

  if (document.readyState === "complete") revealAlways();
  else window.addEventListener("load", revealAlways, { once: true });

  if (!("IntersectionObserver" in window)) {
    elements.forEach(reveal);
    return;
  }

  const createObserver = (threshold: number) =>
    new IntersectionObserver(
      (entries, observer) => {
        entries.forEach((entry) => {
          if (!entry.isIntersecting) return;
          reveal(entry.target);
          observer.unobserve(entry.target);
        });
      },
      { threshold },
    );
  const halfVisible = createObserver(0.5);
  const entering = createObserver(0);
  elements.forEach((element) => {
    if (element.dataset.loadType === "always") return;
    const observer =
      element.classList.contains("js-load") && element.dataset.loadThreshold !== "0"
        ? halfVisible
        : entering;
    observer.observe(element);
  });
}
