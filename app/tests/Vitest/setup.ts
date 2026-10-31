import { afterEach, vi } from "vitest";

// Restore browser fixtures and spies between tests, including failed tests.
afterEach(() => {
  vi.unstubAllGlobals();
  vi.restoreAllMocks();
});
