[⌂ Table of Contents](/docs/README.md) | [← Previous Article](/docs/js/README.md) | [Next Article →](/docs/js/performance.md)

# JavaScript Controllers
Most ACF blocks that have JavaScript as well as the global JavaScript files all use a controller - a file that imports functions and runs them on set event listeners (some are throttled). This is generally a good pattern to follow, but isn't required - especially with very simple scripts.

The controller file contains code similar to this:

```
const controller = {
	init() {},
	loaded() {},
	resized() {},
	scrolled() {},
	keyDown() {},
	mouseUp() {},
};
export default controller;
```

Modules can be imported and run within each of these actions.