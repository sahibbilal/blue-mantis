[⌂ Table of Contents](/docs/README.md) | [← Previous Article](/docs/gulp/block-tasks.md) | [Next Article →](/docs/composer/README.md)

# Additional Gulp Tasks

* `gulp figma`
	* Automatically pulls font and color styles from Figma. Optionally runs on setup, but can be run any time. Will prompt for two required values:
		* Figma API token (found in 1password)
		* Figma File ID (found in the Figma URL for the project: https://www.figma.com/file/THIS_IS_THE_FILE_ID/...)
	* This generates scss files in the [/themes/propel/css/__base-includes/figma/](/themes/propel/css/__base-includes/figma/) directory. Do not edit these files directly. The one exception is the [figma-settings.json](/themes/propel/css/__base-includes/figma/figma-settings.json) file which can be used to store the Figma File ID and update the font top margins. [Read more here](/docs/css/figma-variables.md).

* `gulp build --production`
	* Builds the project with production settings - minifies all the assets. You can also use `--production` flag with other tasks to make a production build.

* `gulp styles`
	* Scans the [/themes/propel/css/](/themes/propel/css/) and [/themes/propel/blocks/](/themes/propel/blocks/) directories for SCSS files and outputs the compiled `.css` files to the `/themes/propel/dist/` directory. Will also output any linting errors found in the files.

* `gulp styles:watch`
	* Watches and compiles SCSS file changes in real-time.

* `gulp scripts`
	* Scans the [/themes/propel/js/](/themes/propel/js/) and [/themes/propel/blocks/](/themes/propel/blocks/) directories for JS files and outputs the compiled JS files to the `/themes/propel/dist/` directory. Will also output any linting errors found in the files.

* `gulp scripts:watch`
	* Watches and compiles JS file changes in real-time.

* `gulp iconfont`
	* Scans the [/themes/propel/images/icons/](/themes/propel/images/icons/) directory and creates an iconfont set and associated SCSS variables.

* `gulp plugins`
	* Activates the default plugins and updates all plugins via the wp-cli. Note: this only updates plugins in the WordPress instance. `composer update` is how to update the starting packages.

* `gulp theme`
	* Activates the Propel theme via the wp-cli.

* `gulp browsersync`
	* Launches [Browsersync ↗](https://browsersync.io/).

* `gulp import`
	* Imports `export.xml` file in `exports` folder (see [wp import ↗](https://developer.wordpress.org/cli/commands/import/)). Can add `--file=filename.xml` to import a custom file. This does not replace any existing posts. Also imports forms for Gravity Forms from the `forms.json` file.

* `gulp export`
	* Creates `export.xml` file in `exports` folder containing the export of the site's authors, terms, posts, comments, and attachments (see [wp export ↗](https://developer.wordpress.org/cli/commands/export/)). Can add `--file=filename.xml` to customize the file name. Also exports all Gravity Forms to the `forms.json` file.

* `gulp docs`
	* Scans all the `.md` files in the `/docs/` directory runs link, spelling, and grammar tests. Each of these can also be run separately by adding a flag to the command:
	* `--links` - check for bad links.
	* `--spelling` - check for incorrectly spelled words. Words can be added to the allowed word list in the [/themes/propel/tasks/docs.js](/themes/propel/tasks/docs.js) file.
	* `--grammar` - check for bad grammar.

* `gulp docs:header`
	* Scans all the `.md` files in the `/docs/` directory and adds a header with links to home, previous article, and next article: