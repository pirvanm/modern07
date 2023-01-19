import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

import AutoImport from 'unplugin-auto-import/vite'
import Components from 'unplugin-vue-components/vite'
import {ElementPlusResolver} from 'unplugin-vue-components/resolvers';
import {ConfigEnv, defineConfig} from 'vite';
import Icons from 'unplugin-icons/vite'
import IconsResolver from 'unplugin-icons/resolver'

import tsconfigPaths from 'vite-tsconfig-paths'

import path from "path";

const pathResources = path.resolve(__dirname, 'resources');

export default defineConfig(({command}: ConfigEnv) => {
    return {
        resolve: {
            alias: [
                {find: '#modules', replacement: path.resolve(__dirname, 'Modules')},
                {find: '@', replacement: path.resolve(__dirname, 'resources/')},
                {
                    find: '~views',
                    replacement: path.resolve(__dirname, 'resources/ts'),
                },
                {
                    find: '~stores',
                    replacement: path.resolve(__dirname, 'resources/ts/stores'),
                },
                {
                    find: '~shared',
                    replacement: path.resolve(__dirname, 'resources/shared'),
                },
                {
                    find: '~element-plus',
                    replacement: path.resolve(__dirname, 'node_modules/element-plus'),
                },
            ],
        },
        base: command === 'build' ? '/dist/' : '',
        build: {
            manifest: true,
            outDir: "public/dist",
            rollupOptions: {
                input: {
                    app: "resources/ts/app.ts",
                },
            },
        },
        plugins: [
            laravel({
                input: 'resources/ts/app.ts',
            }),
            vue({
                template: {
                    transformAssetUrls: {
                        base: null,
                        includeAbsolute: false,
                    },
                },
            }),
            AutoImport({
                imports: ['vue', '@vueuse/core'],
                resolvers: [
                    ElementPlusResolver(),
                    IconsResolver({prefix: 'Icon',}),
                ],
                vueTemplate: true,
                dts: path.resolve(pathResources, 'typings', 'auto-imports.d.ts'),
            }),
            Components({
                resolvers: [
                    ElementPlusResolver(),
                    IconsResolver({enabledCollections: ['ep'],})
                ],
                dts: path.resolve(pathResources, 'typings', 'components.d.ts'),
            }),
            Icons({compiler: 'vue3', autoInstall: true}),
            tsconfigPaths(),
        ],
        server: {
            hmr: {
                host: "localhost",
            },
        },
        optimizeDeps: {
            include: [
                "@inertiajs/inertia",
                "@inertiajs/inertia-vue3",
                "axios",
                "vue",
                "@progress/kendo-vue-grid",
            ],
        },
    }
});
