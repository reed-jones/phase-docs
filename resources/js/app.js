import './bootstrap'

import Vue from 'vue';
import App from './App.vue'
import Vuex, { Store } from 'vuex'
import VueRouter from 'vue-router'

import { hydrate } from '@phased/state'
import PhaseRoutes from '@phased/phase/routes'

Vue.use(Vuex)
Vue.use(VueRouter)

export default new Vue({
    store: new Store(hydrate({
        state: {
            author: 'Reed Jones <reedjones@reedjones.com>'
        }
    })),
    router: new VueRouter({
        mode: 'history',
        routes: PhaseRoutes
    }),
    render: h => h(App)
})
