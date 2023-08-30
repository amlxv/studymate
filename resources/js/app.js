import "./bootstrap";

import { createApp, h } from "vue";
import { createPinia } from "pinia";
import { createInertiaApp } from "@inertiajs/vue3";

const pinia = createPinia();

createInertiaApp({
    resolve: (name) => {
        const pages = import.meta.glob("./Pages/**/*.vue", { eager: true });
        return pages[`./Pages/${name}.vue`];
    },
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(pinia);

        app.config.globalProperties.$route = route;
        app.mount(el);
    },
});
