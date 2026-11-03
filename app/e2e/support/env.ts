import { tmpdir } from "node:os";
import { join } from "node:path";

export const E2E_PORT = process.env.E2E_PORT ?? "8099";
export const E2E_URL = `http://127.0.0.1:${E2E_PORT}`;

/**
 * Environment for every PHP process started by the browser suite. It pins the
 * isolated test database and deliberately ignores any DB_* value inherited from
 * the shell, so the development database can never be reached.
 */
export const phpEnv: Record<string, string> = {
  APP_ENV: "testing",
  APP_DEBUG: "true",
  APP_URL: E2E_URL,
  ASSET_URL: E2E_URL,
  APP_KEY: "base64:b3JpZW50Zm9ybWF0LWUyZS10ZXN0LWtleS0wMDAwMDA=",
  DB_CONNECTION: "mysql",
  DB_HOST: process.env.E2E_DB_HOST ?? "127.0.0.1",
  DB_PORT: process.env.E2E_DB_PORT ?? "3306",
  DB_DATABASE: "orientformat_test",
  DB_USERNAME: "orientformat_test",
  DB_PASSWORD: process.env.E2E_DB_PASSWORD ?? "orientformat_test_password",
  DB_URL: "",
  DATABASE_URL: "",
  SESSION_DRIVER: "cookie",
  CACHE_STORE: "array",
  QUEUE_CONNECTION: "sync",
  LOG_CHANNEL: "stderr",
  DEBUGBAR_ENABLED: "false",
  VIEW_COMPILED_PATH: join(tmpdir(), "orientformat-e2e-views"),
  E2E_PORT,
  E2E_PUBLIC_DIR: join(tmpdir(), "orientformat-e2e-public"),
};
