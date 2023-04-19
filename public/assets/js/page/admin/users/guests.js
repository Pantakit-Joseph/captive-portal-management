"use strict";
document.addEventListener("alpine:init", () => {
	Alpine.data("guestsAdd", () => ({
		numberOfUsers: "",
		prefix: "",

		load: false,
		reload: false,

		init() {
			this.$root.addEventListener("hidden.coreui.modal", () => {
				this.btnClose();
			});
		},

		submit() {
			this.load = true;
			let alert;
			appAxios
				.post(`admin/users/guests/api`, {
					numberofusers: this.numberOfUsers,
					prefix: this.prefix,
				})
				.then((res) => {
					updateToken(res.data.token);
					alert = getAppAlert("บันทึกข้อมูลสำเร็จเรียบร้อย", "success");
					this.reload = true;
				})
				.catch((error) => {
					if (error.response.status == 403) {
						tokenFail();
					}

					let errorMessage = error.response.data?.messages;
					updateToken(errorMessage?.token);
					if (errorMessage?.errors) {
						alert = getAppAlert(errorMessage.errors, "danger");
					} else {
						alert = getAppAlert(
							"ไม่สามารถบันทึกข้อมูลได้ กรุณาลองใหม่อีกครั้ง",
							"danger"
						);
					}
				})
				.finally(() => {
					if (alert) {
						this.$refs.alert.innerHTML = alert;
					}
					this.load = false;
					this.reload = true;
				});
		},

		btnClose() {
			if (this.reload) {
				location.reload();
			}
		},
	}));
});
