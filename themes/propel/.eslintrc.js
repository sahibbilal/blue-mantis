module.exports = {
	root: false,
	env: {
		browser: true,
		es2021: true,
		jquery: true,
	},
	extends: ['plugin:@wordpress/eslint-plugin/recommended'],
	parserOptions: {
		ecmaVersion: 'latest',
		requireConfigFile: false,
		sourceType: 'module',
		ecmaFeatures: {
			jsx: true,
		},
	},
	ignorePatterns: [
		'**/dist/**/*js',
		'**/vendor/**/*.js',
		'**/.cache/**/*.js',
		'**/node_modules/**/*.js',
		'**/eight29-filters/**/*js',
	],
};
