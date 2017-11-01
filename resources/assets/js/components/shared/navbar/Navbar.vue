<template>
    <div class="ui fixed inverted menu">
        <router-link to="/" class="header item">CodeGeo</router-link>
        <div class="ui simple dropdown item">
            Locais <i class="dropdown icon"></i>
            <div class="menu">
                <router-link to="/paises" class="item">Países</router-link>
            </div>
        </div>
    </div>
</template>