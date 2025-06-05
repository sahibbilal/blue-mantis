const path = require('path');
const glob = require('glob');
const ESLintPlugin = require('eslint-webpack-plugin');

const themeJsDirectory = 'js';
const themeDistDirectory = `dist${path.sep}`;
const blockDirectory = 'blocks';

const blockEntries = glob
	.sync(`.${path.sep}${blockDirectory}${path.sep}**${path.sep}script.js`)
	.reduce((acc, filepath) => {
		let entry = filepath
			.replace(`./${blockDirectory}`, '')
			.replace(`/script.js`, '');
		let entryParts = entry.split('/');

		if (entryParts.length > 3) {
			entryParts = [
				entryParts[0],
				entryParts[1],
				entryParts[entryParts.length - 1],
			];
			entry = entryParts.join('/');
		}
		acc[entry] = filepath;
		return acc;
	}, {});

const blockEditorEntries = glob
	.sync(`.${path.sep}${blockDirectory}${path.sep}**${path.sep}editor.js`)
	.reduce((acc, filepath) => {
		let entry = filepath
			.replace(`./${blockDirectory}`, '')
			.replace(`/editor.js`, '');
		let entryParts = entry.split('/');
		if (entryParts.length > 3) {
			entryParts = [
				entryParts[0],
				entryParts[1],
				entryParts[entryParts.length - 1],
			];
			entry = entryParts.join('/');
		}
		acc[entry + '-editor'] = filepath;
		return acc;
	}, {});

const entries = {
	bundle: path.resolve(__dirname, themeJsDirectory, 'script.js'),
	editor: path.resolve(__dirname, themeJsDirectory, 'editor.js'),
	...blockEntries,
	...blockEditorEntries,
};

const settings = {
	entry: entries,
	output: {
		path: path.resolve(__dirname, themeDistDirectory),
		filename: '[name].js',
	},
	module: {
		rules: [
			{
				test: /\.(js|jsx)$/,
				exclude: /node_modules/,
				use: ['babel-loader'],
			},
		],
	},
	externals: {
		jquery: 'jQuery',
	},
	plugins: [new ESLintPlugin({ failOnError: false })],
	mode: 'development',
	devtool: 'source-map',
};

module.exports = settings;
