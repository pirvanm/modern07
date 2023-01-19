import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { createPinia } from 'pinia';

import { InertiaProgress } from '@inertiajs/progress';
import importComponent from './dynamic-imports/import-component';
// @ts-ignore
import { ZiggyVue } from 'ziggy/vue.m';
// @ts-ignore
import { Ziggy } from '@/js/ziggy.js';
import AuthenticatedLayout from '~views/layouts/Authenticated.vue';
import '@/scss/app.scss';
import VueCookies from 'vue-cookies';
import mixin from './mixin.ts';
const appName =
  window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

const app = createInertiaApp({
  title: (title) => `${title} - ${appName}`,
  // @ts-ignore
  resolve: async (name) => {
    const component: any = await importComponent(name);
    component.default.layout ??= AuthenticatedLayout;
    return component;
  },
  // @ts-ignore
  setup({ el, app, props, plugin }) {
    return createApp({ render: () => h(app, props) })
      .use(plugin)
      .use(ZiggyVue, Ziggy)
      .use(createPinia())
      .use(VueCookies)
      .mixin(mixin)
      .mount(el);
  },
});

InertiaProgress.init({ color: '#4053d5' });
