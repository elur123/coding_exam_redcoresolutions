import { GetterTree, Module, MutationTree } from "vuex";
import { RootState } from "..";

export interface UsersState {
    users: any;
}

const state: UsersState = {
    users: []
}

const getters: GetterTree<UsersState, RootState> = {
    getusers(state): any {
        return state.users
    }
}


const mutations: MutationTree<UsersState> = {
    setusers(state, response) {
        state.users = response
    }
}

export const users: Module<UsersState, RootState> = {
    state,
    getters,
    mutations
}
