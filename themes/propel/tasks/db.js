const gulp = require('gulp');
const wpcli = require('./wpcli');
const fs = require('fs');
const path = require('path');
const config = require('../gulp.config');

gulp.task('import', (done) => {
	const fileName = config.envArgs.file || 'export.xml';

	if (
		!fs.existsSync(path.resolve(__dirname, `../../../exports/${fileName}`))
	) {
		done();
		return;
	}

	wpcli(`import ../../exports/${fileName} --authors=create`);
	wpcli(`gf form import ../../exports/forms.json`);
	done();
});

gulp.task('export', (done) => {
	const fileName = config.envArgs.file || 'export.xml';

	wpcli(`export --dir=../../exports/ --filename_format=${fileName}`);
	wpcli(`gf form export --dir=../../exports --filename=forms.json`);
	done();
});

gulp.task('plugins', (done) => {
	wpcli(
		'plugin update --all --exclude=advanced-custom-fields-pro,gravityforms,gravityformscli'
	);
	wpcli('plugin activate', [
		'advanced-custom-fields-pro',
		'acf-navmenu',
		'acf-icon-picker',
		'eight29-filters-react',
		'gravityforms',
		'gravityformscli',
		'regenerate-thumbnails-advanced',
		'safe-svg',
		'wp-retina-2x',
		'wordpress-importer',
		'wordpress-seo',
	]);
	done();
});

gulp.task('theme', (done) => {
	wpcli('theme activate propel');
	done();
});

gulp.task('homepage', (done) => {
	wpcli('option update show_on_front "page"');
	wpcli('option update page_on_front 829');
	done();
});
