const { wp } = window;
const { createHigherOrderComponent } = wp.compose;
const { Fragment } = wp.element;
const { InspectorControls } = wp.blockEditor;
const { PanelBody, RangeControl } = wp.components;

/**
 * Add options to column block sidebar settings.
 *
 * @param {Function} BlockEdit Original component.
 *
 * @return {Function} Wrapped component.
 */
const columnBlockOptions = createHigherOrderComponent((BlockEdit) => {
	return (props) => {
		if ('core/column' !== props.name) {
			return <BlockEdit {...props} />;
		}

		const { attributes, setAttributes } = props;
		const { width } = attributes;

		let columnSize = 6;

		if (width) {
			columnSize = Math.round((parseInt(width, 10) * 12) / 100);
		}

		return (
			<Fragment>
				<BlockEdit {...props} />
				<InspectorControls>
					<PanelBody title="Column options">
						<RangeControl
							label="Column size"
							value={columnSize}
							initialPosition={6}
							min={1}
							max={12}
							onChange={(value) => {
								setAttributes({
									width: (value / 12) * 100 + '%',
								});
							}}
						/>
					</PanelBody>
				</InspectorControls>
			</Fragment>
		);
	};
}, 'columnBlockOptions');
wp.hooks.addFilter(
	'editor.BlockEdit',
	'propel/column-block-options',
	columnBlockOptions
);
