import { createApp, h } from 'vue'
import { createInertiaApp, Head, Link } from '@inertiajs/vue3'
import '../css/app.css'
import Layout from './Layouts/Layout.vue'
import { ZiggyVue } from "../../vendor/tightenco/ziggy"
createInertiaApp({

    title: (title) => `My App ${title}`,
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
        const page = pages[`./Pages/${name}.vue`]
        page.default.layout = page.default.layout || Layout
        if (!page) {
            throw new Error(`Página no encontrada: ./Pages/${name}.vue`)
        }
        return page
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .component('Head', Head)
            .component('Link', Link)
            .mount(el)
    },
    progress: {

        // The color of the progress bar...
        color: '#fff',

        // Whether to include the default NProgress styles...
        includeCSS: true,

        // Whether the NProgress spinner will be shown...
        showSpinner: false,
    },
})
