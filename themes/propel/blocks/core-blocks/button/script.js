import Player from '@vimeo/player';

const videoButtons = document.querySelectorAll('*[data-video-url]');

const lightbox = document.createElement('div');
const lightboxVideoElement = document.createElement('div');
let videoPlayer;

const openLightbox = (e) => {
	if (e.currentTarget.hasAttribute('data-video-url')) {
		e.preventDefault();

		if ('object' === typeof videoPlayer) {
			videoPlayer.destroy();
		}

		lightbox.classList.add('active');

		const options = {
			url: e.currentTarget.getAttribute('data-video-url'),
			width: 640,
			loop: false,
		};

		videoPlayer = new Player('button-lightbox-video', options);

		document.addEventListener('keydown', closeLightbox);

		setTimeout(function () {
			lightbox.classList.add('visible');

			videoPlayer.play();
		}, 1);
	}
};

const closeLightbox = (e) => {
	if (e.key === undefined || e.key === 'Escape') {
		e.preventDefault();

		if ('object' === typeof videoPlayer) {
			lightbox.classList.remove('visible');

			setTimeout(function () {
				lightbox.classList.remove('active');

				videoPlayer.destroy();
			}, 400);
		}

		document.removeEventListener('keydown', closeLightbox);
	}
};

if (videoButtons.length) {
	const lightboxInner = document.createElement('div');
	const lightboxCloseButton = document.createElement('button');

	lightbox.classList.add('button-lightbox');
	lightboxInner.classList.add('button-lightbox__inner');
	lightboxCloseButton.classList.add('button-lightbox__close-button');
	lightboxVideoElement.setAttribute('id', 'button-lightbox-video');
	lightboxVideoElement.classList.add('button-lightbox__video');
	lightboxCloseButton.setAttribute('aria-label', 'Close Lightbox');

	lightboxInner.appendChild(lightboxVideoElement);

	lightbox.appendChild(lightboxInner);
	lightbox.appendChild(lightboxCloseButton);

	document.body.appendChild(lightbox);

	videoButtons.forEach((videoButton) => {
		videoButton.addEventListener('click', openLightbox);
	});

	lightboxCloseButton.addEventListener('click', closeLightbox);
}
