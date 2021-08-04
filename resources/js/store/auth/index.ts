import { GetterTree, Module, MutationTree } from "vuex";
import { RootState } from "..";

export interface AuthState {
    userInfo: any;
}

const state: AuthState = {
    userInfo: JSON.parse(window.localStorage.getItem("user") || '{}')
}

const getters: GetterTree<AuthState, RootState> = {
    getuserInfo(state): any {
        return state.userInfo
    }
}


const mutations: MutationTree<AuthState> = {
    setuserInfo(state, response) {
        state.userInfo = response.user
    }
}

export const auth: Module<AuthState, RootState> = {
    state,
    getters,
    mutations
}
