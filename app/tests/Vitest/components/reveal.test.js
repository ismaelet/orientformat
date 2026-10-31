import { expect, test, vi } from "vitest";
import { initReveal } from "../../../resources/js/ui/reveal.ts";

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

test("reveal observers honor thresholds, reveal once, and keep load-only elements waiting", () => {
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
  vi.stubGlobal("document", {
    readyState: "interactive",
    querySelectorAll: () => [normal, entering, always],
  });
  vi.stubGlobal("window", {
    IntersectionObserver: Observer,
    addEventListener: (name, listener) => (listeners[name] = listener),
  });
  vi.stubGlobal("IntersectionObserver", Observer);
  vi.stubGlobal("HTMLImageElement", RevealElement);
  initReveal();
  const half = observers.find((observer) => observer.threshold === 0.5);
  const start = observers.find((observer) => observer.threshold === 0);
  expect(half.observed.has(normal)).toBeTruthy();
  expect(start.observed.has(entering)).toBeTruthy();
  expect(!half.observed.has(always)).toBeTruthy();
  half.callback([{ target: normal, isIntersecting: false }], half);
  expect(normal.classes.has("js-load")).toBeTruthy();
  half.callback([{ target: normal, isIntersecting: true }], half);
  expect(!normal.classes.has("js-load")).toBeTruthy();
  expect(half.observed.size).toBe(0);
  expect(always.classes.has("js-load")).toBeTruthy();
  listeners.load();
  expect(!always.classes.has("js-load")).toBeTruthy();
});

test("reveal falls back safely and loads lazy image sources without IntersectionObserver", () => {
  const image = new RevealElement(["load", "js-load", "lazy-loading"], { lazySrc: "/image.webp" });
  vi.stubGlobal("document", { readyState: "complete", querySelectorAll: () => [image] });
  vi.stubGlobal("window", {});
  vi.stubGlobal("HTMLImageElement", RevealElement);
  initReveal();
  expect(image.src).toBe("/image.webp");
  expect(image.classes.size).toBe(0);
});
