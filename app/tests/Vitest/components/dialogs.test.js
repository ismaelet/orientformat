import { expect, test, vi } from "vitest";
import { initDialogs } from "../../../resources/js/ui/dialogs.ts";

test("delegated modal clicks manage scroll locking without changing Blade modal state", () => {
  const listeners = {};
  const dialogs = [];
  class Element {
    constructor(classes = [], attributes = {}) {
      this.classes = new Set(classes);
      this.dataset = {};
      this.attributes = attributes;
      this.classList = {
        contains: (name) => this.classes.has(name),
        add: (name) => this.classes.add(name),
        remove: (name) => this.classes.delete(name),
        toggle: (name, enabled) => (enabled ? this.classes.add(name) : this.classes.delete(name)),
      };
    }
    hasAttribute(name) {
      return name in this.attributes;
    }
    closest(selector) {
      if (selector.split(", ").some((name) => this.classes.has(name.slice(1)))) return this;
      return this.parent?.closest(selector) ?? null;
    }
  }
  const modal = new Element(["modal"]);
  const modern = new Element(["modal"], { "data-open": "false" });
  dialogs.push(modal, modern);
  const body = new Element();
  const openDialogs = () => dialogs.filter((dialog) => dialog.classes.has("open"));
  vi.stubGlobal("Element", Element);
  vi.stubGlobal("document", {
    body,
    addEventListener: (name, callback) => (listeners[name] = callback),
    getElementById: (id) => (id === "modern" ? modern : modal),
    querySelector: () => openDialogs()[0] ?? null,
    querySelectorAll: openDialogs,
  });
  initDialogs();
  const trigger = new Element(["js-open-modal"]);
  trigger.dataset.target = "interest";
  const nestedIcon = new Element();
  nestedIcon.parent = trigger;
  listeners.click({ target: nestedIcon });
  expect(modal.classes.has("open")).toBeTruthy();
  expect(body.classes.has("fixed")).toBeTruthy();
  const content = new Element();
  content.parent = modal;
  listeners.click({ target: content });
  expect(modal.classes.has("open")).toBeTruthy();
  const close = new Element(["js-close-modal"]);
  close.parent = modal;
  listeners.click({ target: close });
  expect(!modal.classes.has("open")).toBeTruthy();
  expect(!body.classes.has("fixed")).toBeTruthy();
  trigger.dataset.target = "modern";
  listeners.click({ target: trigger });
  expect(!modern.classes.has("open")).toBeTruthy();
  expect(modern.attributes["data-open"]).toBe("false");
  trigger.dataset.target = "interest";
  listeners.click({ target: trigger });
  listeners.keydown({ key: "Escape" });
  expect(!modal.classes.has("open")).toBeTruthy();
  expect(!body.classes.has("fixed")).toBeTruthy();
});
