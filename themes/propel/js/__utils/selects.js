const $ = jQuery.noConflict();
// class Selects {
//     constructor() {
//         this.tables = $('table.tablepress');
//     }
//     init() {
//         this.wrapTables();
//         this.responsiveTableWidth();
//         this.toggleTablesShadow();
//     }
//     wrapTables() {
//         this.tables.wrap('<div class="table-wrapper"></div>');
//     }
//     toggleTablesShadow() {
//         function shadowFunc() {
//             const el = $(this);
//             const body = el.find('tbody');
//             if (body[0].offsetWidth < body[0].scrollWidth) {
//                 el.addClass('has-scroll');
//             } else {
//                 el.removeClass('has-scroll');
//             }
//         }
//         this.tables.each(shadowFunc);
//     }
//     responsiveTableWidth() {
//         function tableWidth() {
//             const newWidth = $(window).width() - $(this).offset().left;
//             if ($('.tablet-checker').is(':visible')) {
//                 $(this).width(newWidth);
//             } else {
//                 $(this).width('');
//             }
//         }
//         this.tables.each(tableWidth);
//     }
// }
// export default new Selects();

$('.gfield select:not([multiple])').each(function () {
	// Build new elements.
	const $this = $(this),
		placeholder = $this.attr('placeholder')
			? $this.attr('placeholder')
			: 'Select Item',
		$select = $('<ul>', { class: 'mat-select__list' }),
		$wrapper = $('<div>', { class: 'mat-select' }),
		$input = $('<input>', {
			type: 'hidden',
			name: $this.attr('name'),
			class: 'mat-select__input',
		}),
		$text = $('<div>', {
			class: 'mat-select__text mat-select__text--empty',
			text: placeholder,
		});
	const $options = $this.children('option');

	// Add click event to show select.
	$text.click(function () {
		$select.toggle();
		$wrapper.toggleClass('mat-select--active');
	});

	// Create list items for the options.
	$options.each(function () {
		const $el = $(this);
		const text = $el.text().length ? $el.text() : placeholder;
		const $option = $('<li>', {
			text,
			class: 'mat-select__item',
			'data-value': $el.attr('value'),
		});
		$select.append($option);
	});

	// When an item is clicked, set the value.
	$select.on('click', 'li', function () {
		$text.text($(this).text());

		if ($(this).data('value').length) {
			$text.removeClass('mat-select__text--empty');
		} else {
			$text.addClass('mat-select__text--empty');
		}

		$(this)
			.parent()
			.hide()
			.children('li')
			.removeClass('mat-select__item--active');
		$(this).addClass('mat-select__item--active');
		$input.val($this.data('value'));
		$wrapper.removeClass('mat-select--active');
	});

	// Append our elements and remove the old one.
	$wrapper.append($text);
	$this.after($wrapper.append($input, $select));
	$this.remove();
});
