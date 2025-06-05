[⌂ Table of Contents](/docs/README.md) | [← Previous Article](/docs/css/global-styles/buttons.md) | [Next Article →](/docs/css/custom-properties.md)

# Global Styles: Iconfont
All SVG icons added to the [/themes/propel/images/icons/](/themes/propel/images/icons/) directory automatically get compiled into an iconfont set by the [gulp iconfont](/docs/gulp/additional-tasks.md) task.

This also automatically creates an SCSS file ([/themes/propel/css/lib/iconfont/_iconfont-variables.scss](/themes/propel/css/lib/iconfont/_iconfont-variables.scss)) with iconfont variables that can be used with the the [icon-font](/docs/css/functions-mixins.md) mixin.

A project with custom icons should have the SVGs added at the beginning of the project. Note: make sure SVG markup doesn't contain any strokes, clipping paths, masks, or oddeven color rules. A single path is ideal. Contact the 829 design team if the SVGs provided in Figma contain incorrect markup.