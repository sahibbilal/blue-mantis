import { Component } from '@wordpress/element';

const acfBlocks = () => {
	if (window.acf) {
		const { createHigherOrderComponent } = wp.compose;

		const addWrapperClasses = createHigherOrderComponent(
			(BlockListBlock) => {
				class WrappedComponent extends Component {
					componentDidUpdate() {
						addAllWrapperBlockClasses();
					}

					render() {
						return <BlockListBlock {...this.props} />;
					}
				}
				return WrappedComponent;
			},
			'addWrapperClasses'
		);

		wp.hooks.addFilter(
			'editor.BlockListBlock',
			'propel/add-wrapper-classes',
			addWrapperClasses,
			99
		);

		const addWrapperBlockClasses = ($block) => {
			let blockWrapper;

			if ($block.length) {
				blockWrapper = $block[0].closest('.wp-block');
			} else {
				blockWrapper = $block;
			}

			if (
				blockWrapper &&
				blockWrapper.classList &&
				blockWrapper.firstElementChild
			) {
				let firstElementClassList = [];
				let firstElement;

				if (blockWrapper.firstElementChild.classList.length > 0) {
					firstElement = blockWrapper.firstElementChild;

					firstElementClassList =
						blockWrapper.firstElementChild.classList;
				} else if (
					blockWrapper.firstElementChild.firstElementChild &&
					blockWrapper.firstElementChild.firstElementChild.classList
						.length > 0
				) {
					firstElement =
						blockWrapper.firstElementChild.firstElementChild;

					firstElementClassList =
						blockWrapper.firstElementChild.firstElementChild
							.classList;
				}

				if (firstElementClassList.length > 0) {
					if (blockWrapper.hasAttribute('data-class')) {
						const previousClasses = blockWrapper
							.getAttribute('data-class')
							.split(' ')
							.filter((previousClass) => previousClass !== '');

						if (previousClasses.length) {
							blockWrapper.classList.remove(...previousClasses);
						}
					}

					blockWrapper.classList.add(...firstElementClassList);

					blockWrapper.setAttribute(
						'data-class',
						firstElementClassList.value
					);

					if (
						blockWrapper.classList.contains(
							'block-footer-column'
						) &&
						firstElement.hasAttribute('style')
					) {
						blockWrapper.setAttribute(
							'style',
							firstElement.getAttribute('style')
						);
					}
				}
			}
		};

		window.acf.addAction('render_block_preview', addWrapperBlockClasses);

		const addAllWrapperBlockClasses = () => {
			const blocks = document.querySelectorAll(
				'.wp-block[data-type^="acf/"]'
			);

			if (blocks.length) {
				blocks.forEach((block) => {
					addWrapperBlockClasses(block);
				});
			}
		};
		window.acf.addAction('remount', addAllWrapperBlockClasses);
		window.acf.addAction('append', addAllWrapperBlockClasses);
	}
};

export default acfBlocks;
