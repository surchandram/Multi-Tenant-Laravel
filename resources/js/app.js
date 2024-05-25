import './bootstrap';
import './vendor/flatpickr';

/* flatpickr */
import '/node_modules/flatpickr/dist/flatpickr.css';
import '/node_modules/flatpickr/dist/themes/material_blue.css';

import 'floating-vue/dist/style.css';

import 'vue-toastification/dist/index.css';

import Vue3Signature from 'vue3-signature';

import tippy from 'tippy.js';
import 'tippy.js/dist/tippy.css';
import 'tippy.js/themes/light.css';

import 'simplebar';

import Slugify from 'slugify';
import Currency from 'currency.js';
import Choices from 'choices.js';

var currencyFormatter = function (value, options = {}) {
    return Currency(value, options);
};

var domainSlugger = function (word, options = {}) {
    return Slugify(
        word,
        Object.assign(
            {},
            {
                lower: true,
                remove: new RegExp(/[*+~.()'"!:@#^\\//]/g),
            },
            options,
        ),
    );
};

var domainNamer = function (word) {
    return word.replace(new RegExp(/[*+~.()'"!:@#^%,\\//]/g), '');
};

window.Choices = Choices;
window.slugify = Slugify;
window.domainNamer = domainNamer;
window.domainSlugger = domainSlugger;
window.currencyFormatter = currencyFormatter;
window.tippy = tippy;

import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

import { createApp, h } from 'vue';
import { createInertiaApp, router } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import mitt from 'mitt';
import VueScrollTo from 'vue-scrollto';
import hasPermissions from '@/directives/hasPermissions';
import showOnroute from '@/directives/showOnroute';
import choicesjs from '@/directives/choicesjs';
import { getAvailableLayouts, resolvePageLayout } from '@/helpers/layouts';
import __ from './helpers/lang';
import { notifications } from './plugins/notifications';
import Toast from 'vue-toastification';
import { modal } from 'momentum-modal';

const $eventBus = new mitt();
window.$eventBus = $eventBus;

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'SaaS Vue';

const files = import.meta.glob('./layouts/**/*.vue' /*, { eager: true }*/);

let layouts = getAvailableLayouts(files);

// listen to router navigate event
// and emit global 'route::changed' event
router.on('navigate', () => {
    let current = route().current();
    $eventBus.emit('route::changed', current);
});

createInertiaApp({
    title: (title) => (!title ? appName : `${title} - ${appName}`),
    resolve: async (name) => {
        const pages = import.meta.glob('./app/**/views/**/*.vue');

        // resolve page component
        let module = await resolvePageComponent(`./app/${name}.vue`, pages);

        // page layout
        if (!module.default.pageLayout) {
            module.default.layout = (await resolvePageLayout('default', layouts)()).default;
        } else {
            // find layout
            let layout = await resolvePageLayout(module.default.pageLayout, layouts)();

            // set layout
            module.default.layout = layout.default;
        }

        return module;
    },
    setup({ el, App, props, plugin }) {
        const appInstance = createApp({ render: () => h(App, props) });
        appInstance.config.globalProperties.__ = __;
        appInstance.config.globalProperties.$eventBus = $eventBus;

        appInstance
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(Toast)
            .use(notifications)
            .use(VueScrollTo)
            .use(Vue3Signature)
            .use(modal, {
                resolve: async (name) => {
                    const pages = import.meta.glob('./app/**/modals/**/*.vue');

                    // resolve page component
                    let module = await resolvePageComponent(`./app/${name}.vue`, pages);

                    return module;
                },
            })
            .mixin({ methods: { moment: window.moment } })
            .directive('permission', hasPermissions)
            .directive('show-onroute', showOnroute)
            .directive('choicesjs', choicesjs)
            .provide('$eventBus', appInstance.config.globalProperties.$eventBus)
            .provide('$scrollTo', appInstance.config.globalProperties.$scrollTo)
            .provide('$translate', appInstance.config.globalProperties.__)
            .mount(el);

        return appInstance;
    },
    progress: {
        color: '#65a30d',
    },
});
