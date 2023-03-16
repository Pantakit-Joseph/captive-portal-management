'use strict'
document.addEventListener('alpine:init', () => {
    Alpine.data('passwordShowHide', () => ({
        type: 'password',
        icon: 'bi bi-eye-slash',

        toggle() {
            if (this.type === 'password') {
                this.type = 'text'
                this.icon = 'bi bi-eye'
            } else {
                this.type = 'password'
                this.icon = 'bi bi-eye-slash'
            }
            console.log(this.$root)
        },
        cursorPointer() {
            this.$el.style.cursor = 'pointer'
        }
    }))
})
