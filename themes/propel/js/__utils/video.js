const $ = jQuery.noConflict();

const Video = {
	iframeWrapper: $('.iframe-wrapper'),
	init() {
		const overlay = this.iframeWrapper.find('.iframe-wrapper__overlay');
		overlay.on('click', this.hideOverlay);
	},
	hideOverlay(e) {
		e.preventDefault();
		Video.iframeWrapper.each((i, el) => {
			const iframeSrc = $(el).find('iframe').attr('src');
			if (iframeSrc) {
				$(el).find('iframe')[0].src = '';
			}
			const imageUrl = $(el).data('image-src');
			$(el)
				.find('.iframe-wrapper__overlay')
				.css('background-image', 'url(' + imageUrl + ')')
				.show();
		});

		const parent = $(this).parents('.iframe-wrapper');
		let source = parent.find('iframe')[0].dataset.src;
		if (!parent.hasClass('wistia')) {
			source += '&autoplay=1&loop=1&rel=0&wmode=transparent';
		} else {
			source = `https://fast.wistia.net/embed/iframe/${parent.data(
				'video-id'
			)}?autoplay=1&silentAutoPlay=false`;
		}
		parent.find('iframe')[0].src = source;
		$(this).delay(300).fadeOut();
	},
};

export default Video;
