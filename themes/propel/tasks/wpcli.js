const path = require('path');
const runProcess = require('./runProcess');

module.exports = (command, commandArgs = []) => {
	runProcess('wp' + ' ' + [command, ...commandArgs].join(' '));
};
