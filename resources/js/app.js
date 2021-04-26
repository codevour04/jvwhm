require('./bootstrap')

import Vue from 'vue'
import vuetify from '../plugins/vuetify'
import person from './class/Person'
import moment from 'moment'

window.Vue = require('vue')
window.Philippines = require('phil-reg-prov-mun-brgy')
window.Person = person;

Vue.component('login', require('../components/login.vue').default)
Vue.component('register-form', require('../components/register-form.vue').default)
Vue.component('list-of-people', require('../components/list-of-people.vue').default)
Vue.component('wireframe', require('../components/Wireframe.vue').default)
Vue.component('input-form', require('../components/input-form.vue').default)
Vue.component('people-of-person', require('../components/list.vue').default)
Vue.component('left-sidebar', require('../components/left-sidebar.vue').default)
Vue.component('header-bar-nav', require('../components/header-bar-nav.vue').default)
Vue.component('snack-bar', require('../components/snack-bar.vue').default)

new Vue({
    el: '#app',
    vuetify
});