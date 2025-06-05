import { disableBodyScroll, clearAllBodyScrollLocks } from 'body-scroll-lock';
import { checkElementInView } from '../../../js/__utils/checkElementInView';

const hamburger = document.querySelector('.block-primary-nav__hamburger');
const menu = document.querySelector('.block-primary-nav__menu');
const menuContent = document.querySelector('.block-primary-nav__menu-content');
const menuItems = document.querySelectorAll('.block-primary-nav-item');
const menuButtons = document.querySelectorAll(
	'.block-primary-nav-item > .wp-block-button:not(:only-child) .wp-block-button__link'
);
const hoverMenuButtons = document.querySelectorAll(
	'.block-primary-nav-item > .wp-block-button.is-style-text .wp-block-button__link'
);
const megaMenus = document.querySelectorAll(
	'.block-primary-nav-mega-menu__inner'
);
const backButtons = document.querySelectorAll(
	'.block-primary-nav-mega-menu__back-button'
);
const searchSection = document.querySelector('.block-primary-nav__search');
const scrollableElements = document.querySelectorAll(
	'.block-primary-nav__menu-content, .block-primary-nav-mega-menu__inner, .block-primary-nav-mega-menu__content'
);

let previousWindowSize = window.innerWidth;
let resizeTimer; // eslint-disable-line no-unused-vars

const toggleHamburger = (e = null) => {
	if (e) {
		e.preventDefault();
	}

	hamburger.classList.toggle('active');

	if (!hamburger.classList.contains('active')) {
		document.body.classList.remove('primary-menu-open');
		closeSubmenus(true);
		document.removeEventListener('keydown', clickOffMenu);
		document.removeEventListener('click', clickOffMenu);
		clearAllBodyScrollLocks();
	} else {
		closeSubmenus();
		document.body.classList.remove('search-open');
		document.body.classList.add('primary-menu-open');
		document.addEventListener('keydown', clickOffMenu);
		document.addEventListener('click', clickOffMenu);
		lockScroll();
	}
};

const toggleSubmenu = (e) => {
	e.preventDefault();
	e.currentTarget.parentElement.classList.toggle('active');

	closeSubmenus(false, e.currentTarget);

	if (!e.currentTarget.parentElement.classList.contains('active')) {
		document.body.classList.remove('primary-submenu-open');
		document.body.classList.remove('primary-submenu-visible');
		document.removeEventListener('keydown', clickOffMenu);
		document.removeEventListener('click', clickOffMenu);
		setMenuPosition();
		clearAllBodyScrollLocks();

		if (
			e.currentTarget.classList.contains(
				'block-primary-nav__search-button'
			)
		) {
			document.body.classList.remove('search-open');
		}
	} else {
		document.body.classList.add('primary-submenu-open');
		document.addEventListener('keydown', clickOffMenu);
		document.addEventListener('click', clickOffMenu);
		setMenuPosition(e.currentTarget);
		lockScroll();

		if (
			e.currentTarget.classList.contains(
				'block-primary-nav__search-button'
			)
		) {
			document.body.classList.add('search-open');
			hamburger.classList.remove('active');
			document.body.classList.remove('primary-menu-open');
		}

		setTimeout(function () {
			document.body.classList.add('primary-submenu-visible');
		}, 400);
	}
};

const outOfView = (target) => {
	target.classList.add('hidden');
};

const inView = (target) => {
	target.classList.remove('hidden');
};

const closeSubmenus = (delay = false, currentButton = null) => {
	menuButtons.forEach((menuButton) => {
		if (
			!currentButton ||
			!currentButton.parentElement.classList.contains('active') ||
			currentButton.parentElement !== menuButton.parentElement
		) {
			menuButton.parentElement.classList.remove('active');
		}
	});

	if (
		null === currentButton ||
		!currentButton.parentElement.classList.contains('active')
	) {
		if (true === delay) {
			setTimeout(function () {
				document.body.classList.remove('primary-submenu-open');
			}, 400);
		} else {
			document.body.classList.remove('primary-submenu-open');
		}
	}
};

const addMegaMenuMobileHeadingsAndClasses = () => {
	megaMenus.forEach((megaMenu) => {
		const content = megaMenu.querySelector(
			'.block-primary-nav-mega-menu__content'
		);

		if (content && content.children) {
			let megaMenuGridTemplateColumns = '';
			let columnCount = 0;
			let hasFeaturedPageCol = false;

			Object.values(content.children).forEach((child) => {
				if (child.classList.contains('block-primary-nav-column')) {
					megaMenuGridTemplateColumns += ' minmax(MINVALUE, 1fr)';
					columnCount++;
				} else if (
					child.classList.contains('block-primary-nav-featured-post')
				) {
					megaMenuGridTemplateColumns += ' auto';
				}

				if (
					child.classList.contains('block-primary-nav-featured-post')
				) {
					hasFeaturedPageCol = true;
				}
			});

			let minValue = '19rem';
			let megaMenuClass = '';

			if (columnCount > 2) {
				minValue = '12rem';
				megaMenuClass = 'block-primary-nav-mega-menu--wide';
			} else if (columnCount > 1) {
				minValue = '15rem';
			} else if (columnCount === 1 && false === hasFeaturedPageCol) {
				minValue = '12rem';
			}

			megaMenuGridTemplateColumns =
				megaMenuGridTemplateColumns.replaceAll('MINVALUE', minValue);

			megaMenu.style.setProperty(
				'--gridTemplateColumns',
				`${megaMenuGridTemplateColumns}`
			);

			megaMenu.style.setProperty('--columnCount', `${columnCount}`);

			if (megaMenuClass) {
				megaMenu.classList.add(megaMenuClass);
			}
		}

		if (
			megaMenu.parentElement.previousElementSibling &&
			megaMenu.parentElement.previousElementSibling.textContent
		) {
			const heading = document.createElement('div');
			const text = document.createTextNode(
				megaMenu.parentElement.previousElementSibling.textContent
			);
			heading.classList.add('block-primary-nav-mega-menu__heading');
			heading.appendChild(text);
			megaMenu.prepend(heading);
		}
	});
};

const clickOffMenu = (e) => {
	if (
		(e.key === undefined &&
			((!menuContent.contains(e.target) &&
				!searchSection.contains(e.target) &&
				!hamburger.contains(e.target)) ||
				(window.innerWidth >= 992 &&
					e.target.classList.contains(
						'block-primary-nav-mega-menu'
					)))) ||
		e.key === 'Escape' ||
		(window.innerWidth >= 992 &&
			e.target.classList.contains('block-primary-nav-mega-menu__inner'))
	) {
		if (window.innerWidth >= 992) {
			document.body.classList.remove('primary-submenu-visible');
			closeSubmenus();
			document.removeEventListener('keydown', clickOffMenu);
			document.removeEventListener('click', clickOffMenu);
			setMenuPosition();
			clearAllBodyScrollLocks();
		} else {
			hamburger.classList.add('active');
			toggleHamburger();
		}
	}
};

const setMenuPosition = (target = null) => {
	if (window.innerWidth < 992) {
		return;
	}

	let hover = false;

	if (target && target.type && 'button' !== target.type) {
		hover = true;
		const hoverType = target.type;
		target = target.target;

		if ('mouseover' === hoverType) {
			target.removeEventListener('mouseover', setMenuPosition);
			target.addEventListener('mouseout', setMenuPosition);
		} else if ('mouseout' === hoverType) {
			target.removeEventListener('mouseout', setMenuPosition);
			target.addEventListener('mouseover', setMenuPosition);
			target = null;
		}
	}

	if (
		target &&
		!target.classList.contains('block-primary-nav__search-button') &&
		!target.parentElement.classList.contains('is-style-primary') &&
		!target.parentElement.classList.contains('is-style-secondary')
	) {
		if (
			!document.documentElement.style.getPropertyValue(
				'--menuUnderlinePosition'
			)
		) {
			document.body.classList.add('menu-underline-init');

			document.documentElement.style.removeProperty(
				'--menuUnderlineWidth'
			);
		}

		document.documentElement.style.setProperty(
			'--menuUnderlinePosition',
			`${target.parentElement.offsetLeft / 16}rem`
		);

		setTimeout(function () {
			document.body.classList.remove('menu-underline-init');

			document.documentElement.style.setProperty(
				'--menuUnderlineWidth',
				`${
					target.offsetWidth -
					parseInt(
						window
							.getComputedStyle(target)
							.getPropertyValue('padding-right')
					)
				}`
			);
		}, 1);
	} else {
		document.documentElement.style.removeProperty('--menuUnderlineWidth');
	}

	if (true === hover) {
		return;
	}

	let megaMenuContent;

	if (target) {
		megaMenuContent = target.parentElement.parentElement.querySelector(
			'.block-primary-nav-mega-menu__content'
		);
	}

	if (megaMenuContent) {
		if (
			!document.documentElement.style.getPropertyValue('--openMenuLeft')
		) {
			document.body.classList.add('mega-menu-init');

			document.documentElement.style.removeProperty('--openMenuWidth');
		}

		megaMenuContent.style.removeProperty('--menuOffset');

		const button = target.parentElement;
		let menuContentRect = megaMenuContent.getBoundingClientRect();
		const buttonRect = button.getBoundingClientRect();
		const megaMenuRect =
			megaMenuContent.parentElement.getBoundingClientRect();
		let offset;

		if (menuContentRect.left > buttonRect.left) {
			offset =
				buttonRect.left -
				menuContentRect.left +
				button.offsetWidth / 2 -
				megaMenuContent.offsetWidth / 2;

			if (menuContentRect.left + offset < megaMenuRect.left) {
				offset = megaMenuRect.left - menuContentRect.left;
			}
		} else if (menuContentRect.right < buttonRect.left) {
			offset =
				buttonRect.right -
				menuContentRect.right -
				button.offsetWidth / 2 +
				megaMenuContent.offsetWidth / 2;

			if (menuContentRect.right + offset > megaMenuRect.right) {
				offset = megaMenuRect.right - menuContentRect.right;
			}
			//offset = buttonRect.right - menuContentRect.right;
		}

		if (offset) {
			megaMenuContent.style.setProperty(
				'--menuOffset',
				`${offset / 16}rem`
			);
			menuContentRect = megaMenuContent.getBoundingClientRect();
		}

		setTimeout(function () {
			document.documentElement.style.setProperty(
				'--openMenuLeft',
				`${menuContentRect.left / 16}rem`
			);
		}, 100);

		document.documentElement.style.setProperty(
			'--openMenuWidth',
			`${megaMenuContent.offsetWidth}`
		);

		document.documentElement.style.setProperty(
			'--openMenuBottom',
			`${
				(megaMenuContent.offsetTop +
					megaMenuContent.offsetHeight +
					64) /
				16
			}rem`
		);

		document.body.classList.remove('mega-menu-init');
	} else {
		document.documentElement.style.removeProperty('--openMenuBottom');

		setTimeout(function () {
			if (!document.body.classList.contains('primary-submenu-open')) {
				document.documentElement.style.removeProperty('--openMenuLeft');
				document.documentElement.style.removeProperty(
					'--openMenuWidth'
				);
			}
		}, 400);
	}
};

const lockScroll = () => {
	if (scrollableElements.length) {
		scrollableElements.forEach(function (scrollableElement) {
			const storedRequestAnimationFrame = window.requestAnimationFrame;
			window.requestAnimationFrame = () => 42;

			disableBodyScroll(scrollableElement, { reserveScrollBarGap: true });
			window.requestAnimationFrame = storedRequestAnimationFrame;
		});
	}
};

const resizeMenu = () => {
	if (window.innerWidth >= 992) {
		const activeButton = document.querySelector(
			'.block-primary-nav-item > .wp-block-button:not(:only-child).active .wp-block-button__link'
		);

		if (activeButton) {
			setMenuPosition(activeButton);
		}
	} else {
		document.documentElement.style.removeProperty('--menuUnderlineWidth');
		document.documentElement.style.removeProperty(
			'--menuUnderlinePosition'
		);
		document.documentElement.style.removeProperty('--openMenuBottom');
		document.documentElement.style.removeProperty('--openMenuLeft');
		document.documentElement.style.removeProperty('--openMenuWidth');
	}
};

// GLOBAL APP CONTROLLER
const controller = {
	init() {
		if (hamburger && menu && menuItems.length && menuButtons.length) {
			hamburger.addEventListener('click', toggleHamburger);

			menuButtons.forEach((menuButton) => {
				menuButton.addEventListener('click', toggleSubmenu);
			});

			hoverMenuButtons.forEach((menuButton) => {
				menuButton.addEventListener('mouseover', setMenuPosition);
			});

			checkElementInView(menu, inView, outOfView, {
				root: null,
				rootMargin: `0px 0px 0px 0px`,
				threshold: [0],
			});

			if (megaMenus.length) {
				checkElementInView(megaMenus, inView, outOfView, {
					root: null,
					rootMargin: `0px 0px 0px 0px`,
					threshold: [0],
				});

				addMegaMenuMobileHeadingsAndClasses();
			}

			if (backButtons.length) {
				backButtons.forEach((backButton) => {
					backButton.addEventListener('click', closeSubmenus);
				});
			}
		}
	},
	loaded() {
		resizeMenu();
	},
	resized() {
		if (
			document.body.classList.contains('primary-menu-open') &&
			previousWindowSize < 992 &&
			window.innerWidth >= 992
		) {
			closeSubmenus();
			toggleHamburger();
		} else if (
			document.body.classList.contains('primary-submenu-open') &&
			previousWindowSize >= 992 &&
			window.innerWidth < 992
		) {
			closeSubmenus();
		}

		document.body.classList.add('resizing');
		previousWindowSize = window.innerWidth;

		resizeTimer = setTimeout(function () {
			document.body.classList.remove('resizing');
		}, 400);

		resizeMenu();
	},
	scrolled() {},
	keyDown() {},
	mouseUp() {},
};
export default controller;
