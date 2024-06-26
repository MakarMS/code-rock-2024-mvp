import {fileURLToPath, URL} from 'node:url'
import {defineConfig} from 'vite'
import vue from '@vitejs/plugin-vue'
import VueI18nPlugin from '@intlify/unplugin-vue-i18n/vite'

export default defineConfig({
    plugins: [
        vue(),
        VueI18nPlugin({
            include: fileURLToPath(new URL('./path/to/src/locales/**', import.meta.url)),
            fullInstall: false,
            compositionOnly: true,
        }),
    ],
    resolve: {
        alias: {
            '@': fileURLToPath(new URL('./src', import.meta.url))
        }
    },
    server: {
        host: "0.0.0.0",
        port: 8080
    },
    base: "http://localhost:8080",
})
