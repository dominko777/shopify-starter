import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

import review from './review';

export default new Vuex.Store({
    strict: true,
    modules: {
        review,
    },
});
