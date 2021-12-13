require('./bootstrap');
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import Vue from 'vue';

import VueRouter from 'vue-router';
Vue.use(VueRouter);
import router from './routes';

import App from './views/App.vue';

const app = new Vue({
    router,
    render: h => h(App),
}).$mount('#app');
