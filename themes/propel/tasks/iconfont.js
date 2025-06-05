const gulp = require('gulp');
const config = require('../gulp.config');

const iconfont = require('gulp-iconfont');
const runTimestamp = Math.round(Date.now() / 1000);
const async = require('async');
const consolidate = require('gulp-consolidate');

const srcThemeDir = '/';

gulp.task('iconfont', function (done) {
	const iconStream = gulp.src([config.paths.iconfont.src]).pipe(
		iconfont({
			fontName: 'iconfont-' + config.paths.themeName,
			normalize: true,
			fontHeight: 1001,
			//prependUnicode: true, // recommended option
			formats: ['ttf', 'eot', 'woff', 'woff2', 'svg'], // default, 'woff2' and 'svg' are available
			timestamp: runTimestamp, // recommended to get consistent builds when watching files
		})
	);

	async.parallel(
		[
			function handleGlyphs(cb) {
				iconStream.on('glyphs', function (glyphs, options) {
					async.parallel(
						[
							function iconfontTemplate(cb) {
								gulp.src(
									config.paths.iconfont.template
								)
									.pipe(
										consolidate('lodash', {
											glyphs,
											fontCacheBuster: Math.random()
												.toString(36)
												.substring(7),
											fontName:
												'iconfont-' +
												config.paths.themeName,
											themePath:
												'/',
											fontPath:
												config.paths.fonts.dist +
												'/iconfont-' +
												config.paths.themeName,
											className:
												config.paths.iconfont.class,
										})
									)
									.pipe(
										gulp.dest(
											config.paths.iconfont.scss
										)
									)
									.on('finish', cb);
							},
							function iconfontVariables(cb) {
								gulp.src(
									config.paths.iconfont.templateVariables
								)
									.pipe(
										consolidate('lodash', {
											glyphs,
											fontCacheBuster: Math.random()
												.toString(36)
												.substring(7),
											fontName:
												'iconfont-' +
												config.paths.themeName,
											themePath:
												'themes' + config.paths.themeName + '/',
											fontPath:
												config.paths.fonts.dist +
												'/iconfont-' +
												config.paths.themeName,
											className:
												config.paths.iconfont.class,
										})
									)
									.pipe(
										gulp.dest(
											config.paths.iconfont.scss
										)
									)
									.on('finish', cb);
							},
						],
						done
					);
				});
			},
			function handleFonts(cb) {
				iconStream
					.pipe(
						gulp.dest(
							config.paths.fonts.dist +
							'/iconfont-' +
							config.paths.themeName
						)
					)
					.on('finish', cb);
			},
		],
		done
	);
});
