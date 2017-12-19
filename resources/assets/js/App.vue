<template>
    <div id="app">
        <navbar></navbar>
        <div class="ui main container">
            <router-view></router-view>
        </div>
        <modal></modal>
    </div>
</template>

<script>
    import Navbar from './components/shared/navbar/Navbar.vue'
    import Modal from './components/shared/modal/Modal.vue'

    export default {
        components: {
            'navbar': Navbar,
            'modal': Modal
        }
    }
</script>

<style scoped>
    #app {
        padding: 55px 0 30px;
    }
</style>