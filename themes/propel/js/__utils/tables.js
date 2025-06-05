const $ = jQuery.noConflict();

class Tables {
	constructor() {
		this.tables = $('table.tablepress');
	}

	init() {
		this.toggleShadow();
	}

	toggleShadow() {
		this.tables.each((i, el) => {
			const item = $(el);
			const scrollWrapper = item.closest('.tablepress-scroll-wrapper');

			scrollWrapper.removeClass('has-scroll');
			if (item[0].offsetWidth > scrollWrapper.width()) {
				scrollWrapper.addClass('has-scroll');
			}
		});
	}
}

export default new Tables();
