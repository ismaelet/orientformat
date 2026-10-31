import { defineConfig } from "vitest/config";

export default defineConfig({
  test: {
    environment: "node",
    include: ["tests/Vitest/**/*.test.{js,mjs,ts}"],
    setupFiles: ["./tests/Vitest/setup.ts"],
  },
});
