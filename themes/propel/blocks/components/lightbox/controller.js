import lockScroll from '../../../js/__utils/lockScroll';

const $ = jQuery.noConflict();

class Lightbox {
	constructor() {
		this.lightboxes = $('.component-lightbox');
		this.lightboxOpen = $('.component-lightbox__open');
		this.lightboxClose = $('.component-lightbox__close');
	}
	init() {
		this.bindEvents();
	}
	bindEvents() {
		this.lightboxOpen.on('click', this.openLightbox);
		this.lightboxClose.on('click', this.closeLightbox);
	}
	openLightbox(e) {
		e.preventDefault();
		const lightboxBlock = $(this).closest('.component-lightbox');

		lightboxBlock
			.find('.component-lightbox__container')
			.addClass('active')
			.attr('aria-hidden', false);
		if (lightboxBlock.find('.component-slider') && this.hash) {
			const slideNum = parseInt(this.hash.slice(1), 10);
			lightboxBlock
				.find('.component-slider')
				.slick('slickGoTo', slideNum, true);
		}
		if (
			e.currentTarget.getAttribute('data-embed-url') &&
			lightboxBlock.find('.component-lightbox__iframe')
		) {
			const embedUrl = e.currentTarget.getAttribute('data-embed-url');
			const ratio = e.currentTarget.getAttribute('data-ratio');
			const videoGallery = lightboxBlock.find(
				'.component-lightbox__iframe'
			);

			videoGallery.css('padding-top', `${ratio}%`);
			videoGallery.find('iframe').attr('src', embedUrl);
		}
		lockScroll.lock();
	}
	// refreshSlider() {
	// 	this.lightboxes.slick('refresh');
	// }
	closeLightbox() {
		const lightboxBlock = $(this).closest('.component-lightbox');
		lightboxBlock
			.find('.component-lightbox__container')
			.removeClass('active')
			.attr('aria-hidden', true);
		lightboxBlock.find('iframe').attr('src', '');
		lockScroll.unlock();
	}
}

const newLightbox = new Lightbox();

// GLOBAL APP CONTROLLER
const controller = {
	init() {
		newLightbox.init();
	},
	loaded() {},
	resized() {},
	scrolled() {},
	keyDown() {},
	mouseUp() {},
};
export default controller;
