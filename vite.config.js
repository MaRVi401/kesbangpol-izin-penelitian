import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import { glob } from 'glob';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css',
                ...glob.sync('resources/js/*.js'),
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        //host: '0.0.0.0',
        
        host: '127.0.0.1',
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
        /* hmr:{
            
            host: '192.168.200.3', 
        } */
    },
});