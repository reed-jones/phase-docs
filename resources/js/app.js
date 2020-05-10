import './bootstrap'

import Vue from 'vue';
import App from './App.vue'

// Vuex Store
import store from './store'

// Vue Router
import VueRouter from 'vue-router'
Vue.use(VueRouter)

// Phase Routes & Vue Router Options
import PhaseRoutes from '@phased/phase/routes'
const routerOptions = { mode: 'history', routes: PhaseRoutes }

// Export Phase app for SSR
export default new Vue({
    store,
    router: new VueRouter(routerOptions),
    render: h => h(App)
})
