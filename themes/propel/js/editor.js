import editorSettings from './__editor/editorSettings';
import acfBlocks from './__editor/acfBlocks';
import colors from './__editor/colors';
import highlightText from './__editor/highlightText';
import goldText from './__editor/goldText';
import removeFormats from './__editor/removeFormats';
import unregisterGutenbergEmbeds from './__editor/unregisterGutenbergEmbeds';

wp.domReady(function () {
	editorSettings();
	acfBlocks();
	colors();
	highlightText();
	goldText();
	removeFormats();
	unregisterGutenbergEmbeds();
});
