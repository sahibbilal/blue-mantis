const { wp } = window;
const { registerBlockStyle, unregisterBlockStyle } = wp.blocks;
const { createHigherOrderComponent } = wp.compose;
const { Fragment } = wp.element;
const { InspectorControls } = wp.blockEditor;
const { PanelBody, ComboboxControl, RadioControl, TextControl } = wp.components;

let buttonStylesRegistered = false;

/**
 * Add button block styles.
 */
const registerBlockStyles = () => {
	registerBlockStyle('core/button', {
		name: 'primary',
		label: 'Primary',
		isDefault: true,
	});

	registerBlockStyle('core/button', {
		name: 'secondary',
		label: 'Secondary',
	});

	registerBlockStyle('core/button', {
		name: 'tertiary',
		label: 'Tertiary',
	});

	registerBlockStyle('core/button', {
		name: 'social',
		label: 'Social',
	});

	registerBlockStyle('core/button', {
		name: 'text',
		label: 'Text',
	});

	buttonStylesRegistered = true;
};

registerBlockStyles();

/**
 * Add button block additional options.
 *
 * @param {Object} settings Registered block settings.
 * @param {string} name     Block name.
 *
 * @return {Object} Filtered block settings.
 */
const registerButtonBlockOptions = (settings, name) => {
	if ('core/button' !== name) {
		return settings;
	}

	return Object.assign({}, settings, {
		attributes: Object.assign({}, settings.attributes, {
			buttonSize: { type: 'string', default: 'default' },
			buttonIcon: { type: 'string' },
			iconPosition: { type: 'string', default: 'right' },
			videoUrl: { type: 'string' },
		}),
	});
};
wp.hooks.addFilter(
	'blocks.registerBlockType',
	'propel/register-button-block-options',
	registerButtonBlockOptions
);

/**
 * Add options to button block sidebar settings.
 *
 * @param {Function} BlockEdit Original component.
 *
 * @return {Function} Wrapped component.
 */
const buttonBlockOptions = createHigherOrderComponent((BlockEdit) => {
	return (props) => {
		if ('core/button' !== props.name || !window.iconpicker) {
			return <BlockEdit {...props} />;
		}

		if (props.isSelected) {
			if (
				props.attributes &&
				props.attributes.className &&
				(props.attributes.className.includes('accordion') ||
					props.attributes.className.includes('tab'))
			) {
				if (true === buttonStylesRegistered) {
					unregisterBlockStyle('core/button', 'primary');
					unregisterBlockStyle('core/button', 'secondary');
					unregisterBlockStyle('core/button', 'tertiary');
					unregisterBlockStyle('core/button', 'social');
					unregisterBlockStyle('core/button', 'text');
					buttonStylesRegistered = false;
				}

				return <BlockEdit {...props} />;
			} else if (false === buttonStylesRegistered) {
				registerBlockStyles();
			}
		}

		const { attributes, setAttributes } = props;
		const { buttonSize, buttonIcon, iconPosition, videoUrl } = attributes;
		const icons = [];

		window.iconpicker.icons.forEach((icon) => {
			const iconCode = parseInt(icon.code, 16);

			if (!isNaN(iconCode)) {
				icon.code = String.fromCharCode(iconCode);
			}

			icons.push({
				value: icon.value,
				label: icon.code + ' ' + icon.name,
			});
		});

		return (
			<Fragment>
				<BlockEdit {...props} />
				<InspectorControls>
					<PanelBody title="Button options">
						<RadioControl
							label="Button size"
							selected={buttonSize}
							options={[
								{ label: 'Default', value: 'default' },
								{ label: 'Small', value: 'small' },
							]}
							onChange={(value) => {
								setAttributes({
									buttonSize: value,
								});
							}}
						/>

						<ComboboxControl
							label="Icon"
							value={buttonIcon}
							options={icons}
							className="custom-icon-combobox"
							onChange={(value) => {
								setAttributes({
									buttonIcon: value,
								});
							}}
						/>

						<RadioControl
							label="Icon Position"
							selected={iconPosition}
							options={[
								{ label: 'Right', value: 'right' },
								{ label: 'Left', value: 'left' },
							]}
							onChange={(value) => {
								setAttributes({
									iconPosition: value,
								});
							}}
						/>

						<TextControl
							label="Video URL"
							value={videoUrl}
							help="Vimeo URL. Opens a video in a lightbox."
							type="url"
							onChange={(value) => {
								setAttributes({
									videoUrl: value,
								});

								if (value) {
									setAttributes({
										buttonIcon: 'icon-play',
										iconPosition: 'left',
									});
								}
							}}
						/>
					</PanelBody>
				</InspectorControls>
			</Fragment>
		);
	};
}, 'buttonBlockOptions');
wp.hooks.addFilter(
	'editor.BlockEdit',
	'propel/button-block-options',
	buttonBlockOptions
);

/**
 * Add wrapper to button block.
 *
 * @param {Function} BlockEdit Original component.
 *
 * @return {Function} Wrapped component.
 */
const buttonBlockEditorWrapper = createHigherOrderComponent(
	(BlockListBlock) => {
		return (props) => {
			if ('core/button' !== props.name) {
				return <BlockListBlock {...props} />;
			}

			let { buttonSize, buttonIcon, iconPosition, videoUrl } =
				props.attributes;

			let buttonClass = 'wp-block-button';

			if (buttonSize && 'small' === buttonSize) {
				buttonClass += ' wp-block-button--small';
			}

			if (videoUrl) {
				iconPosition = 'left';
				buttonIcon = 'icon-play';
			}

			if (buttonIcon || videoUrl) {
				if (iconPosition) {
					buttonClass += ' wp-block-button--icon-' + iconPosition;
				}

				const wrapperProps = {};

				if (buttonIcon) {
					wrapperProps.style = {
						'--buttonIcon': 'var(--' + buttonIcon + ')',
					};
				}

				if (videoUrl) {
					wrapperProps['data-video-url'] = videoUrl;
				}

				return (
					<BlockListBlock
						{...props}
						className={buttonClass}
						wrapperProps={wrapperProps}
					/>
				);
			}
			return <BlockListBlock {...props} className={buttonClass} />;
		};
	},
	'buttonBlockEditorWrapper'
);
wp.hooks.addFilter(
	'editor.BlockListBlock',
	'propel/button-block-editor-wrapper',
	buttonBlockEditorWrapper
);

/**
 * Save button block props to block.
 *
 * @param {Object} props      Additional props applied to save element.
 * @param {Object} blockType  Block type.
 * @param {Object} attributes Block attributes.
 *
 * @return {Object} Filtered props applied to save element.
 */
const saveButtonBlockProps = (props, blockType, attributes) => {
	if ('core/button' === blockType.name) {
		const { buttonSize, buttonIcon, iconPosition } = attributes;

		if (buttonIcon) {
			if (!props.style) {
				props.style = {};
			}

			let iconPositionClass = ' wp-block-button--icon-right';

			if (iconPosition) {
				iconPositionClass = ' wp-block-button--icon-' + iconPosition;
			}

			props.style['--buttonIcon'] = 'var(--' + buttonIcon + ')';
			props.className = props.className + iconPositionClass;
		}

		if (buttonSize && 'small' === buttonSize) {
			props.className = props.className + ' wp-block-button--small';
		}

		if (
			props.attributes &&
			props.attributes.className &&
			(props.attributes.className.includes('accordion') ||
				props.attributes.className.includes('tab'))
		) {
			//props.className = '';
		}
	}

	return props;
};
wp.hooks.addFilter(
	'blocks.getSaveContent.extraProps',
	'propel/save-button-block-props',
	saveButtonBlockProps
);
