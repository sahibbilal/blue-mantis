import { checkElementInView } from '../__utils/checkElementInView';

const animationSelectors =
	'.content-wrapper > *:not(.acf-block), .content-wrapper > .acf-block > *, .animate-in, .block-hero';
const sections = document.querySelectorAll(animationSelectors);

let loadCounter = 0;
const inViewEvent = new Event('section-in-view');

const showSection = (e) => {
	e.classList.add('in-viewport');

	if (
		e.parentElement.classList.contains('acf-block') &&
		!e.parentElement.classList.contains('in-viewport')
	) {
		e.parentElement.classList.add('in-viewport');
		e.parentElement.dispatchEvent(inViewEvent);
	}
};

const hideSection = () => {};

const atTop = () => {
	document.body.classList.remove('scrolled');
};

const notAtTop = () => {
	document.body.classList.add('scrolled');
};

const isSectionVisible = (section) => {
	const rect = section.getBoundingClientRect();

	if (
		!section.classList.contains('no-delay') &&
		rect.top < document.documentElement.clientHeight
	) {
		section.style.setProperty('--transitionDelay', `${loadCounter * 0.2}s`);

		section.classList.add('in-viewport');

		if (
			section.parentElement.classList.contains('acf-block') &&
			!section.parentElement.classList.contains('in-viewport')
		) {
			section.parentElement.classList.add('in-viewport');
			section.parentElement.dispatchEvent(inViewEvent);
		}

		if (rect.top >= 0) {
			loadCounter++;
		}
	}
};

const sectionsInView = () => {
	if (sections.length) {
		sections.forEach((section) => {
			isSectionVisible(section);
		});

		checkElementInView(animationSelectors, showSection, hideSection, {
			root: null,
			rootMargin: '0px 0px -5% 0px',
			threshold: [0],
		});
	}

	checkElementInView('#top', atTop, notAtTop, {
		root: null,
		rootMargin: '0px 0px 0px 0px',
		threshold: [1],
	});
};

export default sectionsInView;
