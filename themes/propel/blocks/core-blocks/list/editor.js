const { wp } = window;
const { registerBlockStyle } = wp.blocks;

registerBlockStyle('core/list', {
	name: 'check-icon',
	label: 'Check Icon',
});
