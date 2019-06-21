import Vue from "vue"
import VueRouter from "vue-router"
import Home from "./pages/Index.vue"

const routes = [
    { path: '/', component: Home, name: "home" }
]

Vue.use(VueRouter);

export default new VueRouter({
    base: "/admin/",
    mode: 'history',
    strict: false,
    routes
})
