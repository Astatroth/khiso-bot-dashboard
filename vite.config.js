import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue2';
import topLevelAwait from "vite-plugin-top-level-await";

export default defineConfig({
    plugins: [
        topLevelAwait({
            promiseExportName: '__tla',
            promiseImportName: i => `__tla_${i}`
        }),
        laravel({
            input: [
                'resources/css/app.scss',
                'resources/css/dashboard.scss',
                'resources/js/app.js',
                'resources/js/dashboard.js',
                'resources/js/Vue/vue.js'
            ],
            refresh: [
                'app/View/Components',
                'public/messages.js',
                'resources/css/**',
                'resources/js/**',
                'resources/views/**',
                'routes/**',
            ],
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        })
    ],
    resolve: {
        alias: {
            'src': __dirname + '/resources/js',
            vue: 'vue/dist/vue.esm.js'
        }
    },
    publicDir: 'public',
    build: {
        outDir: 'public/build',
        assetsDir: 'assets',
        emptyOutDir: true,
        copyPublicDir: false,
        rollupOptions: {
            output: {
                assetFileNames: (assetInfo) => {
                    let ext = assetInfo?.name?.split('.').at(1);
                    let dir = '';

                    if (/png|jpe?g|webp/i.test(ext)) {
                        dir = 'img/';
                    }

                    if (/css/i.test(ext)) {
                        dir = 'css/';
                    }

                    if (/eot|ttf|woff|woff2/i.test(ext)) {
                        dir = 'fonts/';
                    }

                    return `assets/${dir}[name]-[hash][extname]`;
                },
                chunkFileNames: 'assets/js/[name]-[hash].js',
                entryFileNames: 'assets/js/[name]-[hash].js',
                manualChunks: function (id) {
                    if (id.includes('node_modules')) {
                        return id.toString().split('node_modules/')[1].split('/')[0].toString();
                    }

                    if (id.includes('Vue/Modules')) {
                        return id.toString().split('Vue/Modules/')[1].split('/')[0].toString();
                    }
                }
            }
        }
    }
});
