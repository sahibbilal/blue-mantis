const featuredImages = document.querySelectorAll(
	'.block-hero-post--featured-image .block-hero-post__image'
);

const setImageOffsets = () => {
	if (featuredImages.length) {
		featuredImages.forEach((featuredImage) => {
			document.body.style.removeProperty('--featuredImageOffset');

			document.body.style.setProperty(
				'--featuredImageOffset',
				`${featuredImage.offsetHeight / 16 / 2}rem`
			);
		});
	}
};

// GLOBAL APP CONTROLLER
const controller = {
	init() {
		setImageOffsets();
	},
	loaded() {},
	resized() {
		setImageOffsets();
	},
	scrolled() {},
	keyDown() {},
	mouseUp() {},
};
export default controller;
