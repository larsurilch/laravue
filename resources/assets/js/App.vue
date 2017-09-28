<template>
    <div id="app">
        <div class="ui main container">
            <h4>Iniciando com o Vue.js</h4>
            <div class="ui input">
                <input type="text" name="titulo" v-model="titulo"/>
            </div>
            <div>{{ titulo }}</div>
        </div>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                titulo: ''
            }
        }
    }
</script>

<style scoped>
    #app {
        padding: 55px 0 30px;
    }
</style>