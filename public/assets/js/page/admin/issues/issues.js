"use strict";
document.addEventListener("alpine:init", () => {
	Alpine.data("issuesClose", () => ({
		load: false,
		init() {
			this.id = this.$root.value;
		},
		submit() {
			this.load = true;
			appAxios
				.post(`admin/issues/api/${this.id}/close`)
				.then((res) => {
					updateToken(res.data.token);
					location.reload();
				})
				.catch((error) => {
					console.log(error);
					updateToken(error.response.data.token);
					this.load = false;
					AppToastAlert(
						"ไม่สามารถปิดปัญหาได้ <br>กรุณาลองใหม่อีกครั้ง",
						"danger"
					);
				});
		},
	}));

	Alpine.data("issuesOpen", () => ({
		load: false,
		init() {
			this.id = this.$root.value;
		},
		submit() {
			this.load = true;
			appAxios
				.post(`admin/issues/api/${this.id}/open`)
				.then((res) => {
					updateToken(res.data.token);
					location.reload();
				})
				.catch((error) => {
					console.log(error);
					updateToken(error.response.data.token);
					this.load = false;
					AppToastAlert(
						"ไม่สามารถปิดปัญหาได้ <br>กรุณาลองใหม่อีกครั้ง",
						"danger"
					);
				});
		},
	}));
});
