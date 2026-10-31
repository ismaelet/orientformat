import { expect, test, vi } from "vitest";
import { bindDrop } from "../../../resources/js/exercises/dom.js";

test("native drag targets accept keyboard and pointer drops and reject incompatible cards", () => {
  class Item extends EventTarget {
    constructor(kind) {
      super();
      this.kind = kind;
      this.style = {};
      this.tabIndex = -1;
      this.classes = new Set();
      this.classList = {
        toggle: (name, enabled) => (enabled ? this.classes.add(name) : this.classes.delete(name)),
      };
    }
    setPointerCapture() {}
    contains(element) {
      return element === this;
    }
  }
  const source = new Item("solid");
  const correct = new Item("solid");
  const wrong = new Item("dashed");
  const drops = [];
  vi.stubGlobal("document", {
    querySelectorAll: (selector) => (selector === ".source" ? [source] : [correct, wrong]),
    elementFromPoint: () => correct,
  });
  bindDrop(
    ".source",
    ".target",
    (card, target) => card.kind === target.kind,
    (card, target) => drops.push([card, target]),
  );
  const send = (element, type, properties) => {
    const event = new Event(type, { cancelable: true });
    Object.assign(event, properties);
    element.dispatchEvent(event);
  };
  send(source, "keydown", { key: "Enter" });
  send(wrong, "keydown", { key: "Enter" });
  expect(drops.length).toBe(0);
  send(source, "keydown", { key: " " });
  send(correct, "keydown", { key: "Enter" });
  expect(drops).toEqual([[source, correct]]);
  send(source, "pointerdown", { button: 0, pointerId: 1, clientX: 10, clientY: 20 });
  send(source, "pointermove", { clientX: 40, clientY: 60 });
  expect(source.style.translate).toBe("30px 40px");
  send(source, "pointerup", { clientX: 40, clientY: 60 });
  expect(drops.length).toBe(2);
  expect(source.style.translate).toBe("");
  expect(source.classes.has("drag-selected")).toBe(false);
});
