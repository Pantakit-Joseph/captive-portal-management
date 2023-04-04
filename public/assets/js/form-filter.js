"use strict";
document.addEventListener("alpine:init", () => {
	Alpine.data("formFilter", () => ({
		submit() {
			this.$root.submit();
		},
	}));
});
