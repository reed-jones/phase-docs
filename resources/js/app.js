import './bootstrap'

import Vue from 'vue';
import App from './App.vue'
import VueRouter from 'vue-router'

import store from './store'

import PhaseRoutes from '@phased/phase/routes'

Vue.use(VueRouter)

export default new Vue({
    store,
    router: new VueRouter({
        mode: 'history',
        routes: PhaseRoutes
    }),
    render: h => h(App)
})
