const gulp = require('gulp');
const browserSync = require('browser-sync');

/*
 * Launch browsersync for live reload and browser testing.
 */
gulp.task('browsersync', () => {
	const localBaseMatch = process.cwd().match(/([^\\\/]*)[\\\/]app/);
	let proxyUrl;

	if (localBaseMatch) {
		proxyUrl = 'https://' + localBaseMatch[1] + '.local';
	}

	return browserSync({
		files: [
			{
				match: `**/*.*`,
			},
		],
		ignore: [
			`uploads/*`,
			`plugins/*`,
			`**/eight29-filters/src/*`,
			`**/eight29-filters/.cache/*`,
			`**/eight29-filters/node_modules/*`,
			`**/src/**/*`,
			`**/*.scss`,
			`blocks/**/*.scss`,
			`blocks/**/*.js`,
		],
		watchEvents: ['change', 'add'],
		codeSync: true,
		proxy: proxyUrl,
		snippetOptions: {
			ignorePaths: ['*/wp-admin/**'],
		},
	});
});
