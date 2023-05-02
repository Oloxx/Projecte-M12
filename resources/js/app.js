import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createI18n } from 'vue-i18n';
import { createInertiaApp } from '@inertiajs/vue3';
import messages from '@intlify/unplugin-vue-i18n/messages';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';

import 'bootstrap/dist/js/bootstrap';
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-icons/font/bootstrap-icons.css';
//Pop up
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

// Start

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

const i18n = createI18n({
    locale: 'es',
    messages
})

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(i18n)
            .use(ZiggyVue, Ziggy)
            .use(VueSweetalert2)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
    
});
