import Player from '@vimeo/player';
const heroBlocks = [];
const videos = document.querySelectorAll(
	'.block-hero-homepage [data-vimeo-url]'
);

const vimeoPlayer = () => {
	if (videos.length) {
		videos.forEach((video) => {
			const parentBlock = video.closest('.block-hero-homepage');

			if (parentBlock) {
				heroBlocks.push(video.closest('.block-hero-homepage'));
			}

			const player = new Player(video);

			player.setQuality('360p');

			player.on('play', function () {
				player.element.parentElement.classList.add('loaded');
			});

			Promise.all([player.getVideoWidth(), player.getVideoHeight()]).then(
				function (dimensions) {
					parentBlock.style.setProperty(
						'--videoRatio',
						`${dimensions[0] / dimensions[1]}`
					);
				}
			);

			const lightboxButton = document.querySelector(
				'.button-lightbox__close-button'
			);

			window.addEventListener('keydown', (event) => {
				if (event.key === undefined || event.key === 'Escape') {
					event.preventDefault();
					player.play();
				}
			});

			lightboxButton.addEventListener('click', () => {
				player.play();
			});
		});
	}
};

const setVideoSize = () => {
	if (heroBlocks.length) {
		heroBlocks.forEach((heroBlock) => {
			heroBlock.style.setProperty(
				'--blockHeight',
				`${heroBlock.offsetHeight / 16}rem`
			);
		});
	}
};

// GLOBAL APP CONTROLLER
const controller = {
	init() {
		vimeoPlayer();
		setVideoSize();
	},
	loaded() {},
	resized() {
		setVideoSize();
	},
	scrolled() {},
	keyDown() {},
	mouseUp() {},
};
export default controller;
