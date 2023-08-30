import vue from "@vitejs/plugin-vue";
import laravel from "laravel-vite-plugin";
import { defineConfig } from "vite";
import { fileURLToPath, URL } from "url";
import svgLoader from "vite-svg-loader";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
        vue(),
        svgLoader(),
    ],
    resolve: {
        alias: [
            {
                find: "@",
                replacement: fileURLToPath(
                    new URL("./resources/js", import.meta.url),
                ),
            },
        ],
    },
});
