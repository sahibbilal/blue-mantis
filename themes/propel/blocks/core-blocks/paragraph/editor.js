const { wp } = window;
const { registerBlockStyle } = wp.blocks;

registerBlockStyle('core/paragraph', {
	name: 'narrow',
	label: 'Narrow Width',
});

registerBlockStyle('core/paragraph', {
	name: 'wide',
	label: 'Wide Width',
});

registerBlockStyle('core/paragraph', {
	name: 'full',
	label: 'Full Width',
});
