const clearButtons = document.querySelectorAll('a[href="#clear"]');
const searchFields = document.querySelectorAll('.search-field__input');

if (clearButtons.length && searchFields.length) {
	clearButtons.forEach((clearButton) => {
		clearButton.addEventListener('click', function (e) {
			e.preventDefault();
			e.currentTarget.blur();

			searchFields.forEach((searchField) => {
				searchField.value = '';

				window.scroll({
					top: 0,
					behavior: 'smooth',
				});
			});
		});
	});
}
