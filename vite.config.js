/** @type {import('vite').UserConfig} */
import { defineConfig } from 'vite';

export default defineConfig({
    build: {
        outDir: "public/dist",
        manifest: true,
        rollupOptions: {
            input : 'src/main.js'
        }
    },

    publicDir: false,

    plugins: [
    ]
    });
