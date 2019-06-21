import '../sass/app.scss'
import Vue from "vue";
import router from "./router"
import store from "./store"
import App from "./App.vue"

const app = new Vue({
    router,
    store,
    mounted() {
        console.log(
            this.$route
        )
    },
    render: h => h(App)
}).$mount('#app');
