import { isOnSegment } from "../../resources/js/exercises/geometry.js";
import assert from "node:assert/strict";
import { test } from "node:test";
import { initReveal } from "../../resources/js/ui/reveal.ts";
import { bindDrop, setField } from "../../resources/js/exercises/dom.js";
import { reviewQuestionCompleted } from "../../resources/js/ui/review.ts";
import { initDialogs } from "../../resources/js/ui/dialogs.ts";
import { initForms } from "../../resources/js/ui/forms.ts";

function globals(t, values) {
  const original = new Map(
    Object.keys(values).map((key) => [key, Object.getOwnPropertyDescriptor(globalThis, key)]),
  );
  Object.entries(values).forEach(([key, value]) =>
    Object.defineProperty(globalThis, key, { configurable: true, writable: true, value }),
  );
  t.after(() =>
    original.forEach((descriptor, key) => {
      if (descriptor) Object.defineProperty(globalThis, key, descriptor);
      else delete globalThis[key];
    }),
  );
}

class RevealElement {
  constructor(classes, dataset = {}) {
    this.classes = new Set(classes);
    this.dataset = dataset;
    this.classList = {
      contains: (name) => this.classes.has(name),
      remove: (...names) => names.forEach((name) => this.classes.delete(name)),
    };
  }
}

test("reveal observers honor thresholds, reveal once, and keep load-only elements waiting", (t) => {
  const observers = [];
  const listeners = {};
  class Observer {
    constructor(callback, options) {
      this.callback = callback;
      this.threshold = options.threshold;
      this.observed = new Set();
      observers.push(this);
    }
    observe(element) {
      this.observed.add(element);
    }
    unobserve(element) {
      this.observed.delete(element);
    }
  }
  const normal = new RevealElement(["js-load"]);
  const entering = new RevealElement(["js-load"], { loadThreshold: "0" });
  const always = new RevealElement(["js-load"], { loadType: "always" });
  globals(t, {
    document: { readyState: "interactive", querySelectorAll: () => [normal, entering, always] },
    window: {
      IntersectionObserver: Observer,
      addEventListener: (name, listener) => (listeners[name] = listener),
    },
    IntersectionObserver: Observer,
    HTMLImageElement: RevealElement,
  });
  initReveal();
  const half = observers.find((observer) => observer.threshold === 0.5);
  const start = observers.find((observer) => observer.threshold === 0);
  assert.ok(half.observed.has(normal));
  assert.ok(start.observed.has(entering));
  assert.ok(!half.observed.has(always));
  half.callback([{ target: normal, isIntersecting: false }], half);
  assert.ok(normal.classes.has("js-load"));
  half.callback([{ target: normal, isIntersecting: true }], half);
  assert.ok(!normal.classes.has("js-load"));
  assert.equal(half.observed.size, 0);
  assert.ok(always.classes.has("js-load"));
  listeners.load();
  assert.ok(!always.classes.has("js-load"));
});

test("reveal falls back safely and loads lazy image sources without IntersectionObserver", (t) => {
  const image = new RevealElement(["load", "js-load", "lazy-loading"], { lazySrc: "/image.webp" });
  globals(t, {
    document: { readyState: "complete", querySelectorAll: () => [image] },
    window: {},
    HTMLImageElement: RevealElement,
  });
  initReveal();
  assert.equal(image.src, "/image.webp");
  assert.equal(image.classes.size, 0);
});

test("space prevention is scoped to inputs that request it", (t) => {
  const listeners = {};
  class Input {
    matches() {
      return this.noSpaces;
    }
  }
  globals(t, {
    document: {
      addEventListener: (name, callback) => (listeners[name] = callback),
      querySelectorAll: () => [],
    },
    Element: Input,
  });
  initForms();
  const target = new Input();
  let prevented = false;
  const event = { target, key: " ", preventDefault: () => (prevented = true) };
  listeners.keydown(event);
  assert.equal(prevented, false);
  target.noSpaces = true;
  listeners.keydown(event);
  assert.equal(prevented, true);
});

test("delegated modal clicks manage scroll locking without changing Blade modal state", (t) => {
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
  globals(t, {
    Element,
    document: {
      body,
      addEventListener: (name, callback) => (listeners[name] = callback),
      getElementById: (id) => (id === "modern" ? modern : modal),
      querySelector: () => openDialogs()[0] ?? null,
      querySelectorAll: openDialogs,
    },
  });
  initDialogs();
  const trigger = new Element(["js-open-modal"]);
  trigger.dataset.target = "interest";
  const nestedIcon = new Element();
  nestedIcon.parent = trigger;
  listeners.click({ target: nestedIcon });
  assert.ok(modal.classes.has("open"));
  assert.ok(body.classes.has("fixed"));
  const content = new Element();
  content.parent = modal;
  listeners.click({ target: content });
  assert.ok(modal.classes.has("open"));
  const close = new Element(["js-close-modal"]);
  close.parent = modal;
  listeners.click({ target: close });
  assert.ok(!modal.classes.has("open"));
  assert.ok(!body.classes.has("fixed"));
  trigger.dataset.target = "modern";
  listeners.click({ target: trigger });
  assert.ok(!modern.classes.has("open"));
  assert.equal(modern.attributes["data-open"], "false");
  trigger.dataset.target = "interest";
  listeners.click({ target: trigger });
  listeners.keydown({ key: "Escape" });
  assert.ok(!modal.classes.has("open"));
  assert.ok(!body.classes.has("fixed"));
});

test("review completion requires every answer group and tracks cleared numeric inputs", () => {
  const choices = [
    { name: "first", checked: true },
    { name: "second", checked: false },
  ];
  const inputs = [];
  const question = {
    dataset: { multiple: "0" },
    querySelectorAll: (selector) => (selector === ".js-cbx" ? choices : inputs),
  };
  assert.equal(reviewQuestionCompleted(question), false);
  choices[1].checked = true;
  assert.equal(reviewQuestionCompleted(question), true);
  choices[1].checked = false;
  question.dataset.multiple = "1";
  assert.equal(reviewQuestionCompleted(question), true);
  choices.length = 0;
  inputs.push({ value: "" });
  assert.equal(reviewQuestionCompleted(question), false);
  inputs[0].value = "42";
  assert.equal(reviewQuestionCompleted(question), true);
  inputs[0].value = "  ";
  assert.equal(reviewQuestionCompleted(question), false);
  inputs.length = 0;
  assert.equal(reviewQuestionCompleted(question), true);
});

test("setting exercise fields keeps zero values and emits bubbling changes", () => {
  const input = new EventTarget();
  let event;
  input.addEventListener("change", (change) => (event = change));
  setField(input, 0);
  assert.equal(input.value, "0");
  assert.equal(event.bubbles, true);
});

test("native drag targets accept keyboard and pointer drops and reject incompatible cards", (t) => {
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
  globals(t, {
    document: {
      querySelectorAll: (selector) => (selector === ".source" ? [source] : [correct, wrong]),
      elementFromPoint: () => correct,
    },
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
  assert.equal(drops.length, 0);
  send(source, "keydown", { key: " " });
  send(correct, "keydown", { key: "Enter" });
  assert.deepEqual(drops, [[source, correct]]);
  send(source, "pointerdown", { button: 0, pointerId: 1, clientX: 10, clientY: 20 });
  send(source, "pointermove", { clientX: 40, clientY: 60 });
  assert.equal(source.style.translate, "30px 40px");
  send(source, "pointerup", { clientX: 40, clientY: 60 });
  assert.equal(drops.length, 2);
  assert.equal(source.style.translate, "");
  assert.equal(source.classes.has("drag-selected"), false);
});

test("dot-joining scores count only grid points within each horizontal, vertical or diagonal segment", () => {
  assert.equal(isOnSegment({ x: 0, y: 0 }, { x: 2, y: 2 }, { x: 1, y: 1 }), true);
  assert.equal(isOnSegment({ x: 0, y: 0 }, { x: 2, y: 2 }, { x: 3, y: 3 }), false);
  assert.equal(isOnSegment({ x: 0, y: 0 }, { x: 2, y: 2 }, { x: 1, y: 2 }), false);
  assert.equal(isOnSegment({ x: 2, y: 0 }, { x: 2, y: 2 }, { x: 2, y: 1 }), true);
  assert.equal(isOnSegment({ x: 0, y: 2 }, { x: 2, y: 2 }, { x: 1, y: 2 }), true);
  assert.equal(isOnSegment({ x: 0, y: 2 }, { x: 2, y: 2 }, { x: 1, y: 0 }), false);
});
