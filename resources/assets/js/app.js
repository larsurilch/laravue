
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
import Auth from './packages/auth/Auth'
import store from './store'
import { routes } from './routes';

Vue.use(VueResource);
Vue.use(Auth);
Vue.http.options.root = 'http://codegeo.local';

Vue.http.interceptors.push((request, next) => {
    if(Vue.auth.isAuthenticated()) {
        Vue.http.headers.common['Authorization'] = 'Bearer ' + Vue.auth.getToken()
    }

    next(response => {
        if(response.status == 404)
            swal(response.status.toString(), response.body.error, "error")
        else if (response.status == 500)
            swal(response.status.toString(), "We are experiencing a problem in our servers!", "error")
    })
});

Vue.use(VueRouter);

const router = new VueRouter({
    routes,
    mode: 'history'
});

router.beforeEach(
    (to, from, next) => {
        if(to.matched.some(record => record.meta.forGuest)) {
            if(Vue.auth.isAuthenticated()) {
                next({
                    path: '/welcome'
                })
            } else next()
        } else if (to.matched.some(record => record.meta.forAuth)) {
            if(!Vue.auth.isAuthenticated()) {
                next({
                    path: '/login'
                })
            } else next()
        }
    }
)

Vue.filter('person', require('./filters/person'));
Vue.filter('currency', require('./filters/currency'));

new Vue({
    el: '#app',
    router,
    store,
    render: h => h(App)
});
