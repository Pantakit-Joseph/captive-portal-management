"use strict";
document.addEventListener("alpine:init", () => {
	Alpine.data("issuesTypeAdd", () => ({
		load: false,
		reload: false,

		typeName: null,
		init() {
			this.$root.addEventListener("hide.coreui.modal", () => {
				if (this.reload) location.reload();
			});
		},
		submit() {
			this.load = true;
			let alert;
			appAxios
				.post(`admin/issues/types/api`, {
					type_name: this.typeName,
				})
				.then((res) => {
					updateToken(res.data.token);
					alert = getAppAlert("บันทึกข้อมูลสำเร็จเรียบร้อย", "success");
				})
				.catch((error) => {
					console.log(error.response);
					updateToken(error.response.data.token);
					alert = getAppAlert(
						"ไม่สามารถบันทึกข้อมูลได้ กรุณาลองใหม่อีกครั้ง",
						"danger"
					);
				})
				.finally(() => {
					this.$refs.alert.innerHTML = alert;
					this.load = false;
					this.reload = true;
				});
		},
	}));

	Alpine.data("issuesTypeEdit", () => ({
		load: false,
		reload: false,

		id: null,
		typeName: null,
		init() {
			this.id = this.$root.querySelector('input[name="id"]')?.value;
			this.typeName = this.$root.querySelector(
				'input[name="type_name"]'
			)?.value;

			this.$root.addEventListener("hide.coreui.modal", () => {
				if (this.reload) location.reload();
			});
		},
		submit() {
			this.load = true;
			let alert;
			appAxios
				.put(`admin/issues/types/api/${this.id}`, {
					id: this.id,
					type_name: this.typeName,
				})
				.then((res) => {
					updateToken(res.data.token);
					alert = getAppAlert("บันทึกข้อมูลสำเร็จเรียบร้อย", "success");
				})
				.catch((error) => {
					updateToken(error.response.data.token);
					alert = getAppAlert(
						"ไม่สามารถบันทึกข้อมูลได้ กรุณาลองใหม่อีกครั้ง",
						"danger"
					);
				})
				.finally(() => {
					this.$refs.alert.innerHTML = alert;
					this.load = false;
					this.reload = true;
				});
		},
	}));

	Alpine.data("issuesTypeDelete", () => ({
		load: false,
		purgeDelete: false,
		url: "",

		id: null,
		init() {
			this.id = this.$root.value;

			this.purgeDelete = this.$root.getAttribute("data-purge") ?? false;
			this.url = `admin/issues/types/api/${this.id}`;
			if (this.purgeDelete) this.url += "/purge";
		},
		submit() {
			this.load = true;
			appAxios
				.delete(this.url)
				.then((res) => {
					updateToken(res.data.token);
					// this.$el.closest('tr')?.remove()
					location.reload();
				})
				.catch((error) => {
					updateToken(error.response.data.token);
					this.load = false;
					AppToastAlert(
						"ไม่สามารถลบประเภทปัญหาได้ <br>กรุณาลองใหม่อีกครั้ง",
						"danger"
					);
				});
		},
	}));

	Alpine.data("issuesTypeRestore", () => ({
		load: false,

		id: null,
		init() {
			this.id = this.$root.value;
		},
		submit() {
			this.load = true;
			appAxios
				.post(`admin/issues/types/api/${this.id}/restore`)
				.then((res) => {
					updateToken(res.data.token);
					location.reload();
				})
				.catch((error) => {
					updateToken(error.response.data.token);
					this.load = false;
					AppToastAlert(
						"ไม่สามารถคืนค่าประเภทปัญหาได้ <br>กรุณาลองใหม่อีกครั้ง",
						"danger"
					);
				});
		},
	}));
});
