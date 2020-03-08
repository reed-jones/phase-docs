import Vue from 'vue';
import Vuex, { Store } from 'vuex'
import { hydrate } from '@phased/state'

import phase from './modules/phase'

Vue.use(Vuex)

export default new Store(hydrate({
    state: {
        project: 'Phase',
        author: 'Reed Jones <reedjones@reedjones.com>',
        repo: 'reed-jones/phase',
    },
    modules: {
        phase
    }
}))
