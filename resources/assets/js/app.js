
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

require('./main');

import Vue from 'vue';
import App from './App.vue';
import VueResource from 'vue-resource';
import VueRouter from 'vue-router';
import { routes } from './routes';

Vue.use(VueResource);

Vue.http.options.root = 'http://codegeo.local';

Vue.use(VueRouter);

const router = new VueRouter({
    routes,
    mode: 'history'
});

Vue.filter('person', require('./filters/person'));

new Vue({
    el: '#app',
    router,
    render: h => h(App)
});
