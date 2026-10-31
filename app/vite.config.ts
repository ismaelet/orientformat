import { readdirSync } from "node:fs";
import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";

function exerciseScripts(directory: string): string[] {
  return readdirSync(directory, { withFileTypes: true }).flatMap((entry) => {
    const path = `${directory}/${entry.name}`;
    return entry.isDirectory() ? exerciseScripts(path) : entry.name.endsWith(".js") ? [path] : [];
  });
}

export default defineConfig(({ command }) => ({
  base: command === "build" ? "/orientamento/build/" : "/",

  plugins: [
    laravel({
      input: [
        "resources/css/app.css",
        "resources/js/app.ts",
        ...exerciseScripts("resources/js/exercises/pages"),
        ...exerciseScripts("resources/js/exercises/templates"),
      ],
      refresh: true,
    }),
    tailwindcss(),
  ],

  server: {
    host: "0.0.0.0",
    port: 5173,
    hmr: {
      host: "localhost",
    },
  },
}));
