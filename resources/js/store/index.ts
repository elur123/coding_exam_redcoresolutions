import Vuex, { StoreOptions } from "vuex";
import Vue from "vue";
import { RootState } from "./types";


Vue.use(Vuex);



const store: StoreOptions <RootState> = {
    state: {
        helloword: "trial"
    },
    modules: {

    }
}

export default new Vuex.Store<RootState>(store);
