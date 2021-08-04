<template>
    <div>
        <nav-component link="dashboard" />
        <div class="container text-center" style="margin-top: 10%;">
            <h2 style="font-weight: 900;">Welcome back {{ userinfo.fullname }}!</h2>

            <div class="row mt-5">
                <div class="col-md-4 mr-auto ml-auto">
                    <div class="card shadow p-3 mb-2 bg-white rounded">
                        <div class="card-body text-center">
                            <h2 class="mb-0" style="font-weight: 900;">{{ total_users }}</h2>
                            <p style="font-weight: 900;">Total Number of Users</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mr-auto ml-auto">
                    <div class="card shadow p-3 mb-2 bg-white rounded">
                        <div class="card-body text-center">
                            <h2 class="mb-0" style="font-weight: 900;">{{ total_roles }}</h2>
                            <p style="font-weight: 900;">Total Number of Roles</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
    import Vue from "vue"
    import Component from "vue-class-component"
    import Nav from "../layouts/Nav.vue"
    import axios from "axios"
    @Component({
        components: {
            "nav-component" : Nav
        }
    })
    export default class Dashboard extends Vue {
        total_users: number = 0;
        total_roles: number = 0;
        get userinfo() {
            return this.$store.getters.getuserInfo
        }

        mounted(){
            axios.get("../api/users").then(res => {
                this.total_users = res.data.length
            })
            axios.get("../api/roles").then(res => {
                this.total_roles = res.data.length
            })
        }
    }

</script>
