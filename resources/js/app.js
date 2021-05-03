/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import Person from "./Person"
import Vue from 'vue'
import vuetify from '../plugins/vuetify.js'
import phil from 'phil-reg-prov-mun-brgy'

window.Person = Person
window.Philippines = phil

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('login-form', require('./components/login-form.vue').default);
Vue.component('left-sidebar', require('./components/left-sidebar.vue').default);
Vue.component('header-bar-nav', require('./components/header-bar-nav.vue').default);
Vue.component('header-bar-nav-create', require('./components/header-bar-nav-create.vue').default);
Vue.component('left-sidebar', require('./components/left-sidebar.vue').default);
Vue.component('list-of-people', require('./components/list-of-people.vue').default);
Vue.component('list-of-city', require('./components/list-of-city.vue').default);
Vue.component('snack-bar', require('./components/snack-bar.vue').default);
Vue.component('register-form', require('./components/register-form.vue').default);
Vue.component('chart-first-timers', require('./components/chart.vue').default);
Vue.component('profile', require('./components/profile.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
	vuetify,
    el: '#app',
});
