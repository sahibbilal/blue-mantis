const $ = jQuery.noConflict();

const unloadedForms = document.querySelectorAll('.marketo-form');

const initForms = () => {
	if (window.MktoForms2) {
		if (unloadedForms.length) {
			unloadedForms.forEach((unloadedForm) => {
				if (unloadedForm.hasAttribute('data-id')) {
					const formId = unloadedForm.getAttribute('data-id');

					window.MktoForms2.loadForm(
						'//618-WMT-395.mktoweb.com',
						'618-WMT-395',
						formId
					);
				}
			});
		}

		window.MktoForms2.whenReady(function (mktoForm) {
			destyleMktoForm(mktoForm);

			mktoForm.onSuccess(function (values) {
				if (values.formid) {
					const form = document.getElementById(
						'mktoForm_' + values.formid
					);

					if (form) {
						const successEvent = new Event('marketoFormSuccess');
						successEvent.values = values;
						successEvent.formEl = form;
						window.dispatchEvent(successEvent);

						if (form.hasAttribute('data-thank-you-message')) {
							form.innerHTML = //JSON.parse(
								form.getAttribute('data-thank-you-message');
							// );

							$('html, body').animate(
								{
									scrollTop:
										$(form).offset().top -
										$('.main-header').outerHeight() -
										64,
								},
								600
							);
						} else if (form.hasAttribute('data-thank-you-url')) {
							document.location.href =
								form.getAttribute('data-thank-you-url');
						}
					}
				}

				return false;
			});
		});
	}
};

const destyleMktoForm = (mktoForm) => {
	mktoForm.getFormElem().each(function () {
		const formEl = this;
		const arrayify = getSelection.call.bind([].slice);
		// remove element styles from <form> and children
		const styledEls = arrayify(formEl.querySelectorAll('[style]')).concat(
			formEl
		);
		styledEls.forEach(function (el) {
			el.removeAttribute('style');
		});

		$(formEl).find('style').remove();

		// disable remote stylesheets and local <style>
		const styleSheets = arrayify(document.styleSheets);
		styleSheets.forEach(function (ss) {
			if (
				formEl.contains(ss.ownerNode) ||
				ss.ownerNode.id === 'mktoForms2BaseStyle' ||
				ss.ownerNode.id === 'mktoForms2ThemeStyle'
			) {
				ss.disabled = true;
			}
		});

		const emptyCheckLabels = formEl.querySelectorAll(
			'.mktoFieldWrap .mktoCheckboxList > label:empty, .mktoFieldWrap .mktoRadioList > label:empty'
		);

		if (emptyCheckLabels.length) {
			emptyCheckLabels.forEach((emptyCheckLabel) => {
				emptyCheckLabel
					.closest('.mktoFieldWrap')
					.classList.add('mktoFieldWrap--empty-label');
			});
		}

		const asterisks = formEl.querySelectorAll('.mktoAsterix');

		if (asterisks.length) {
			asterisks.forEach((asterisk) => {
				asterisk.parentElement.append(asterisk);
			});
		}
	});

	const customStyles = $('#mktoForms2ThemeStyle').next('style');

	if (customStyles.length) {
		if (customStyles.html().includes('.mktoForm')) {
			customStyles.remove();
		}
	}
};

// GLOBAL APP CONTROLLER
const controller = {
	init() {
		initForms();
	},
	loaded() {},
	resized() {},
	scrolled() {},
	keyDown() {},
	mouseUp() {},
};
export default controller;
