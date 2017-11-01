<template>
    <div id="app">
        <navbar></navbar>
        <div class="ui main container">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
    import Navbar from './components/shared/navbar/Navbar.vue'

    export default {
        components: {
            'navbar': Navbar
        }
    }
</script>

<style scoped>
    #app {
        padding: 55px 0 30px;
    }
</style>