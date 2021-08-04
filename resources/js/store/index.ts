import Vuex, { StoreOptions } from "vuex";
import Vue from "vue";
import { auth } from "./auth"
import { roles } from "./roles"
import { users } from "./users"

Vue.use(Vuex);

export interface RootState {

}
const store: StoreOptions<RootState> = {
    modules: {
        auth,
        roles,
        users
    }
}

export default new Vuex.Store<RootState>(store);
