const accordionContents = document.querySelectorAll(
	'.block-accordion-side-image__content'
);

const resizeGrid = () => {
	if (accordionContents.length) {
		accordionContents.forEach((accordionContent) => {
			accordionContent.style.removeProperty('--marginTop');
			accordionContent.nextElementSibling.style.removeProperty(
				'--marginTop'
			);

			const offset =
				accordionContent.offsetTop -
				accordionContent.nextElementSibling.offsetTop;

			if (offset > 0) {
				accordionContent.style.setProperty(
					'--marginTop',
					`${offset}px`
				);
			} else {
				accordionContent.style.setProperty('--marginTop', `0px`);
			}
		});
	}
};

const accordions = () => {
	if (accordionContents.length) {
		resizeGrid();
	}
};

// GLOBAL APP CONTROLLER
const controller = {
	init() {
		accordions();
	},
	loaded() {},
	resized() {
		resizeGrid();
	},
	scrolled() {},
	keyDown() {},
	mouseUp() {},
};
export default controller;
