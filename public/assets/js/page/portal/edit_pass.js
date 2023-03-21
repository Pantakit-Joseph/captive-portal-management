'use strict'
document.addEventListener('alpine:init', () => {
    Alpine.data('formEditPassword', () => ({
        username: '',
        password: '',
        newPassword: '',
        newPasswordConfirm: '',

        usernameClass: '',
        passwordClass: '',
        newPasswordClass: '',
        newPasswordConfirmClass: '',

        usernameValid: true,
        passwordValid: true,
        newPasswordValid: true,
        newPasswordConfirmValid: true,

        notSubmit: true,

        init() {
            this.username = this.$el.querySelector('[name="username"]')?.value ?? ''
            this.password = this.$el.querySelector('[name="password"]')?.value ?? ''
            this.newPassword = this.$el.querySelector('[name="new_password"]')?.value ?? ''
            this.newPasswordConfirm = this.$el.querySelector('[name="new_password_confirm"]')?.value ?? ''
            console.log(this.newPassword)
            if (this.username
                || this.password
                || this.newPassword
                || this.newPasswordConfirm
            ) {

                this.usernameCheck()
                this.passwordCheck()
                this.newPasswordCheck()
                this.newPasswordConfirmCheck()
            }
        },

        usernameCheck() {
            if (this.username) {
                this.usernameClass = 'is-valid'
                this.usernameValid = true
            } else {
                this.usernameClass = 'is-invalid'
                this.usernameValid = false
            }
            this.submitValid()
        },
        passwordCheck() {
            if (this.password) {
                this.passwordClass = 'is-valid'
                this.passwordValid = true
            } else {
                this.passwordClass = 'is-invalid'
                this.passwordValid = false
            }
            this.submitValid()
        },
        newPasswordCheck() {
            // const regex = /(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*()_+\-=[\]{};':"\\|,.<>/?]){8,}/
            const regex = /.{8,}/
            if (this.newPassword
                && regex.test(this.newPassword)) {
                this.newPasswordClass = 'is-valid'
                this.newPasswordValid = true
            } else {
                this.newPasswordClass = 'is-invalid'
                this.newPasswordValid = false
            }
            this.newPasswordConfirmCheck()
            this.submitValid()
        },

        newPasswordConfirmCheck() {
            if (this.newPasswordConfirm
                && this.newPassword === this.newPasswordConfirm) {
                this.newPasswordConfirmClass = 'is-valid'
                this.newPasswordConfirmValid = true
            } else {
                this.newPasswordConfirmClass = 'is-invalid'
                this.newPasswordConfirmValid = false
            }
            this.submitValid()
        },

        submitValid() {
            if (this.usernameValid
                && this.passwordValid
                && this.newPasswordValid
                && this.newPasswordConfirmValid) {
                this.notSubmit = false
            } else {
                this.notSubmit = true
            }
        }
    }))
})
