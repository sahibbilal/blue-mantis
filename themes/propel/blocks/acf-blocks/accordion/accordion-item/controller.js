require('dom-slider');

const { slideToggle, slideUp } = window.domSlider;

const accordionButtons = document.querySelectorAll(
	'.block-accordion-item > .wp-block-button .wp-block-button__link'
);

const accordionItems = document.querySelectorAll('.block-accordion-item');

const toggleAccordion = (e) => {
	e.preventDefault();

	const currentItem = e.currentTarget.closest('.block-accordion-item');
	const accordionBlock = e.currentTarget.closest('.block-accordion');

	if (currentItem && accordionBlock) {
		currentItem.classList.toggle('active');
		e.currentTarget.classList.toggle('active');

		const currentContent = currentItem.querySelector(
			'.block-accordion-item > .block-content'
		);

		slideToggle({
			element: currentContent,
			slideSpeed: 400,
			easing: 'ease-in-out',
		});

		if (accordionBlock.classList.contains('is-style-single-open')) {
			const activeItemContents = accordionBlock.querySelectorAll(
				'.block-accordion-item.active > .block-content'
			);

			if (activeItemContents.length) {
				activeItemContents.forEach((activeItemContent) => {
					if (activeItemContent !== currentContent) {
						activeItemContent.parentElement.classList.remove(
							'active'
						);

						slideUp({
							element: activeItemContent,
							slideSpeed: 400,
							easing: 'ease-in-out',
						});
					}
				});
			}
		}
	}
};

const accordion = () => {
	if (accordionButtons.length) {
		accordionButtons.forEach((accordionButton) => {
			accordionButton.addEventListener('click', toggleAccordion);
		});
	}

	if (accordionItems.length) {
		accordionItems.forEach((accordionItem) => {
			if (accordionItem.classList.contains('is-style-open')) {
				const accordionButton = accordionItem.querySelector(
					'.block-accordion-item > .wp-block-button .wp-block-button__link'
				);

				if (accordionButton) {
					accordionButton.classList.add('active');
				}

				accordionItem.classList.add('active');
			} else {
				const accordionContent = accordionItem.querySelector(
					'.block-accordion-item > .block-content'
				);

				if (accordionContent) {
					slideUp({
						element: accordionContent,
						slideSpeed: 0,
					});
				}
			}
		});
	}
};

// GLOBAL APP CONTROLLER
const controller = {
	init() {
		accordion();
	},
	loaded() {},
	resized() {},
	scrolled() {},
	keyDown() {},
	mouseUp() {},
};
export default controller;
