export default {
    created () {
        this.flashMessage()
    },
    methods: {
        flashMessage () {
            this.message = localStorage ? localStorage.getItem('message') : null
            this.status = localStorage ? localStorage.getItem('status') : null
            localStorage.removeItem('message')
            localStorage.removeItem('status')
        }
    }
}