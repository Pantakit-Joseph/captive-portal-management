"use strict";
(function () {
	window.html = (strings, ...values) => String.raw({ raw: strings }, ...values);

	window.addEventListener("load", () => {
		const tooltipTriggerList = document.querySelectorAll(
			'[data-tooltip="tooltip"]'
		);
		const tooltipList = [...tooltipTriggerList].map(
			(tooltipTriggerEl) =>
				new coreui.Tooltip(tooltipTriggerEl, {
					placement: "bottom",
				})
		);
		tooltipList;
	});
})();

(function () {
	const sidebarNode = document.querySelector("#sidebar");

	const sidebarUnfoldable = () => {
		if (window.innerWidth <= 991.98) {
			sidebarNode.classList.add("sidebar-narrow-unfoldable");
		} else {
			sidebarNode.classList.remove("sidebar-narrow-unfoldable");
		}
	};
	sidebarUnfoldable();
	window.addEventListener("resize", sidebarUnfoldable);
})();

(function () {
	const tokenEl = document.querySelector('meta[name="X-CSRF-TOKEN"]');
	const siteURL = document
		.querySelector('meta[name="site_url"]')
		?.getAttribute("content");
	const axiosInstance = () => {
		const token = tokenEl?.getAttribute("content");
		const instance = axios.create({
			baseURL: siteURL,
			headers: {
				"Content-Type": "application/json",
				"X-Requested-With": "XMLHttpRequest",
				"X-CSRF-TOKEN": token,
			},
		});

		window.appAxios = instance;
	};
	axiosInstance();

	window.updateToken = (token) => {
		if (!token) return;
		const inputTokenEl = document.querySelectorAll('input[name="csrf_token"]');
		inputTokenEl.forEach((item) => {
			item.value = token;
		});
		tokenEl.setAttribute("content", token);
		axiosInstance();
	};

	window.tokenFail = () => {
		AppToastAlert(
			"การกระทำที่คุณร้องขอไม่ได้รับอนุญาต <br>กรุณาโหลดใหม่",
			"danger"
		);
	};
})();

(function () {
	const getAppAlert = (messages = "", type = "", close = true) => {
		let msgHtml = "";
		if (typeof messages === "string" || messages instanceof String) {
			msgHtml = messages;
		} else if (typeof messages === "object" || Array.isArray(messages)) {
			msgHtml = `<ul class="m-0 ps-3">`;
			for (let key in messages) {
				msgHtml += `<li>${messages[key]}</li>`;
			}
			msgHtml += `</ul>`;
		}

		return [
			`<div class="alert alert-${type} alert-dismissible fade show" role="alert">`,
			`   ${msgHtml}`,
			close
				? `<button type="button" class="btn-close" data-coreui-dismiss="alert" aria-label="Close"></button>`
				: "",
			`</div>`,
		].join("");
	};

	const getAppToastAlert = (message, color = "") => {
		const htmlText = html`
			<div
				class="toast align-items-center text-bg-${color} border-0"
				style="--cui-bg-opacity: .85;"
				role="alert"
				aria-live="assertive"
				aria-atomic="true"
			>
				<div class="d-flex">
					<div class="toast-body">${message}</div>
					<button
						type="button"
						class="btn-close me-2 m-auto"
						data-coreui-dismiss="toast"
						aria-label="Close"
					></button>
				</div>
			</div>
		`;

		const el = new DOMParser().parseFromString(htmlText, "text/html").body
			.firstElementChild;
		return el;
	};
	const addToastStack = (toastEl) => {
		const el = document.querySelector("#toastStack");
		el.appendChild(toastEl);
	};
	const AppToastAlert = (message, color = "") => {
		const toastEl = getAppToastAlert(message, color);
		addToastStack(toastEl);

		const toast = new coreui.Toast(toastEl);
		toast.show();
		toastEl.addEventListener("hidden.coreui.toast", () => {
			toastEl.remove();
		});
	};

	window.getAppAlert = getAppAlert;
	window.AppToastAlert = AppToastAlert;
})();
