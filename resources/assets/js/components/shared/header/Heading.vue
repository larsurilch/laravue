<template>
	<div>
		<h2 class="ui header floated left">
            <i :class="icone" class="icon"></i>
            <div class="content">
                {{ titulo }}
                <div class="sub header">{{ subtitulo }}</div>
            </div>
        </h2>
        <div class="ui divider clearing"></div>
   	</div>
</template>

<script>
	export default {
		props: {
			icone: {
				required: true,
				type: String
			},
			titulo: {
				required: true,
				type: String
			},
			subtitulo: {
				required: true,
				type: String
			}
		}
	}
</script>