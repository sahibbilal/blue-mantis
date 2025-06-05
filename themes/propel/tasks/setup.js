const runProcess = require('./runProcess');
const getArguments = require('./getArguments');
getArguments.parse();
const envArgs = getArguments();

runProcess('composer install');
runProcess('npm install');
runProcess('gulp plugins');
runProcess('gulp theme');
runProcess('gulp import');
runProcess('gulp homepage');

if (!envArgs.buddy || true !== envArgs.buddy) {
	runProcess('gulp figma:setup');
}

runProcess('gulp build');
