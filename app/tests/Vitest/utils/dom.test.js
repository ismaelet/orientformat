import { expect, test } from "vitest";
import { setField } from "../../../resources/js/exercises/dom.js";

test("setting exercise fields keeps zero values and emits bubbling changes", () => {
  const input = new EventTarget();
  let event;
  input.addEventListener("change", (change) => (event = change));
  setField(input, 0);
  expect(input.value).toBe("0");
  expect(event.bubbles).toBe(true);
});
