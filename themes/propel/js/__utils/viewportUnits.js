const viewportUnits = () => {
	document.documentElement.style.setProperty(
		'--vh',
		`${window.innerHeight * 0.01}px`
	);

	document.documentElement.style.setProperty(
		'--vw',
		`${document.body.clientWidth * 0.01}px`
	);
};

export default viewportUnits;
