const { wp } = window;
const { registerFormatType } = wp.richText;
const { RichTextToolbarButton } = wp.blockEditor;

const FormatGoldText = function (props) {
	return wp.element.createElement(RichTextToolbarButton, {
		icon: 'editor-textcolor',
		title: 'Gold Text',
		onClick() {
			props.onChange(
				wp.richText.toggleFormat(props.value, {
					type: 'eight29-formats/gold-text',
				})
			);
		},
		isActive: props.isActive,
	});
};

const goldText = () => {
	registerFormatType('eight29-formats/gold-text', {
		title: 'Gold Text',
		tagName: 'span',
		className: 'gold-text',
		edit: FormatGoldText,
	});
};

export default goldText;
