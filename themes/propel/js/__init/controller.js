import Video from '../__utils/video';
import smoothScroll from '../__utils/smoothScroll';
import Forms from '../__utils/forms';
import viewportUnits from '../__utils/viewportUnits';
import AlertBar from '../__header/AlertBar';
import sectionsInView from '../__header/sectionsInView';
import storeParamsInLocalStorage from '../__header/storeParamsInLocalStorage';


// GLOBAL APP CONTROLLER
const controller = {
	init() {
		document.querySelector('html').classList.remove('no-js');
		Video.init();
		smoothScroll();
		viewportUnits();
		AlertBar();
		sectionsInView();
		storeParamsInLocalStorage();
	},
	loaded() {
		document.querySelector('body').classList.add('page-has-loaded');
		Forms();
		viewportUnits();
	},
	resized() {
		viewportUnits();
	},
	scrolled() {},
	keyDown() {},
	mouseUp() {},
};
export default controller;
