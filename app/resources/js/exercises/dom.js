export const all = (selector, root = document) => [...root.querySelectorAll(selector)];
export const one = (selector, root = document) => root.querySelector(selector);
export function ready(callback) {
  if (document.readyState === "complete") callback();
  else window.addEventListener("load", callback, { once: true });
}
export function on(selector, events, callback, root = document) {
  all(selector, root).forEach((element) =>
    events.split(" ").forEach((event) => element.addEventListener(event, callback)),
  );
}
export function setField(element, value) {
  if (!element) return;
  element.value = String(value ?? "");
  element.dispatchEvent(new Event("change", { bubbles: true }));
}
export function show(element) {
  if (!element) return;
  element.hidden = false;
  element.style.removeProperty("display");
  if (getComputedStyle(element).display === "none") element.style.display = "block";
}
export function hide(element) {
  if (element) element.style.display = "none";
}
export function offset(element) {
  const rect = element.getBoundingClientRect();
  return { left: rect.left + window.scrollX, top: rect.top + window.scrollY };
}

/** Pointer events support mice, pens and touch; Enter/Space supports keyboard selection. */
export function bindDrop(sources, targets, accept, drop) {
  const sourceElements = all(sources);
  const targetElements = all(targets);
  let selected = null;
  const select = (source) => {
    sourceElements.forEach((element) =>
      element.classList.toggle("drag-selected", element === source),
    );
    selected = source;
  };
  const finish = (target) => {
    if (selected && target && accept(selected, target)) drop(selected, target);
    select(null);
  };
  sourceElements.forEach((source) => {
    source.tabIndex = source.tabIndex < 0 ? 0 : source.tabIndex;
    source.style.touchAction = "none";
    source.addEventListener("keydown", (event) => {
      if (["Enter", " "].includes(event.key)) {
        event.preventDefault();
        select(source);
      }
    });
    source.addEventListener("pointerdown", (event) => {
      if (event.button !== 0) return;
      event.preventDefault();
      select(source);
      const start = { x: event.clientX, y: event.clientY };
      source.setPointerCapture(event.pointerId);
      const move = (pointer) => {
        source.style.translate = `${pointer.clientX - start.x}px ${pointer.clientY - start.y}px`;
      };
      const end = (pointer) => {
        source.removeEventListener("pointermove", move);
        source.removeEventListener("pointerup", end);
        source.removeEventListener("pointercancel", cancel);
        source.style.translate = "";
        source.style.pointerEvents = "none";
        const under = document.elementFromPoint(pointer.clientX, pointer.clientY);
        source.style.pointerEvents = "";
        const target = targetElements.find(
          (element) => element === under || element.contains(under),
        );
        finish(target);
      };
      const cancel = () => {
        source.removeEventListener("pointermove", move);
        source.removeEventListener("pointerup", end);
        source.removeEventListener("pointercancel", cancel);
        source.style.translate = "";
        select(null);
      };
      source.addEventListener("pointermove", move);
      source.addEventListener("pointerup", end);
      source.addEventListener("pointercancel", cancel);
    });
  });
  targetElements.forEach((target) => {
    target.tabIndex = target.tabIndex < 0 ? 0 : target.tabIndex;
    target.addEventListener("keydown", (event) => {
      if (["Enter", " "].includes(event.key)) {
        event.preventDefault();
        finish(target);
      }
    });
  });
}

export function bindMatching({
  sources = ".cause",
  targets = ".box",
  accept = () => true,
  updated = () => {},
} = {}) {
  bindDrop(
    sources,
    targets,
    (source, target) => target.classList.contains("droppable") && accept(source, target),
    (source, target) => {
      hide(source);
      setField(one(".filler-inp, .js-field", target), source.dataset.id);
      target.dataset.attached = source.id;
      target.classList.add("active");
      target.classList.remove("droppable");
      const text = one("p", target);
      if (text) text.textContent = one("p", source)?.textContent ?? source.textContent;
      updated();
    },
  );
  on(".reset", "click", function () {
    const box = this.closest(targets);
    if (!box) return;
    const source = document.getElementById(box.dataset.attached);
    box.classList.remove("active");
    box.classList.add("droppable");
    setField(one(".filler-inp, .js-field", box), 0);
    if (one("p", box)) one("p", box).textContent = "";
    show(source);
    updated();
  });
}
