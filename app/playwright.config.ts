import { defineConfig, devices } from "@playwright/test";
import { E2E_URL, phpEnv } from "./e2e/support/env";

export default defineConfig({
  testDir: "./e2e",
  testIgnore: "example.spec.ts",
  globalSetup: "./e2e/support/global-setup.ts",
  // Specs share one isolated test database, so they run serially.
  fullyParallel: false,
  workers: 1,
  timeout: 20_000,
  expect: { timeout: 5_000 },
  forbidOnly: !!process.env.CI,
  retries: process.env.CI ? 2 : 0,
  reporter: process.env.CI ? "github" : "list",
  use: {
    baseURL: E2E_URL,
    trace: "on-first-retry",
  },
  projects: [{ name: "chromium", use: { ...devices["Desktop Chrome"] } }],
  webServer: {
    command: "bash scripts/e2e-server.sh",
    url: `${E2E_URL}/login`,
    reuseExistingServer: false,
    env: { ...phpEnv, PATH: process.env.PATH ?? "", HOME: process.env.HOME ?? "" },
  },
});
