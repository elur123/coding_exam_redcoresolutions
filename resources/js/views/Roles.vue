<template>
    <div>
        <nav-component link="roles" />
        <div class="container" style="margin-top: 6%;">
           <div class="row">
               <div class="col-md-8 mr-auto ml-auto">
                    <h2 style="font-weight: 900;" class="float-left">Roles Page</h2>
                    <button class="btn btn-sm btn-primary float-right" @click="openModal"> New Role </button>
               </div>
           </div>
           <hr>
           <div class="row">
               <div class="col-md-8 mr-auto ml-auto">
                    <h4 style="font-weight: 900;" class="float-left">Roles List</h4>
               </div>
               <div class="col-md-8 mr-auto ml-auto mb-2" v-for="(r, index) in roles" :key="r.id">
                    <div class="card shadow p-2 mb-2 bg-white rounded">
                        <div class="card-body">
                            <div class="float-left">
                                <h6 class="mb-0" style="font-weight: 800;">{{ r.role_name }}</h6>
                                <p>{{ r.description }}</p>
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
        <div class="modal fade" :class="modalRole ? 'show' : ''" tabindex="-1" role="dialog" :style="modalRole ? 'display: block' : 'display: none'">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-if="!isupdate">Create New Role</h5>
                    <h5 class="modal-title" v-if="isupdate">Update Role</h5>
                    <button type="button" class="close" aria-label="Close" @click="clear">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Role Name</label>
                        <input type="text" class="form-control" v-model="role.role_name">
                        <p class="text-danger" style="font-size:12px;">{{ errors.role_name }}</p>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea rows="4" class="form-control" v-model="role.description"></textarea>
                        <p class="text-danger" style="font-size:12px;">{{ errors.description }}</p>
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
                        <h5 class="modal-title">Delete Role</h5>
                        <button type="button" class="close" aria-label="Close" @click="clear">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <h4>Are you sure you want to delete?</h4>
                        <button class="btn btn-danger" @click="deleterole">Delete</button>
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
    export default class Roles extends Vue {
        role: any = {
            id: "",
            role_name: "",
            description: "",
        }
        errors: any = {
            role_name: "",
            description: ""
        }

        modalRole: boolean = false;
        modalDelete: boolean = false;
        isupdate: boolean = false;

        openModal(){
            this.modalRole = true
        }
        clear(){
            this.modalRole = false
            this.modalDelete = false
            this.isupdate = false
            this.role = {
                id: "",
                role_name: "",
                description: ""
            }
            this.errors = {
                role_name: "",
                description: ""
            }
        }

        create(){
            axios.post("../api/roles", this.role).then(res => {
                this.clear()
                this.$store.commit("setroles", res.data.roles)
            }).catch(err => {
                if (err.response.status === 422) {
                    console.log(err.response.data);
                    if (err.response.data.errors.role_name) {
                        this.errors.role_name = err.response.data.errors.role_name[0]
                    }
                    else if (!err.response.data.errors.role_name) {
                        this.errors.role_name = ""
                    }
                    if (err.response.data.errors.description) {
                        this.errors.description = err.response.data.errors.description[0]
                    }
                    else if (!err.response.data.errors.description) {
                        this.errors.description = ""
                    }
                }
            })
        }

        showUpdate(index: any){
            this.role = {
                id: this.roles[index].id,
                role_name: this.roles[index].role_name,
                description: this.roles[index].description
            }
            this.isupdate = true
            this.modalRole = true
        }
        update(){
            axios.put("../api/roles/" + this.role.id, this.role).then(res => {
                this.clear()
                this.$store.commit("setroles", res.data.roles)
            }).catch(err => {
                if (err.response.status === 422) {
                    console.log(err.response.data);
                    if (err.response.data.errors.role_name) {
                        this.errors.role_name = err.response.data.errors.role_name[0]
                    }
                    else if (!err.response.data.errors.role_name) {
                        this.errors.role_name = ""
                    }
                    if (err.response.data.errors.description) {
                        this.errors.description = err.response.data.errors.description[0]
                    }
                    else if (!err.response.data.errors.description) {
                        this.errors.description = ""
                    }
                }
                else{
                    alert("Nothing Changes")
                }
            })
        }

        showDelete(index: any){
            this.role = {
                id: this.roles[index].id,
                role_name: this.roles[index].role_name,
                description: this.roles[index].description
            }

            this.modalDelete = true
        }
        deleterole(){
            axios.delete("../api/roles/" + this.role.id).then(res => {
                this.clear()
                this.$store.commit("setroles", res.data.roles)
            })
        }

        get roles() {
            return this.$store.getters.getroles
        }

        mounted(){
            axios.get("../api/roles").then(res => {
                this.$store.commit("setroles", res.data)
            })
        }
    }

</script>
