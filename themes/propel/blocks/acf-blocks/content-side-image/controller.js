import * as basicScroll from 'basicscroll';
const logos = document.querySelectorAll(
	'.block-content-side-image__image-wrapper--logo'
);

const parallax = () => {
	if (logos.length) {
		logos.forEach((logo) => {
			const instance = basicScroll.create({
				elem: logo,
				direct: logo,
				from: 'top-bottom',
				to: 'bottom-top',
				props: {
					'--logoOffset': {
						from: '1',
						to: '0',
					},
				},
			});

			instance.start();
		});
	}
};

// GLOBAL APP CONTROLLER
const controller = {
	init() {
		parallax();
	},
	loaded() {},
	resized() {},
	scrolled() {},
	keyDown() {},
	mouseUp() {},
};
export default controller;
