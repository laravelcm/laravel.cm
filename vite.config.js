import laravel, { refreshPaths } from "laravel-vite-plugin";
import { defineConfig } from "vite";
import tailwindcss from "@tailwindcss/vite";
import dotenv from "dotenv";

dotenv.config({ path: ".env" });

const APP_HOST = process.env.APP_URL
  ? new URL(process.env.APP_URL).host
  : "laravelcm.local";
const VITE_PORT = 5173;

export default defineConfig({
  plugins: [
    laravel({
      input: [
        "resources/css/app.css",
        "resources/js/app.js",
        "resources/css/filament/admin/theme.css",
      ],
      refresh: [
        "app/Livewire/**",
        "app/Filament/**",
        "app-modules/*/Livewire/**",
        "app-modules/*/views/**",
        ...refreshPaths
      ],
    }),
    {
      name: "blade",
      handleHotUpdate({ file, server }) {
        if (file.endsWith(".blade.php")) {
          server.ws.send({
            type: "full-reload",
            path: "*",
          });
        }
      },
    },
    tailwindcss(),
  ],
  resolve: {
    alias: {
      "@": "/resources/js",
    },
  },
  server: {
    host: "0.0.0.0",
    port: VITE_PORT,
    strictPort: true,
    hmr: {
      host: APP_HOST,
      port: VITE_PORT,
      protocol: "wss",
    },
  },
});
