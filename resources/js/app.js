import fontawesome from '@fortawesome/fontawesome'

import Vue from 'vue'
import Vuex from 'vuex'
import storeData from "./store/index"
import { library } from "@fortawesome/fontawesome-svg-core";
/* import { faBars } from "@fortawesome/free-solid-svg-icons"; */
import { fab } from '@fortawesome/free-brands-svg-icons'
import { fas } from '@fortawesome/free-solid-svg-icons'
import { far } from '@fortawesome/free-regular-svg-icons'
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";

library.add(fab, fas, far);
Vue.component("font-awesome-icon", FontAwesomeIcon);

import VueRouter from 'vue-router'
Vue.use(VueRouter);

window.axios = require('axios'); 
let token = document.head.querySelector('meta[name="csrf-token"]')
if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content
} else {
    console.error('CSRF token not found')
}

window.appDomain = "https://betterreview.online"

import { routes } from '../routes/routes.js'


const router = new VueRouter({
	linkActiveClass: 'is-active',
	linkExactActiveClass: 'is-active',
    routes,
    mode:'history'
});


Vue.use(Vuex)


const store = new Vuex.Store(
   storeData
)

const app = new Vue({
    el: '#app',
    store,
    router
});
