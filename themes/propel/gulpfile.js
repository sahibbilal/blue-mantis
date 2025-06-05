const gulp = require('gulp');

require('./tasks/iconfont');
require('./tasks/styles');
require('./tasks/scripts');
require('./tasks/browsersync');
require('./tasks/acf-blocks');
require('./tasks/db');
require('./tasks/figma');
require('./tasks/docs');
require('./tasks/qa');

gulp.task(
	'default',
	gulp.series(
		// TODO: 'clean',
		'iconfont',
		gulp.parallel('styles', 'scripts')
	)
);

gulp.task('build', gulp.series('default'));

gulp.task(
	'watch',
	gulp.parallel('styles:watch', 'scripts:watch', 'browsersync')
);
