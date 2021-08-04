import Vue from "vue"
import VueRouter from "vue-router"

import Login from "../pages/Login.vue"
import Dashboard from "../views/Dashboard.vue"
import Roles from "../views/Roles.vue"
import Users from "../views/Users.vue"

Vue.use(VueRouter)

export default new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'Login',
            beforeEnter: (to, from, next) => {
                localStorage.getItem("user") ? next("/dashboard") : next();
            },
            component: Login
        },
        {
            path: '/dashboard',
            name: 'Dashboard',
            beforeEnter: (to, from, next) => {
                localStorage.getItem("user") ? next() : next("/");
            },
            component: Dashboard
        },
        {
            path: '/roles',
            name: 'Roles',
            beforeEnter: (to, from, next) => {
                localStorage.getItem("user") ? next() : next("/");
            },
            component: Roles
        },
        {
            path: '/users',
            name: 'Users',
            beforeEnter: (to, from, next) => {
                localStorage.getItem("user") ? next() : next("/");
            },
            component: Users
        }
    ]
})
