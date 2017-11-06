<template>
	<div>
		<div class="ui form">
	        <div class="fields">
	            <slot></slot>
	            <div class="field">
	                <button class="ui labeled icon button">
	                    <i class="search icon"></i>
	                    Pesquisar
	                </button>
	            </div>
	        </div>
	    </div>
	    <div class="ui divider"></div>
	    <div v-if="total === 0" class="ui yellow message">Não há informações registradas no sistema.</div>
	    <div v-else>
	        <p>Total de registros cadastrados: {{ total }}</p>
	        <div class="ui divider"></div>
	    </div>
    </div>
</template>

<script>
	export default {
		props: {
			total: {
				required: true,
				type: Number
			}
		}
	}
</script>