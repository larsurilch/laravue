<template>
    <div class="ui fixed inverted menu">
        <router-link to="/" class="header item">CodeGeo</router-link>
        <div class="ui simple dropdown item">
            Locais <i class="dropdown icon"></i>
            <div class="menu">
                <router-link to="/paises" class="item">Países</router-link>
                <router-link to="/estados" class="item">Estados</router-link>
                <router-link to="/cidades" class="item">Cidades</router-link>
            </div>
        </div>
        <div class="ui simple dropdown item">
            Básico <i class="dropdown icon"></i>
            <div class="menu">
                <router-link to="/marcas" class="item">Marcas</router-link>
            </div>
        </div>
    </div>
</template>