const $ = jQuery.noConflict();
function scrollFunc(e) {
	e.preventDefault();
	const header = $('.main-header');
	const stickyClass = 'main-header--sticky';
	const target = $($(this).attr('href'));
	let stickyHeight = 0;
	if (header.hasClass(stickyClass)) {
		stickyHeight = header.outerHeight();
	}
	if (
		$(this).attr('href') === '#next' &&
		$(this).parents('section').next().length > 0
	) {
		// Smooth Scroll to next section
		$('html, body').animate(
			{
				scrollTop:
					$(this).parents('section').next().offset().top -
					stickyHeight,
			},
			600
		);
	} else if (target.length) {
		$('html, body').animate(
			{
				scrollTop: target.offset().top - stickyHeight,
			},
			600
		);
	}
}
function smoothScroll() {
	$('a[href^="#"]:not([href="#"])').on('click', scrollFunc);
}
export default smoothScroll;
