const getArguments = require('./tasks/getArguments');
getArguments.parse();
const envArgs = getArguments();

module.exports = {
	paths: {
		themeName: 'propel',
		iconfont: {
			src: 'images/icons/**/*',
			scss: 'css/lib/iconfont/',
			template: 'css/templates/_iconfont.scss',
			templateVariables: 'css/templates/_iconfont-variables.scss',
			class: 'icon',
		},
		fonts: {
			src: 'fonts/**/*',
			dist: 'dist/fonts',
		},
	},
	envArgs,
	isProduction: !!envArgs.production,
};
