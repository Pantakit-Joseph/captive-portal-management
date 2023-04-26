"use strict";
document.addEventListener("alpine:init", () => {
	Alpine.data("guestsAdd", () => ({
		numberOfUsers: "",
		prefix: "",
		expire: "",
		description: "",

		load: false,
		reload: false,

		init() {
			this.$root.addEventListener("hidden.coreui.modal", () => {
				this.btnClose();
			});
			flatpickr(this.$refs.expire, {
				enableTime: true,
				altInput: true,
				altFormat: "j F Y H:i",
				minDate: "today",
				time_24hr: true,
			});
		},

		submit() {
			this.load = true;
			let alert;
			appAxios
				.post(`admin/users/guests/api`, {
					numberofusers: this.numberOfUsers,
					prefix: this.prefix,
					expire: this.expire,
					description: this.description,
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

	Alpine.data("guestsButtonDelete", () => ({
		load: false,
		purgeDelete: false,
		url: "",

		username: "",
		init() {
			this.username = this.$root.value;

			this.purgeDelete = this.$root.getAttribute("data-purge") ?? false;
			this.url = `admin/users/guests/api/${this.username}`;
			if (this.purgeDelete) this.url += "/purge";
		},
		trigger: {
			["@click"]() {
				this.deleteToggle();
			},
		},
		deleteToggle() {
			const parent = this;
			this.load = true;
			Swal.fire({
				title: `คุณต้องการลบ "${this.username}" ไหม?`,
				text: "คุณจะเปลี่ยนกลับไม่ได้!",
				icon: "warning",
				showCancelButton: true,
				confirmButtonText: "ใช่ ลบเลย!",
				cancelButtonText: "ยกเลิก",
				showLoaderOnConfirm: true,
				preConfirm() {
					return parent.deleteAPI();
				},
			})
				.then((result) => {
					if (result.isConfirmed) {
						Swal.fire({
							position: "top-end",
							icon: "success",
							title: "บันทึกสำเร็จเรียบร้อย",
							didDestroy() {
								location.reload();
							},
						});
					}
				})
				.catch((error) => {
					Swal.fire({
						position: "top-end",
						icon: "error",
						title: "เกิดข้อผิดพลาด",
						text: error,
					});
				})
				.finally(() => {
					this.load = false;
				});
		},
		deleteAPI() {
			return appAxios
				.delete(this.url)
				.then((res) => {
					updateToken(res.data.token);
				})
				.catch((error) => {
					updateToken(error.response.data.token);
					this.load = false;
					if (error.response.status == 403) {
						tokenFail();
					}

					let errorMessage = error.response.data?.messages;
					updateToken(errorMessage?.token);

					let message;
					if (errorMessage?.errors) {
						message = errorMessage.errors;
					} else {
						message = "ไม่สามารถบันทึกข้อมูลได้ กรุณาลองใหม่อีกครั้ง";
					}
					throw message;
				});
		},
	}));
});
