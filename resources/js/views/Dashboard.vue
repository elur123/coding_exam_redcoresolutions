<template>
    <div>
        <nav-component />
        <div class="container">

        </div>
    </div>
</template>

<script lang="ts">
    import Vue from "vue"
    import Component from "vue-class-component"
    import Nav from "../layouts/Nav.vue"
    @Component({
        components: {
            "nav-component" : Nav
        }
    })
    export default class Dashboard extends Vue {

    }

</script>
