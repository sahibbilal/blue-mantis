const $ = jQuery.noConflict();

export default function mirrorHover() {
	$(document).ready(() => {
		$('[data-mirror-hover]').each((index, item) => {
			const target = item.getAttribute('data-mirror-hover');
			const targetElem = document.querySelector(target);

			if (null !== targetElem) {
				targetElem.addEventListener('mouseover', () => {
					item.classList.add('mirror-hover');
				});
				item.addEventListener('mouseover', () => {
					targetElem.classList.add('mirror-hover');
				});
				targetElem.addEventListener('mouseout', () => {
					item.classList.remove('mirror-hover');
				});
				item.addEventListener('mouseout', () => {
					targetElem.classList.remove('mirror-hover');
				});
			}
		});
	});
}
