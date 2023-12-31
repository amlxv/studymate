import vue from "@vitejs/plugin-vue";
import laravel from "laravel-vite-plugin";
import { defineConfig } from "vite";
import { fileURLToPath, URL } from "url";
import svgLoader from "vite-svg-loader";
import { imagetools } from "vite-imagetools";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
        vue(),
        svgLoader(),
        {
            apply: "build",
            ...imagetools({
                defaultDirectives: () =>
                    new URLSearchParams({ format: "webp" }), // Apply 'format=webp' to all matching images
                include: ["resources/images/*.png"], // Only process PNG images
            }),
        },
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
