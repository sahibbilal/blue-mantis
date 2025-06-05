const $ = jQuery.noConflict();
import 'slick-carousel';

const sliders = document.querySelectorAll('.component-slider');

// GLOBAL APP CONTROLLER
const controller = {
	init() {
		if (sliders.length) {
			sliders.forEach((slider) => {
				if (slider.childElementCount) {
					slider.setAttribute(
						'data-slide-count',
						slider.childElementCount
					);
				}

				if (!slider.hasAttribute('data-slick')) {
					const parentWithSettings = slider.closest('[data-slick]');

					if (parentWithSettings) {
						slider.setAttribute(
							'data-slick',
							parentWithSettings.getAttribute('data-slick')
						);
					}
				}
			});

			$('.component-slider[data-slick*="pageCount"]').on(
				'init reInit afterChange',
				function (event, slick, currentSlide, nextSlide) { // eslint-disable-line
					if (!slick.$dots) {
						return;
					}

					if (slick.$dots[0].children.length && slick.slideCount) {
						slick.$dots[0].removeAttribute('role');

						Array.from(slick.$dots[0].children).forEach(
							(dot, index) => {
								dot.classList.add('slick-dot--page-count');
								let currentIndex = index + 1;

								if (
									slick.options.slidesToScroll &&
									slick.options.slidesToScroll > 1
								) {
									currentIndex = index + 1;
								}

								if (dot.firstElementChild) {
									dot.innerHTML = '';
									const dotContent =
										document.createElement('span');
									dotContent.setAttribute('role', 'tab');
									dotContent.textContent =
										currentIndex +
										' of ' +
										Math.ceil(
											slick.slideCount /
												slick.options.slidesToScroll
										);

									dot.appendChild(dotContent);
								}
							}
						);
					}
				}
			);

			$('.component-slider[data-slick*="customCallbacks"]')
				.on(
					'beforeChange',
					function (event, slick, currentSlide, nextSlide) {
						if (
							slick.slideCount - slick.options.slidesToScroll ===
								currentSlide &&
							0 === nextSlide
						) {
							const activeSlides = event.target.querySelectorAll(
								'.slick-slide.slick-active'
							);

							if (activeSlides.length) {
								activeSlides.forEach((slide, index) => {
									if (index + 1 === activeSlides.length) {
										slide.classList.remove(
											'slick-clone-current'
										);

										if (slide.nextElementSibling) {
											let nextSlideElement =
												slide.nextElementSibling;

											for (
												let i = 0;
												i <
												slick.options.slidesToScroll;
												i++
											) {
												nextSlideElement.classList.add(
													'slick-clone-current'
												);

												if (
													nextSlideElement.nextElementSibling
												) {
													nextSlideElement =
														nextSlideElement.nextElementSibling;
												}
											}
										}
									} else if (0 !== index) {
										slide.classList.add(
											'slick-clone-current'
										);
									}
								});
							}
						} else if (
							slick.slideCount - slick.options.slidesToScroll ===
								nextSlide &&
							0 === currentSlide
						) {
							const activeSlides =
								event.target.querySelectorAll('.slick-active');

							if (activeSlides.length) {
								activeSlides.forEach((slide, index) => {
									if (0 === index) {
										slide.classList.remove(
											'slick-clone-current'
										);

										if (slide.previousElementSibling) {
											let previousSlideElement =
												slide.previousElementSibling;

											for (
												let i = 0;
												i <
												slick.options.slidesToScroll;
												i++
											) {
												previousSlideElement.classList.add(
													'slick-clone-current'
												);

												if (
													previousSlideElement.previousElementSibling
												) {
													previousSlideElement =
														previousSlideElement.previousElementSibling;
												}
											}
										}
									} else if (
										index <
										activeSlides.length - 1
									) {
										slide.classList.add(
											'slick-clone-current'
										);
									}
								});
							}
						}
					}
				)
			.on('afterChange', function (event, slick, currentSlide) { // eslint-disable-line
					$('.slick-clone-current').removeClass(
						'slick-clone-current'
					);
				});

			$('.component-slider').slick();

			$(window).on('block-library-change', function () {
				$('.component-slider').slick('refresh');
			});
		}
	},
	loaded() {},
	resized() {},
	scrolled() {},
	keyDown() {},
	mouseUp() {},
};
export default controller;
