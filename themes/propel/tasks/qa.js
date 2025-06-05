/* eslint no-console: 0 */

const gulp = require('gulp');
const Figma = require('figma-api');
const prompt = require('gulp-prompt');
const chalk = require('chalk');
const { JSONPath } = require('jsonpath-plus');
const fs = require('fs');
const path = require('path');
const WP = require('wp-cli');
const download = require('image-downloader');
const backstop = require('backstopjs');
const replace = require('gulp-replace');
const glob = require('glob');
const getArguments = require('./getArguments');
getArguments.parse();
const envArgs = getArguments();

let settings;
let siteUrl;
let backstopConfig;
let blockNames;

gulp.task('qa:loadFigmaSettings', (done) => {
	settings = JSON.parse(
		fs.readFileSync(
			path.resolve(
				`css${path.sep}__base-includes${path.sep}figma${path.sep}figma-settings.json`
			)
		)
	);

	done();
});

gulp.task('qa:loadBlockNames', (done) => {
	WP.discover({}, function (wp) {
		wp.option.get('siteUrl', function (error, url) {
			if (error) {
				console.log(error);
				done();
			}

			if (url) {
				siteUrl = url;

				if (envArgs.block || envArgs.blocks) {
					let singleBlocks = envArgs.blocks;

					if (!singleBlocks) {
						singleBlocks = envArgs.block;
					}

					blockNames = singleBlocks.split(',');
					done();
				} else {
					wp.post.list(
						{ post_type: 'library_block', fields: 'post_title' },
						function (err, posts) {
							if (!err) {
								if (posts && posts.length > 0) {
									blockNames = posts.map((post) => {
										return post.post_title;
									});

									done();
								}
							} else {
								console.log(err);
								console.log(
									chalk.red(
										`Error. Is the Local site running?`
									)
								);
								done();
								process.exit();
							}
						}
					);
				}
			}
		});
	});
});

gulp.task('qa:loadBackstopConfig', (done) => {
	backstopConfig = JSON.parse(
		fs.readFileSync(path.resolve(`qa${path.sep}backstop.json`))
	);

	const figmaDirPath = path.resolve(`qa${path.sep}images${path.sep}figma`);

	if (backstopConfig && blockNames.length > 0 && siteUrl) {
		blockNames.forEach((blockName) => {
			let scenario = {};

			if (
				fs.existsSync(
					`${figmaDirPath}${path.sep}${blockName}-Desktop.png`
				)
			) {
				scenario = {
					label: blockName,
					url: siteUrl + `/block-library/?qa=${blockName}`,
				};

				backstopConfig.scenarios.push({
					...backstopConfig.scenarioDefaults,
					...scenario,
				});
			} else {
				const files = glob.sync(
					`${figmaDirPath}${path.sep}${blockName}-*-Desktop.png`
				);

				if (files.length) {
					const filesArray = [];

					files.forEach((file) => {
						filesArray.push({
							file,
							time: fs.statSync(file).mtimeMs,
						});
					});

					const timeSortedFiles = filesArray
						.sort((a, b) => a.time - b.time)
						.map((fileObject) => fileObject.file);

					timeSortedFiles.forEach((file, blockIndex) => {
						const blockVariationName = path
							.basename(file)
							.replace('-Desktop.png', '');

						scenario = {
							label: blockVariationName,
							url:
								siteUrl +
								`/block-library/?qa=${blockName}&index=${
									blockIndex + 1
								}`,
						};

						backstopConfig.scenarios.push({
							...backstopConfig.scenarioDefaults,
							...scenario,
						});
					});
				} else {
					console.log(
						chalk.red(
							`Error: No Figma images found for: ${blockName}`
						)
					);
				}
			}
		});
	}

	done();
});

gulp.task('qa:backstop', (done) => {
	backstop('test', {
		config: backstopConfig,
	})
		.then(() => {
			// test successful
			done();
		})
		.catch(() => {
			// test failed
			done();
		});
});

gulp.task('qa:renameLatestTest', (done) => {
	gulp.src([`qa/reports/html/config.js`, `qa/reports/json/jsonReport.json`])
		.pipe(
			replace(
				/\/images\/wordpress\/\d*-\d*\//gm,
				'/images/wordpress/latest-test/'
			)
		)
		.pipe(
			gulp.dest(function (file) {
				return file.base;
			})
		)
		.on('finish', done);
});

gulp.task('qa:copyLatestTest', (done) => {
	const directories = fs.readdirSync(
		path.resolve(`qa${path.sep}images${path.sep}wordpress${path.sep}`)
	);

	let directoryToCopy = 'temp-directory';

	if (directories.length > 0) {
		directories.reverse();

		directories.forEach((directory) => {
			if (
				'temp-directory' === directoryToCopy &&
				'latest-test' !== directory
			) {
				directoryToCopy = directory;
			}
		});
	}

	gulp.src([`qa/images/wordpress/${directoryToCopy}/*`])
		.pipe(
			gulp.dest(
				path.resolve(
					`qa${path.sep}images${path.sep}wordpress${path.sep}latest-test`
				)
			)
		)
		.on('finish', done);
});

gulp.task('qa:downloadImages', async (done) => {
	const promptSettings = [
		{
			type: 'confirm',
			name: 'importImages',
			message: chalk.blue(
				'Do you want to download the latest block images from Figma?'
			),
			default: false,
		},
		{
			type: 'input',
			name: 'apiToken',
			message: chalk.blue('Figma API token (found in 1password):'),
			validate(input) {
				if ('' === input) {
					return chalk.red('API token required.');
				}

				return true;
			},
			when(responses) {
				if (true === responses.importImages) {
					return true;
				}
			},
		},
	];

	if (!settings.figmaFileID) {
		promptSettings.push({
			type: 'input',
			name: 'figmaFileID',
			message: chalk.blue(
				'Figma File ID (found in the Figma URL for the project: https://www.figma.com/file/THIS_IS_THE_FILE_ID/...):'
			),
			validate(input) {
				if ('' === input) {
					return chalk.red('Figma File ID required.');
				}

				return true;
			},
			when(responses) {
				if (true === responses.importImages) {
					return true;
				}
			},
		});
	}

	await new Promise((resolve) => {
		gulp.src('./package.json')
			.pipe(
				prompt.prompt(promptSettings, function (response) {
					if (!response.apiToken) {
						resolve();
						done();
						return;
					}

					const api = new Figma.Api({
						personalAccessToken: response.apiToken,
					});

					let figmaFileID;

					if (settings.figmaFileID) {
						figmaFileID = settings.figmaFileID;
					} else {
						figmaFileID = response.figmaFileID;
					}

					api.getFile(figmaFileID).then(
						(file) => {
							const blockNodes = JSONPath({
								path: '$..document..children[?(@.type==="FRAME" && @.name.match(/.*-Blocks/gm))]',
								json: file,
							});

							if (
								blockNodes &&
								blockNodes.length > 0 &&
								blockNames &&
								blockNames.length > 0
							) {
								const allFigmaBlocks = {};
								const blocks = [];
								const figmaBlockNames = {};

								blockNodes.forEach((blockNode) => {
									if (
										blockNode.children &&
										blockNode.children.length > 0
									) {
										blockNode.children.forEach((block) => {
											if (
												block.name &&
												block.id &&
												!block.name.includes('Label-')
											) {
												allFigmaBlocks[block.name] =
													block;
											}
										});
									}
								});

								blockNames.forEach((blockName) => {
									let desktopBlockFound = false;
									let mobileBlockFound = false;

									if (
										allFigmaBlocks[blockName + '-Desktop']
									) {
										desktopBlockFound = true;
										figmaBlockNames[
											blockName + '-Desktop'
										] = [];

										blocks.push(
											allFigmaBlocks[
												blockName + '-Desktop'
											]
										);
									}

									if (allFigmaBlocks[blockName + '-Mobile']) {
										mobileBlockFound = true;
										figmaBlockNames[blockName + '-Mobile'] =
											[];

										blocks.push(
											allFigmaBlocks[
												blockName + '-Mobile'
											]
										);
									}

									for (const figmaBlockName in allFigmaBlocks) {
										if (
											figmaBlockName.match(
												new RegExp(
													`${blockName}-.*-Desktop`
												)
											)
										) {
											desktopBlockFound = true;

											if (
												!figmaBlockNames[
													blockName + '-Desktop'
												]
											) {
												figmaBlockNames[
													blockName + '-Desktop'
												] = [];
											}

											figmaBlockNames[
												blockName + '-Desktop'
											].push(figmaBlockName);

											blocks.push(
												allFigmaBlocks[figmaBlockName]
											);
										}

										if (
											figmaBlockName.match(
												new RegExp(
													`${blockName}-.*-Mobile`
												)
											)
										) {
											mobileBlockFound = true;

											if (
												!figmaBlockNames[
													blockName + '-Mobile'
												]
											) {
												figmaBlockNames[
													blockName + '-Mobile'
												] = [];
											}

											figmaBlockNames[
												blockName + '-Mobile'
											].push(figmaBlockName);

											blocks.push(
												allFigmaBlocks[figmaBlockName]
											);
										}
									}

									if (false === desktopBlockFound) {
										console.log(
											chalk.red(
												`Error: block not found in Figma: ${blockName}-Desktop`
											)
										);
									}

									if (false === mobileBlockFound) {
										console.log(
											chalk.red(
												`Error: block not found in Figma: ${blockName}-Mobile`
											)
										);
									}
								});

								if (blocks.length > 0) {
									fs.writeFile(
										`${path.resolve(`qa`)}${
											path.sep
										}figma-block-names.json`,
										JSON.stringify(
											figmaBlockNames,
											null,
											4
										),
										function (blockNamesError) {
											if (blockNamesError) {
												console.log(
													chalk.red(
														`Error creating figma-block-names.json`
													)
												);
											} else {
												console.log(
													`Created figma-block-names.json`
												);
											}
										}
									);

									getBlockImages(
										blocks,
										api,
										figmaFileID
									).then(() => {
										resolve();
										done();
									});
								}
							}
						},
						(error) => {
							if (
								error.response &&
								error.response.data &&
								error.response.data.status &&
								error.response.data.err
							) {
								console.log(
									chalk.red(
										`Error retrieving Figma file. Error code ${error.response.data.status}: ${error.response.data.err}`
									)
								);
							} else {
								console.log(
									chalk.red(`Error retrieving Figma file.`)
								);
							}

							done();
							process.exit();
						}
					);
				})
			)
			.on('finish', done);
	});
});

const downloadImage = (
	block,
	file,
	imageDirectory,
	currentTimeMs,
	blockIndex
) => {
	return new Promise((resolve) => {
		if (file.images[block.id]) {
			const options = {
				url: file.images[block.id],
				dest: `${imageDirectory}${path.sep}${block.name}.png`,
			};

			download
				.image(options)
				.then(({ filename }) => {
					const currentTime = new Date(currentTimeMs + blockIndex);

					fs.utimesSync(filename, currentTime, currentTime);
					console.log('Saved to', filename);
					resolve();
				})
				.catch((err) => {
					console.error(err);
					resolve();
				});
		} else {
			console.log(
				chalk.red(`Error retrieving Figma image for: ${block.name}`)
			);
			resolve();
		}
	});
};

const getBlockImages = async (blocks, api, figmaFileID) => {
	return new Promise((resolve) => {
		const blockIds = blocks.map((block) => {
			return block.id;
		});

		const currentTimeMs = new Date().getMilliseconds();

		const imageDirectory = path.resolve(
			`qa${path.sep}images${path.sep}figma${path.sep}`
		);

		fs.mkdirSync(imageDirectory, { recursive: true });

		api.getImage(figmaFileID, { ids: [blockIds] }).then(
			(file) => {
				if (file.images) {
					Promise.all(
						blocks.map((block, blockIndex) =>
							downloadImage(
								block,
								file,
								imageDirectory,
								currentTimeMs,
								blockIndex
							)
						)
					).then(() => {
						resolve();
					});
				}
			},
			(error) => {
				if (
					error.response &&
					error.response.data &&
					error.response.data.status &&
					error.response.data.err
				) {
					console.log(
						chalk.red(
							`Error retrieving Figma image. Error code ${error.response.data.status}: ${error.response.data.err}`
						)
					);
				} else {
					console.log(chalk.red(`Error retrieving Figma image.`));
				}
			}
		);
	});
};

gulp.task(
	'qa',
	gulp.series(
		'qa:loadFigmaSettings',
		'qa:loadBlockNames',
		'qa:downloadImages',
		'qa:loadBackstopConfig',
		'qa:backstop',
		'qa:copyLatestTest',
		'qa:renameLatestTest'
	)
);

gulp.task(
	'qa:load',
	gulp.series(
		'qa:loadFigmaSettings',
		'qa:loadBlockNames',
		'qa:downloadImages'
	)
);

gulp.task(
	'qa:test',
	gulp.series(
		'qa:loadBlockNames',
		'qa:loadBackstopConfig',
		'qa:backstop',
		'qa:copyLatestTest',
		'qa:renameLatestTest'
	)
);
