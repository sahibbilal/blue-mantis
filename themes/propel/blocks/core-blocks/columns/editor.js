const { wp } = window;
const { createHigherOrderComponent } = wp.compose;
const { Fragment } = wp.element;
const { BlockControls } = wp.blockEditor;
const { ToolbarItem, DropdownMenu, ToolbarGroup } = wp.components;

import {
	justifySpaceBetween,
	justifyCenter,
	justifyLeft,
	justifyRight,
} from '@wordpress/icons';

/**
 * Add columns block additional options.
 *
 * @param {Object} settings Registered block settings.
 * @param {string} name     Block name.
 *
 * @return {Object} Filtered block settings.
 */
const registerColumnsBlockOptions = (settings, name) => {
	if ('core/columns' !== name) {
		return settings;
	}

	return Object.assign({}, settings, {
		attributes: Object.assign({}, settings.attributes, {
			horizontalAlignmentIcon: {
				type: 'string',
				default: '',
			},
			horizontalAlignment: {
				type: 'string',
				default: 'justify-content-between',
			},
		}),
	});
};
wp.hooks.addFilter(
	'blocks.registerBlockType',
	'propel/register-columns-block-options',
	registerColumnsBlockOptions
);

/**
 * Add options to columns block sidebar settings.
 *
 * @param {Function} BlockEdit Original component.
 *
 * @return {Function} Wrapped component.
 */
const columnsBlockOptions = createHigherOrderComponent((BlockEdit) => {
	return (props) => {
		if ('core/columns' !== props.name) {
			return <BlockEdit {...props} />;
		}

		const { attributes, setAttributes } = props;
		let { horizontalAlignment, horizontalAlignmentIcon } = attributes;

		if (!horizontalAlignmentIcon) {
			if (
				!horizontalAlignment ||
				horizontalAlignment === 'justify-content-between'
			) {
				horizontalAlignmentIcon = justifySpaceBetween;
			} else if (horizontalAlignment === 'justify-content-center') {
				horizontalAlignmentIcon = justifyCenter;
			} else if (horizontalAlignment === 'justify-content-start') {
				horizontalAlignmentIcon = justifyLeft;
			} else if (horizontalAlignment === 'justify-content-end') {
				horizontalAlignmentIcon = justifyRight;
			}
		}

		return (
			<Fragment>
				<BlockControls>
					<ToolbarGroup>
						<ToolbarItem>
							{() => (
								<DropdownMenu
									icon={horizontalAlignmentIcon}
									label="Horizontal Alignment"
									controls={[
										{
											title: 'Justify Space Between',
											icon: justifySpaceBetween,
											onClick: () => {
												setAttributes({
													horizontalAlignment:
														'justify-content-between',
													horizontalAlignmentIcon:
														justifySpaceBetween,
												});
											},
										},
										{
											title: 'Justify Center',
											icon: justifyCenter,
											onClick: () => {
												setAttributes({
													horizontalAlignment:
														'justify-content-center',
													horizontalAlignmentIcon:
														justifyCenter,
												});
											},
										},
										{
											title: 'Justify Left',
											icon: justifyLeft,
											onClick: () => {
												setAttributes({
													horizontalAlignment:
														'justify-content-start',
													horizontalAlignmentIcon:
														justifyLeft,
												});
											},
										},
										{
											title: 'Justify Right',
											icon: justifyRight,
											onClick: () => {
												setAttributes({
													horizontalAlignment:
														'justify-content-end',
													horizontalAlignmentIcon:
														justifyRight,
												});
											},
										},
									]}
								/>
							)}
						</ToolbarItem>
					</ToolbarGroup>
				</BlockControls>

				<BlockEdit {...props} />
			</Fragment>
		);
	};
}, 'columnsBlockOptions');
wp.hooks.addFilter(
	'editor.BlockEdit',
	'propel/columns-block-options',
	columnsBlockOptions
);

/**
 * Add wrapper to columns block.
 *
 * @param {Function} BlockEdit Original component.
 *
 * @return {Function} Wrapped component.
 */
const columnsBlockEditorWrapper = createHigherOrderComponent(
	(BlockListBlock) => {
		return (props) => {
			if ('core/columns' !== props.name) {
				return <BlockListBlock {...props} />;
			}

			const { horizontalAlignment } = props.attributes;

			let columnsClass = 'wp-block-columns';

			if (horizontalAlignment) {
				columnsClass += ' ' + horizontalAlignment;
			}

			return <BlockListBlock {...props} className={columnsClass} />;
		};
	},
	'columnsBlockEditorWrapper'
);
wp.hooks.addFilter(
	'editor.BlockListBlock',
	'propel/columns-block-editor-wrapper',
	columnsBlockEditorWrapper
);

/**
 * Save columns block props to block.
 *
 * @param {Object} props      Additional props applied to save element.
 * @param {Object} blockType  Block type.
 * @param {Object} attributes Block attributes.
 *
 * @return {Object} Filtered props applied to save element.
 */
const saveColumnsBlockProps = (props, blockType, attributes) => {
	if ('core/columns' === blockType.name) {
		const { horizontalAlignment } = attributes;

		if (horizontalAlignment) {
			props.className = props.className + ' ' + horizontalAlignment;
		}
	}

	return props;
};
wp.hooks.addFilter(
	'blocks.getSaveContent.extraProps',
	'propel/save-columns-block-props',
	saveColumnsBlockProps
);
