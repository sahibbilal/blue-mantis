const { wp } = window;
const { createHigherOrderComponent } = wp.compose;
const { Fragment } = wp.element;
const { InspectorControls } = wp.blockEditor;
const { PanelBody, RangeControl } = wp.components;

/**
 * Add Media-Standard block additional attributes.
 *
 * @param {Object} settings Registered block settings.
 * @param {string} name     Block name.
 *
 * @return {Object} Filtered block settings.
 */
const registerMediaStandardBlockOptions = (settings, name) => {
	if ('core/embed' !== name) {
		return settings;
	}

	return Object.assign({}, settings, {
		attributes: Object.assign({}, settings.attributes, {
			width: {
				type: 'string',
				default: '1312',
			},
		}),
	});
};
wp.hooks.addFilter(
	'blocks.registerBlockType',
	'propel/media-standard-block',
	registerMediaStandardBlockOptions
);

/**
 * Add options to image block sidebar settings.
 *
 * @param {Function} BlockEdit Original component.
 *
 * @return {Function} Wrapped component.
 */
const mediaStandardBlockOptions = createHigherOrderComponent((BlockEdit) => {
	return (props) => {
		if ('core/image' !== props.name && 'core/embed' !== props.name) {
			return <BlockEdit {...props} />;
		}

		const { attributes, setAttributes } = props;
		const { width } = attributes;

		let columnSize = 6;

		if (width) {
			columnSize = Math.round((parseInt(width, 10) / 1312) * 12);
		}

		return (
			<Fragment>
				<BlockEdit {...props} />
				<InspectorControls>
					<PanelBody title="Column options">
						<RangeControl
							label="Column size"
							value={columnSize}
							initialPosition={12}
							min={4}
							max={12}
							onChange={(value) => {
								value = roundToClosestValue(
									value,
									[4, 6, 8, 12]
								);

								setAttributes({
									width: Math.round(
										(value / 12) * (1312 - 32 * 11) +
											(value - 1) * 32
									).toString(),
								});
							}}
						/>
					</PanelBody>
				</InspectorControls>
			</Fragment>
		);
	};
}, 'mediaStandardBlockOptions');
wp.hooks.addFilter(
	'editor.BlockEdit',
	'propel/media-standard-block',
	mediaStandardBlockOptions
);

/**
 * Add wrapper to columns block.
 *
 * @param {Function} BlockEdit Original component.
 *
 * @return {Function} Wrapped component.
 */
const mediaStandardBlockEditorWrapper = createHigherOrderComponent(
	(BlockListBlock) => {
		return (props) => {
			if ('core/image' !== props.name && 'core/embed' !== props.name) {
				return <BlockListBlock {...props} />;
			}

			const { attributes, setAttributes } = props;
			const { width, className, url } = attributes;
			let newClassName = '';

			let value = Math.round((width / 1312) * 12);

			value = roundToClosestValue(value, [4, 6, 8, 12]);

			if (className) {
				newClassName = className
					.replace(/col-[0-9]*/gm, '')
					.replace(/\s+/g, ' ');
			}

			newClassName = 'col-' + value + ' ' + newClassName;

			setAttributes({
				width: Math.round(
					(value / 12) * (1312 - 32 * 11) + (value - 1) * 32
				).toString(),
				className: newClassName,
				sizeSlug: 'col-' + value,
			});

			if (
				'library_block' ===
				wp.data.select('core/editor').getCurrentPostType()
			) {
				if (
					url &&
					window.propel &&
					window.propel.stylesheetUrl &&
					url.includes('default-image' || url.includes('placeholder'))
				) {
					setAttributes({
						url:
							window.propel.stylesheetUrl +
							'/images/block-library-placeholder.png',
					});
				}
			}

			return <BlockListBlock {...props} />;
		};
	},
	'columnsBlockEditorWrapper'
);
wp.hooks.addFilter(
	'editor.BlockListBlock',
	'propel/media-standard-block',
	mediaStandardBlockEditorWrapper
);

/**
 * Rounds to the the closest value out of an array of values.
 *
 * @param {number} value  The value to round.
 * @param {Array}  values The array of values to round to.
 *
 * @return {number} The closest value.
 */
const roundToClosestValue = (value, values) => {
	let closest = values[0];

	for (const item of values) {
		if (Math.abs(item - value) < Math.abs(closest - value)) {
			closest = item;
		}
	}

	return closest;
};
