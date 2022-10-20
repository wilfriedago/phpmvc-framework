/** @type {import('vite').UserConfig} */
import { defineConfig } from 'vite';
import liveReload from 'vite-plugin-live-reload';

export default defineConfig({
    build: {
        outDir: "public/dist",
        manifest: true,
        rollupOptions: {
            input : 'src/main.js'
        }
    },

    publicDir: false,

    plugins: [liveReload(['views/**/*.php', 'public/*.php'])]
    });
