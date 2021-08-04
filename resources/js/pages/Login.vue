<template>
    <div class="container" style="margin-top:15%;">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="form-signin">
                    <h1 class="h3 mb-3 font-weight-normal">Welcome back user!</h1>

                    <div class="form-group">
                        <label>Email address</label>
                        <input type="email" v-model="user.email" class="form-control" placeholder="Email address" required="" autofocus="">
                        <p class="text-danger" style="font-size:12px;">{{ errors.email }}</p>
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" v-model="user.password" class="form-control" placeholder="Password" required="">
                        <p class="text-danger" style="font-size:12px;">{{ errors.password }}</p>
                    </div>

                    <button class="btn btn-lg btn-primary btn-block" @click="signin">Sign in</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
    import Vue from "vue"
    import Component from "vue-class-component"
    import axios from "axios"
    @Component
    export default class Login extends Vue {
        user: any = {
            email: "",
            password: ""
        }
        errors: any = {
            email: "",
            password: ""
        }

        signin(){
            axios.post("../api/login", this.user).then(res => {
               this.$store.commit("setuserInfo", res.data)
                this.errors = {
                    email: "",
                    password: ""
                }
                window.localStorage.setItem("user", JSON.stringify(res.data.user))
                this.$router.push("/dashboard")
            }).catch(err => {
                if (err.response.status === 422) {
                    if (err.response.data.email) {
                        this.errors.email = err.response.data.email[0]
                    }
                    else if (!err.response.data.email) {
                        this.errors.email = ""
                    }
                    if (err.response.data.password) {
                        this.errors.password = err.response.data.password[0]
                    }
                    else if (!err.response.data.password) {
                        this.errors.password = ""
                    }
                }
                else{
                    this.user.password = ""
                    this.errors = {
                        email: "",
                        password: "Email and password not match"
                    }
                }
            })
        }
    }
</script>
