import { expect, test } from "vitest";
import { isOnSegment } from "../../../resources/js/exercises/geometry.js";

test("dot-joining scores count only grid points within each horizontal, vertical or diagonal segment", () => {
  expect(isOnSegment({ x: 0, y: 0 }, { x: 2, y: 2 }, { x: 1, y: 1 })).toBe(true);
  expect(isOnSegment({ x: 0, y: 0 }, { x: 2, y: 2 }, { x: 3, y: 3 })).toBe(false);
  expect(isOnSegment({ x: 0, y: 0 }, { x: 2, y: 2 }, { x: 1, y: 2 })).toBe(false);
  expect(isOnSegment({ x: 2, y: 0 }, { x: 2, y: 2 }, { x: 2, y: 1 })).toBe(true);
  expect(isOnSegment({ x: 0, y: 2 }, { x: 2, y: 2 }, { x: 1, y: 2 })).toBe(true);
  expect(isOnSegment({ x: 0, y: 2 }, { x: 2, y: 2 }, { x: 1, y: 0 })).toBe(false);
});
