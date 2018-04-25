<template>
	<div>
        <message-box :status="status" :message="message"></message-box>
        <div v-if="verify">
            <router-link :to="url" class="ui right floated button" :class="color" v-if="url">{{ label }}</router-link>
        </div>
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
    import MessageBox from '../message-box/MessageBox.vue'

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
			},
            url: String,
            label: String,
            color: String,
            status: String,
            verify: {
                default: true
            },
            message: String
		},
        components: {
		    'message-box': MessageBox
        }
	}
</script>