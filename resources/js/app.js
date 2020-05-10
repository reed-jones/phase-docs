import './bootstrap'

import Vue from 'vue';
import App from './App.vue'
import VueRouter from 'vue-router'

import store from './store'

import PhaseRoutes from '@phased/phase/routes'

Vue.use(VueRouter)

const routerOptions = { mode: 'history', routes: PhaseRoutes }

export default new Vue({
    store,
    router: new VueRouter(routerOptions),
    render: h => h(App)
})
