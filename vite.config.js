import laravel, { refreshPaths } from "laravel-vite-plugin";
import { defineConfig } from "vite";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
  plugins: [
    laravel({
      input: [
        "resources/css/app.css",
        "resources/css/filament/admin/theme.css",
        "resources/js/app.js",
        "resources/js/echo.js",
      ],
      refresh: [
        "app/Livewire/**",
        "app/Filament/**",
        "app-modules/*/Livewire/**",
        "app-modules/*/views/**",
        ...refreshPaths,
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
});
