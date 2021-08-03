import "./bootstrap"

import Vue from "vue"
import router from "./router/router"
import store from "./store/index"

const app = new Vue({
    store,
    router,
    el: '#app',
});
