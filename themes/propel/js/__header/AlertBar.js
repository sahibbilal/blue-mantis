function AlertBar() {
	const body = document.body;
	const alertContainer = document.getElementById('e29-alert-bar');
	const alertItems = alertContainer
		? alertContainer.querySelectorAll('.alert-bar__item')
		: false;
	const currentStorage = JSON.parse(sessionStorage.getItem('e29-alert-bar'));
	const alertState = currentStorage ? currentStorage : {};

	//Add height to body for other fixed/absolute elements
	if (alertContainer) {
		const alertObserver = new ResizeObserver((entries) => {
			entries.forEach(() => {
				const alertContainerTop = alertContainer.offsetTop;
				const alertContainerHeight = alertContainer.offsetHeight;
				body.style.setProperty(
					'--alert-bar-height',
					`${alertContainerHeight + alertContainerTop}px`
				);
			});
		});

		alertObserver.observe(alertContainer);
	}

	//Manage viewed state
	function setStorage() {
		sessionStorage.setItem('e29-alert-bar', JSON.stringify(alertState));
	}

	if (alertItems) {
		alertItems.forEach((alertItem) => {
			const alertClose = alertItem.querySelector('.alert-bar__close');
			const alertID = alertItem.getAttribute('id');

			//Loop through local storage and determine what has been viewed
			if (currentStorage) {
				for (const item in currentStorage) {
					if (item === alertID && currentStorage[item].viewed) {
						document.getElementById(item).classList.add('viewed');
					}
					if (item === alertID && !currentStorage[item].viewed) {
						document
							.getElementById(item)
							.classList.remove('viewed');
					}
				}
			}

			//No local storage, set all to not viewed
			else {
				alertState[alertID] = { viewed: false };
				alertItem.classList.remove('viewed');
			}

			//Close alert item and set local storage
			if (alertClose) {
				alertClose.addEventListener('click', function (e) {
					e.preventDefault();
					alertItem.classList.add('viewed');
					alertState[alertID] = { viewed: true };
					setStorage();
				});
			}

			//Create local storage if it doesn't exist
			if (!currentStorage) {
				setStorage();
			}
		});
	}
}

export default AlertBar;
