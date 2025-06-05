/* eslint no-console: 0 */

import * as DOMPurify from 'dompurify';

const contentWrapper = document.querySelector('#page > .content-wrapper');

const hubspotForms = document.querySelectorAll(
	'body[class*="postid-"] #page > .content-wrapper .hbspt-form'
);

const marketoForms = document.querySelectorAll(
	'body[class*="postid-"] #page > .content-wrapper form[id*="mktoForm"]'
);

let postId;

const loadUnlockedContent = () => {
	if (postId) {
		const cookies = document.cookie;

		if (cookies.includes(`${postId}-ungated`)) {
			contentWrapper.classList.add('loading');

			const gatedContentUrl = `${window.WP.siteUrl}/wp-json/propel/v1/post-content/${postId}/`;

			fetch(gatedContentUrl)
				.then((response) => response.json())
				.then(processData)
				.catch((error) => {
					console.log(error);

					displayError();
				});
		}
	}
};

const processData = (data) => {
	if (data && contentWrapper) {
		contentWrapper.innerHTML = DOMPurify.sanitize(data);
	} else {
		displayError();
	}

	contentWrapper.classList.remove('loading');
};

const displayError = () => {
	hubspotForms.forEach((hubspotForm) => {
		const submittedMessage =
			hubspotForm.querySelector('.submitted-message');

		if (submittedMessage) {
			const errorElement = document.createElement('div');
			const errorMessage = document.createTextNode(
				'We apologize, there was an error unlocking the content. Please try again or contact us for assistance.'
			);

			errorElement.appendChild(errorMessage);

			submittedMessage.appendChild(errorElement);
		}
	});

	contentWrapper.classList.remove('loading');
};

const formSubmitted = (formId) => {
	if (postId && formId) {
		const d = new Date();
		const numdays = 365;
		d.setTime(d.getTime() + numdays * 24 * 60 * 60 * 1000);

		document.cookie = `${postId}-ungated=${formId};expires=${d.toUTCString()};path=/`;

		loadUnlockedContent();
	}
};

// GLOBAL APP CONTROLLER
const controller = {
	init() {
		if (
			(hubspotForms.length || marketoForms.length) &&
			document.body.classList.contains('has-gated-content') &&
			contentWrapper
		) {
			const postIdMatch = document.body.classList.value.match(
				new RegExp('(?<=postid-).*?(?= )')
			);

			if (postIdMatch[0]) {
				postId = postIdMatch[0];
			}

			loadUnlockedContent();

			if (hubspotForms.length) {
				window.addEventListener('message', (e) => {
					if (
						e.data.type === 'hsFormCallback' &&
						e.data.eventName === 'onFormSubmitted' &&
						e.data.data.formGuid
					) {
						formSubmitted(e.data.data.formGuid);
					}
				});
			}

			if (marketoForms.length) {
				window.addEventListener('marketoFormSuccess', (e) => {
					if (
						e.formEl &&
						e.values.formid &&
						e.formEl.closest('#page > .content-wrapper')
					) {
						formSubmitted(e.values.formid);
					}
				});
			}
		}
	},
	loaded() {},
	resized() {},
	scrolled() {},
	keyDown() {},
	mouseUp() {},
};
export default controller;
