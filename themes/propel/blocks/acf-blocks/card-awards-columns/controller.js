const blockCards = document.querySelectorAll(
	'.block-card-awards-columns .block-cards'
);

const loadMoreToggle = (e) => {
	e.currentTarget
		.closest('.block-cards')
		.classList.add('block-cards--showing');
};

const loadLessToggle = (e) => {
	e.currentTarget
		.closest('.block-cards')
		.classList.remove('block-cards--showing');
};

const maybeShowMore = () => {
	if (blockCards.length) {
		blockCards.forEach((blockCard) => {
			const awardCards = blockCard.querySelectorAll('.block-card-award');

			// If there are more than 8 award cards, show Load More btn
			if (8 < awardCards.length) {
				blockCard.classList.add('block-cards--load-more');
			}

			const loadMore = blockCard.querySelector(
				'.wp-block-button--load-more .wp-block-button__link:not(.wp-block-button__link--less)'
			);

			loadMore.addEventListener('click', loadMoreToggle);

			const loadLess = blockCard.querySelector(
				'.wp-block-button--load-more .wp-block-button__link--less'
			);

			loadLess.addEventListener('click', loadLessToggle);
		});
	}
};

// GLOBAL APP CONTROLLER
const controller = {
	init() {
		maybeShowMore();
	},
	loaded() {},
	resized() {},
	scrolled() {},
	keyDown() {},
	mouseUp() {},
};
export default controller;
