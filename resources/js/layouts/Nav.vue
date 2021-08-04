<template>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="#">Coding Exam</a>
        <button class="navbar-toggler collapsed" type="button" data-toggle="collapse"
            data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="navbar-collapse collapse" id="navbarsExampleDefault" style="">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item" :class="link === 'dashboard' ? 'active' : '' ">
                    <router-link to="/dashboard" class="nav-link" href="#">Dashboard</router-link>
                </li>
                <li class="nav-item" :class="link === 'users' ? 'active' : '' ">
                    <router-link to="/users" class="nav-link" href="#">Users</router-link>
                </li>
                <li class="nav-item" :class="link === 'roles' ? 'active' : '' ">
                    <router-link to="/roles" class="nav-link" href="#">Roles</router-link>
                </li>
            </ul>
            <div class="form-inline my-2 my-lg-0">
                <button class="btn btn-outline-success my-2 my-sm-0" @click="signout">Sign out</button>
            </div>
        </div>
    </nav>
</template>

<script lang="ts">
    import Vue from "vue"
    import Component from "vue-class-component"
    @Component({
        props: ['link']
    })
    export default class Nav extends Vue {
        signout(){
            localStorage.clear()
            this.$router.push("/")
        }
    }

</script>
