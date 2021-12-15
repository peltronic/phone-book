require('./bootstrap');
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import Vue from 'vue';

import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
Vue.use(BootstrapVue)
Vue.use(IconsPlugin)

import VueRouter from 'vue-router';
Vue.use(VueRouter);
import router from './routes';

import VueMask from 'v-mask'
Vue.use(VueMask, {
  placeholders: {
    //'#': null,       // passing `null` removes default placeholder, so `#` is treated as character
    //D: /\d/,
    C: /\+/, 
    //Я: /[\wа-яА-Я]/, // cyrillic letter as a placeholder
  }
});

import CountryFlag from 'vue-country-flag'
Vue.use(CountryFlag)
//Vue.component('country-flag', CountryFlag)

import App from './views/App.vue';

const app = new Vue({
    router,
    render: h => h(App),
}).$mount('#app');
