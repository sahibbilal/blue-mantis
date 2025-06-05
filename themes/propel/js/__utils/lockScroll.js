/**
 * --------------------------------------------------------------------------
 * Lock screen
 * Function locking screen scrolling, e.g for modals, menus or other
 * --------------------------------------------------------------------------
 */

const lockScroll = {
	isLocked: false,
	lock() {
		if (this.isLocked) {
			return;
		}
		this.isLocked = true;

		document.body.style.overflow = 'hidden';
	},
	unlock() {
		if (!this.isLocked) {
			return;
		}
		this.isLocked = false;

		document.body.style.overflow = '';
	},
};

export default lockScroll;
