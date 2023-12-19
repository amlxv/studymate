import vue from "@vitejs/plugin-vue";
import laravel from "laravel-vite-plugin";
import { defineConfig } from "vite";
import { fileURLToPath, URL } from "url";
import svgLoader from "vite-svg-loader";
import { ViteImageOptimizer } from "vite-plugin-image-optimizer";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
        vue(),
        svgLoader(),
        ViteImageOptimizer(),
    ],
    resolve: {
        alias: [
            {
                find: "@",
                replacement: fileURLToPath(
                    new URL("./resources/js", import.meta.url),
                ),
            },
            {
                find: "@images",
                replacement: fileURLToPath(
                    new URL("./resources/images", import.meta.url),
                ),
            },
        ],
    },
});
