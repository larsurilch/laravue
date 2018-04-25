<template>
    <div class="ui middle aligned center aligned grid">
        <div class="column">
            <message-box :status="status" :message="message"></message-box>
            <h2 class="ui teal image header">
                <div class="content">Autenticação</div>
            </h2>
            <form class="ui large form">
                <div class="ui stacked segment">
                    <div class="field">
                        <div class="ui left icon input">
                            <i class="user icon"></i>
                            <input type="email" name="email" placeholder="E-mail" v-model="email" tabindex="1" />
                        </div>
                    </div>
                    <div class="field">
                        <div class="ui left icon input">
                            <i class="lock icon"></i>
                            <input type="password" name="senha" placeholder="Senha" v-model="senha" tabindex="2" />
                        </div>
                    </div>
                    <button class="ui fluid large teal submit button" @click.prevent="login" tabindex="3">Enviar</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import MessageBox from '../shared/message-box/MessageBox.vue'
    import flashMessage from '../../mixins/flashMessage'

    export default {
        data () {
            return {
                email: '',
                senha: '',
                message: null,
                status: null
            }
        },

        mixins: [flashMessage],

        components: {
            'message-box': MessageBox
        },

        methods: {
            login () {
                var data = {
                    grant_type: 'password',
                    client_id: 2,
                    client_secret: 'Dq39mnKm195dkxrjw9lqXcq1iLrEr3nV0UEiY43w',
                    username: this.email,
                    password: this.senha
                }

                this.$http.post('api/oauth/token', data)
                    .then(response => {
                        if(response.body.message) {
                            this.message = response.body.message
                            this.status = response.body.status
                        } else {
                            this.$auth.setToken(response.body.access_token, response.body.expires_in + Date.now())
                            this.$store.dispatch('setAuthState', true)
                            this.$router.push("/welcome")
                        }
                    })
            }
        }
    }
</script>

<style scoped>
    .grid {
        height: 100%;
    }
    .column {
        max-width: 450px;
    }
</style>