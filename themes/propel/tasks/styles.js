const gulp = require('gulp');
const config = require('../gulp.config');
const gulpSass = require('gulp-sass')(require('sass'));
const path = require('path');
const sourcemaps = require('gulp-sourcemaps');
const gulpRename = require('gulp-rename');
const gulpStylelint = require('@ronilaukkarinen/gulp-stylelint');
const cssWrap = require('gulp-css-wrap');
const gulpIgnore = require('gulp-ignore');
const clip = require('gulp-clip-empty-files');
const cleanCSS = require('gulp-clean-css');

const { promisify } = require('util');
const fs = require('fs');
const stat = promisify(fs.stat);
const changed = require('gulp-changed');

const Vinyl = require('vinyl');

const cwd = path.resolve();
const base = path.resolve('.');

gulp.task('styles', (done) => {
	gulp.src([`css/**/*.{sass,scss}`, `blocks/**/*.{sass,scss}`])
		.pipe(
			gulpStylelint({
				failAfterError: false,
				reporters: [{ formatter: 'string', console: true }],
			})
		)
		.pipe(sourcemaps.init())
		.pipe(
			gulpSass({
				outputStyle: config.isProduction ? 'compressed' : 'expanded',
				precision: 8,
				includePaths: ['node_modules'],
			}).on('error', gulpSass.logError)
		)
		.pipe(
			gulpRename(function (file) {
				file.dirname = file.dirname.replace('.', '');

				let directories = file.dirname.split(path.sep);
				if (directories.length > 2) {
					directories = [
						directories[0],
						directories[directories.length - 1],
					];

					file.dirname = directories.join(path.sep);
				}

				const parentFolder = path.basename(file.dirname);

				if (parentFolder) {
					file.dirname = file.dirname.replace(parentFolder, '');

					if ('editor' === file.basename) {
						file.basename = parentFolder + '-editor';
					} else {
						file.basename = parentFolder;
					}
				}
			})
		)
		.pipe(gulp.dest([`dist/`]))
		.pipe(
			gulpRename(function (file) {
				if (
					!file.basename.includes('editor') &&
					!file.basename.includes('admin') &&
					!file.basename.includes('iconfont')
				) {
					file.basename = file.basename + '-editor-styles';
				}
			})
		)
		.pipe(gulpIgnore.include(`**/*-editor-styles*`))
		.pipe(clip())
		.pipe(cssWrap({ selector: '.editor-styles-wrapper' }))
		.pipe(
			cleanCSS({
				format: config.isProduction ? false : 'beautify',
			})
		)
		.pipe(gulp.dest([`dist/`]))
		.on('finish', done);
});

gulp.task('styles:selective', (done) => {
	const processedFiles = [];

	gulp.src([`css/**/*.{sass,scss}`, `blocks/**/*.{sass,scss}`])
		.pipe(
			changed(`./`, {
				extension: '.css',
				transformPath: (targetPath) => {
					return targetPath;
				},
				hasChanged: async function compareLastModifiedTime(
					stream,
					sourceFile,
					targetPath
				) {
					const targetFile = path.parse(sourceFile.path);
					const parentFolder = path.basename(targetFile.dir);
					const distPath = targetPath.replace(
						/(themes[\\\/][^\\\/]*[\\\/]).*/,
						`$1dist${path.sep}`
					);
					let rootFilePath;

					if (
						sourceFile.path.includes(`${path.sep}blocks${path.sep}`)
					) {
						targetPath = sourceFile.path.replace(
							`${path.sep}blocks${path.sep}`,
							`${path.sep}dist${path.sep}`
						);
						targetPath = targetPath.replace(
							path.sep + parentFolder + path.sep,
							path.sep
						);

						if ('editor' === targetFile.name) {
							targetPath = targetPath.replace(
								targetFile.base,
								parentFolder + '-editor' + '.css'
							);
						} else {
							targetPath = targetPath.replace(
								targetFile.base,
								parentFolder + '.css'
							);
						}

						const directories = targetPath.split(path.sep);
						if (
							directories.length > 4 &&
							'dist' !== directories[directories.length - 3]
						) {
							directories.splice(directories.length - 2, 1);
							targetPath = directories.join(path.sep);
						}
					} else {
						const rootFolderMatch = sourceFile.path.match(
							/(?<=css[\\\/]__).*?(?=[\\\/])/gm
						);

						let styleFileName = 'styles';

						if (rootFolderMatch) {
							styleFileName = rootFolderMatch[0];
						}

						targetPath = distPath + styleFileName + '.css';

						rootFilePath = targetPath.replace(
							`${path.sep}dist${path.sep}`,
							`${path.sep}css${path.sep}`
						);

						rootFilePath = rootFilePath.replace('.css', '.scss');

						if (rootFolderMatch && !fs.existsSync(targetPath)) {
							rootFilePath = rootFilePath.replace(
								rootFolderMatch[0],
								'styles'
							);

							targetPath = rootFilePath
								.replace(
									`${path.sep}css${path.sep}`,
									`${path.sep}dist${path.sep}`
								)
								.replace('.scss', '.css');
						}
					}

					if (fs.existsSync(targetPath)) {
						const targetStat = await stat(targetPath);

						if (
							rootFilePath &&
							!processedFiles.includes(rootFilePath)
						) {
							if (
								sourceFile.stat &&
								Math.floor(sourceFile.stat.mtimeMs) >
									Math.ceil(targetStat.mtimeMs)
							) {
								//console.log('targetPath: ' + targetPath);
								//console.log('rootFilePath: ' + rootFilePath);
								const vinylFile = await getVinylFile(
									rootFilePath,
									targetStat.mtimeMs
								);

								stream.push(vinylFile);
								processedFiles.push(rootFilePath);
							}
						}

						if (!processedFiles.includes(sourceFile.path)) {
							if (
								sourceFile.stat &&
								Math.floor(sourceFile.stat.mtimeMs) >
									Math.ceil(targetStat.mtimeMs)
							) {
								// console.log('sourceFile.path: ' + sourceFile.path);
								stream.push(sourceFile);
								processedFiles.push(sourceFile.path);
							}
						}
					} else if (!processedFiles.includes(sourceFile.path)) {
						// console.log('sourceFile.path: ' + targetPath);
						stream.push(sourceFile);
						processedFiles.push(sourceFile.path);
					}

					if (
						sourceFile.path.includes('/button/style.scss') &&
						!processedFiles.includes(sourceFile.path)
					) {
						const matches = processedFiles.filter((processedFile) =>
							processedFile.includes('_button-styles.scss')
						);

						if (matches.length) {
							stream.push(sourceFile);
							processedFiles.push(sourceFile.path);
						}
					}
				},
			})
		)
		.pipe(
			gulpStylelint({
				failAfterError: false,
				reporters: [{ formatter: 'string', console: true }],
			})
		)
		.pipe(
			gulpSass({
				outputStyle: config.isProduction ? 'compressed' : 'expanded',
				precision: 8,
				includePaths: ['node_modules'],
			}).on('error', gulpSass.logError)
		)
		.pipe(
			gulpRename(function (file) {
				file.dirname = file.dirname.replace('.', '');

				let directories = file.dirname.split(path.sep);
				if (directories.length > 2) {
					directories = [
						directories[0],
						directories[directories.length - 1],
					];

					file.dirname = directories.join(path.sep);
				}

				const parentFolder = path.basename(file.dirname);

				if (parentFolder) {
					file.dirname = file.dirname.replace(parentFolder, '');

					if ('css' !== parentFolder) {
						if ('editor' === file.basename) {
							file.basename = parentFolder + '-editor';
						} else {
							file.basename = parentFolder;
						}
					}
				}
			})
		)
		.pipe(sourcemaps.write())
		.pipe(gulp.dest([`dist/`]))
		.pipe(
			gulpRename(function (file) {
				if (
					!file.basename.includes('editor') &&
					!file.basename.includes('admin') &&
					!file.basename.includes('iconfont')
				) {
					file.basename = file.basename + '-editor-styles';
				}
			})
		)
		.pipe(gulpIgnore.include('**/*-editor-styles*'))
		.pipe(clip())
		.pipe(cssWrap({ selector: '.editor-styles-wrapper' }))
		.pipe(
			cleanCSS({
				format: config.isProduction ? false : 'beautify',
			})
		)
		.pipe(gulp.dest([`dist/`]))
		.on('finish', done);
});

gulp.task('styles:watch', () => {
	gulp.watch(
		[`css/**/*.{sass,scss}`, `blocks/**/*.{sass,scss}`],
		gulp.series('styles:selective')
	);
});

async function getVinylFile(filePath, mtime) {
	return new Vinyl({
		cwd,
		base,
		path: path.resolve(filePath),
		contents: Buffer.from(fs.readFileSync(filePath)),
		stat: {
			mtime,
		},
	});
}
