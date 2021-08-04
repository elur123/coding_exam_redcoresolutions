import { GetterTree, Module, MutationTree } from "vuex";
import { RootState } from "..";

export interface RolesState {
    roles: any;
}

const state: RolesState = {
    roles: []
}

const getters: GetterTree<RolesState, RootState> = {
    getroles(state): any {
        return state.roles
    }
}


const mutations: MutationTree<RolesState> = {
    setroles(state, response) {
        state.roles = response
    }
}

export const roles: Module<RolesState, RootState> = {
    state,
    getters,
    mutations
}
