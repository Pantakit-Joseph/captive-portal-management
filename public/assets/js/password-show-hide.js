'use strict'
document.addEventListener('alpine:init', () => {
    Alpine.data('passwordShowHide', () => ({
        type: 'password',
        icon: 'bi-eye-slash',
        iconPro: 'cil-eye-slash',

        toggle() {
            if (this.type === 'password') {
                this.type = 'text'
                this.icon = 'bi bi-eye'
                this.iconPro = 'cil-eye'
            } else {
                this.type = 'password'
                this.icon = 'bi bi-eye-slash'
                this.iconPro = 'cil-eye-slash'
            }
            console.log(this.$root)
        },
        cursorPointer() {
            this.$el.style.cursor = 'pointer'
        }
    }))
})
