import { expect, test, vi } from "vitest";
import { initForms } from "../../../resources/js/ui/forms.ts";

test("space prevention is scoped to inputs that request it", () => {
  const listeners = {};
  class Input {
    matches() {
      return this.noSpaces;
    }
  }
  vi.stubGlobal("document", {
    addEventListener: (name, callback) => (listeners[name] = callback),
    querySelectorAll: () => [],
  });
  vi.stubGlobal("Element", Input);
  initForms();
  const target = new Input();
  let prevented = false;
  const event = { target, key: " ", preventDefault: () => (prevented = true) };
  listeners.keydown(event);
  expect(prevented).toBe(false);
  target.noSpaces = true;
  listeners.keydown(event);
  expect(prevented).toBe(true);
});
