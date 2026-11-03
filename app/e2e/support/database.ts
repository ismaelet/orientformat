import { execFileSync } from "node:child_process";
import { mkdirSync } from "node:fs";
import { phpEnv } from "./env";

/** Runs the fixture script (guarded by TestDatabaseGuard) against the test database. */
export function runFixture(action: "seed" | "reset"): void {
  execFileSync("php", ["tests/Support/seed-e2e.php", action], {
    cwd: process.cwd(),
    env: { PATH: process.env.PATH ?? "", HOME: process.env.HOME ?? "", ...phpEnv },
    stdio: "pipe",
  });
}

export function prepareDirectories(): void {
  mkdirSync(phpEnv.VIEW_COMPILED_PATH, { recursive: true });
}
