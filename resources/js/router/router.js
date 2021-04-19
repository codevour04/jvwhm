import Vue from 'vue'
import VueRouter from 'vue-router'

import DashBoard from './../components/Dashboard.vue'
import Login from './../components/RegisterForm.vue'

Vue.use(VueRouter)

const routes = [
{
	path: "/Dash",
	name: "Dash",
	component: DashBoard

},
{
	path: "/",
	name: "Login",
	component: Login

}
]

const router = new VueRouter({
	mode: "history",
	routes
})

export default router;