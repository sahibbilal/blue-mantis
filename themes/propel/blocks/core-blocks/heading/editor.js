const { wp } = window;
const { registerBlockStyle } = wp.blocks;

registerBlockStyle('core/heading', {
	name: 'narrow',
	label: 'Narrow Width',
});

registerBlockStyle('core/heading', {
	name: 'wide',
	label: 'Wide Width',
});

registerBlockStyle('core/heading', {
	name: 'full',
	label: 'Full Width',
});
