require('./bootstrap')

import Vue from 'vue'
import vuetify from '../plugins/vuetify'
import person from './class/Person'

window.Vue = require('vue')
window.Philippines = require('phil-reg-prov-mun-brgy')
window.Person = person;

Vue.component('login', require('./components/Login.vue').default)
Vue.component('register-form', require('./components/RegisterForm.vue').default)
Vue.component('list-of-people', require('./components/ListGroup.vue').default)
Vue.component('wireframe', require('./components/Wireframe.vue').default)
Vue.component('input-form', require('./components/InputForm.vue').default)

new Vue({
    el: '#app',
    vuetify,
    person
});