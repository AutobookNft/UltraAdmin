import { defineConfig } from 'vite'

export default defineConfig({
  root: '.',
  publicDir: 'public',
  server: {
    watch: {
      usePolling: true
    },
    cors: true,
    hmr: {
      host: 'localhost'
    },
    port: 5173
  },
  build: {
    outDir: 'dist',
    rollupOptions: {
      input: {
        app: './resources/js/app.js'
      }
    }
  }
})