const Forms = () => {
	const hubspotForm = document.querySelectorAll(
		'.hbspt-form form.hs-custom-style'
	);

	//Remove hubspot's styling from forms
	if (hubspotForm) {
		hubspotForm.forEach(function (form) {
			form.classList.remove('hs-custom-style');
		});
	}
};

export default Forms;
