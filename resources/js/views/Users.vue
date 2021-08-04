<template>
    <div>
        <nav-component link="users" />
        <div class="container" style="margin-top: 6%;">
           <div class="row">
               <div class="col-md-8 mr-auto ml-auto">
                    <h2 style="font-weight: 900;" class="float-left">Users Page</h2>
                    <button class="btn btn-sm btn-primary float-right" @click="openModal"> New User </button>
               </div>
           </div>
           <hr>
           <div class="row">
               <div class="col-md-8 mr-auto ml-auto">
                    <h4 style="font-weight: 900;" class="float-left">Users List</h4>
               </div>
               <div class="col-md-8 mr-auto ml-auto" v-for="(u, index) in users" :key="u.id">
                    <div class="card shadow p-2 mb-2 bg-white rounded">
                        <div class="card-body">
                            <div class="float-left">
                                <h6 class="mb-0" style="font-weight: 800;">{{ u.fullname }}</h6>
                                <p>{{ u.email }}</p>
                                <span class="badge badge-success">{{ u.role_name }}</span>
                            </div>
                            <div class="float-right">
                                <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                    <div class="btn-group mr-2" role="group" aria-label="First group">
                                        <button type="button" class="btn btn-primary" @click="showUpdate(index)">
                                            Update
                                        </button>
                                    </div>
                                    <div class="btn-group mr-2" role="group" aria-label="Second group">
                                        <button type="button" class="btn btn-danger" @click="showDelete(index)">
                                            Delete
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
               </div>
           </div>
        </div>
        <div class="modal fade" :class="modalUser ? 'show' : ''" tabindex="-1" role="dialog" :style="modalUser ? 'display: block' : 'display: none'">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-if="!isupdate">Create New User</h5>
                    <h5 class="modal-title" v-if="isupdate">Update User</h5>
                    <button type="button" class="close" aria-label="Close" @click="clear">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Fullname</label>
                        <input type="text" class="form-control" v-model="user.fullname">
                        <p class="text-danger" style="font-size:12px;">{{ errors.fullname }}</p>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" v-model="user.email">
                        <p class="text-danger" style="font-size:12px;">{{ errors.email }}</p>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" v-model="user.password">
                        <p class="text-danger" style="font-size:12px;">{{ errors.password }}</p>
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" class="form-control" v-model="user.password_confirmation">
                        <p class="text-danger" style="font-size:12px;">{{ errors.password_confirmation }}</p>
                    </div>
                    <div class="form-group">
                        <label>Role</label>
                        <select class="form-control" v-model="user.role_id">
                            <option v-for="role in roles" :key="role.id" :value="role.id">{{ role.role_name }}</option>
                        </select>
                        <p class="text-danger" style="font-size:12px;">{{ errors.role_id }}</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" v-if="!isupdate" @click="create">Save changes</button>
                     <button type="button" class="btn btn-primary" v-if="isupdate" @click="update">Update changes</button>
                    <button type="button" class="btn btn-secondary" @click="clear">Close</button>
                </div>
                </div>
            </div>
        </div>
        <div class="modal fade" :class="modalDelete ? 'show' : ''" tabindex="-1" role="dialog" :style="modalDelete ? 'display: block' : 'display: none'">
            <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete User</h5>
                        <button type="button" class="close" aria-label="Close" @click="clear">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <h4>Are you sure you want to delete?</h4>
                        <button class="btn btn-danger" @click="deleteuser">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
    import axios from "axios";
    import Vue from "vue"
    import Component from "vue-class-component"
    import Nav from "../layouts/Nav.vue"
    @Component({
        components: {
            "nav-component" : Nav
        }
    })
    export default class Users extends Vue {
        user: any = {
            id: "",
            fullname: "",
            email: "",
            password: "",
            password_confirmation: "",
            role_id: ""
        }
        errors: any = {
            fullname: "",
            email: "",
            password: "",
            password_confirmation: "",
            role_id: ""
        }

        modalUser: boolean = false;
        modalDelete: boolean = false;
        isupdate: boolean = false;

        openModal(){
            this.modalUser = true
        }
        clear(){
            this.modalUser = false
            this.modalDelete = false
            this.isupdate = false
            this.user = {
                id: "",
                fullname: "",
                email: "",
                password: "",
                password_confirmation: "",
                role_id: ""
            }
            this.errors = {
                fullname: "",
                email: "",
                password: "",
                password_confirmation: "",
                role_id: ""
            }
        }

        create(){
            axios.post("../api/users", this.user).then(res => {
                this.clear()
                this.$store.commit("setusers", res.data.users)
            }).catch(err => {
                if (err.response.status === 422) {
                    console.log(err.response.data);
                    if (err.response.data.errors.fullname) {
                        this.errors.fullname = err.response.data.errors.fullname[0]
                    }
                    else if (!err.response.data.errors.fullname) {
                        this.errors.fullname = ""
                    }
                    if (err.response.data.errors.email) {
                        this.errors.email = err.response.data.errors.email[0]
                    }
                    else if (!err.response.data.errors.email) {
                        this.errors.email = ""
                    }
                    if (err.response.data.errors.password) {
                        this.errors.password = err.response.data.errors.password[0]
                    }
                    else if (!err.response.data.errors.password) {
                        this.errors.password = ""
                    }
                    if (err.response.data.errors.password_confirmation) {
                        this.errors.password_confirmation = err.response.data.errors.password_confirmation[0]
                    }
                    else if (!err.response.data.errors.password_confirmation) {
                        this.errors.password_confirmation = ""
                    }
                    if (err.response.data.errors.role_id) {
                        this.errors.role_id = err.response.data.errors.role_id[0]
                    }
                    else if (!err.response.data.errors.role_id) {
                        this.errors.role_id = ""
                    }
                }
            })
        }

        showUpdate(index: any){
            this.user = {
                id: this.users[index].id,
                fullname: this.users[index].fullname,
                email: this.users[index].email,
                password: "",
                password_confirmation: "",
                role_id: this.users[index].role_id
            }
            this.isupdate = true
            this.modalUser = true
        }
        update(){
            axios.put("../api/users/"+this.user.id, this.user).then(res => {
                this.clear()
                this.$store.commit("setusers", res.data.users)
            }).catch(err => {
                if (err.response.status === 422) {
                    console.log(err.response.data);
                    if (err.response.data.errors.fullname) {
                        this.errors.fullname = err.response.data.errors.fullname[0]
                    }
                    else if (!err.response.data.errors.fullname) {
                        this.errors.fullname = ""
                    }
                    if (err.response.data.errors.email) {
                        this.errors.email = err.response.data.errors.email[0]
                    }
                    else if (!err.response.data.errors.email) {
                        this.errors.email = ""
                    }
                    if (err.response.data.errors.password) {
                        this.errors.password = err.response.data.errors.password[0]
                    }
                    else if (!err.response.data.errors.password) {
                        this.errors.password = ""
                    }
                    if (err.response.data.errors.password_confirmation) {
                        this.errors.password_confirmation = err.response.data.errors.password_confirmation[0]
                    }
                    else if (!err.response.data.errors.password_confirmation) {
                        this.errors.password_confirmation = ""
                    }
                    if (err.response.data.errors.role_id) {
                        this.errors.role_id = err.response.data.errors.role_id[0]
                    }
                    else if (!err.response.data.errors.role_id) {
                        this.errors.role_id = ""
                    }
                }
            })
        }

        showDelete(index:any){
            this.user = {
                id: this.users[index].id,
                fullname: this.users[index].fullname,
                email: this.users[index].email,
                password: "",
                password_confirmation: "",
                role_id: this.users[index].role_id
            }
            this.modalDelete = true
        }
        deleteuser(){
            axios.delete("../api/users/"+this.user.id).then(res => {
                this.clear()
                this.$store.commit("setusers", res.data.users)
            })
        }

        get users() {
            const authId = this.$store.getters.getuserInfo.id
            return this.$store.getters.getusers.filter((e : any) => e.id !== authId)
        }
        get roles() {
            return this.$store.getters.getroles
        }

        mounted(){
            axios.get("../api/users").then(res => {
                this.$store.commit("setusers", res.data)
            })
            axios.get("../api/roles").then(res => {
                this.$store.commit("setroles", res.data)
            })
        }
    }

</script>
