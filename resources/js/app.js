import "./bootstrap";

import { createApp, h } from "vue";
import { createPinia } from "pinia";
import { createInertiaApp } from "@inertiajs/vue3";
import { ZiggyVue } from "ziggy-js/dist/vue";
import { Ziggy } from "./ziggy.js";

const pinia = createPinia();

createInertiaApp({
    resolve: async (name) => {
        const pages = import.meta.glob("./pages/**/*.vue");
        return (await pages[`./pages/${name}.vue`]()).default;
    },
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(pinia)
            .use(ZiggyVue, Ziggy);

        app.mount(el);
    },
});
