'use strict'
document.addEventListener('alpine:init', () => {
    Alpine.data('passwordShowHide', () => ({
        type: 'password',
        icon: 'bi bi-eye-slash-fill',

        toggle() {
            if (this.type === 'password') {
                this.type = 'text'
                this.icon = 'bi bi-eye-fill'
            } else {
                this.type = 'password'
                this.icon = 'bi bi-eye-slash-fill'
            }
            console.log(this.$root)
        },
        cursorPointer() {
            this.$el.style.cursor = 'pointer'
        }
    }))
})
