[⌂ Table of Contents](/docs/README.md) | [← Previous Article](/docs/css/breakpoints.md) | [Next Article →](/docs/css/global-styles/README.md)

# Sass Functions/Mixins
There are a number of SCSS mixins and functions. `Mixins` are used to output entire blocks of code, whereas `Functions` are used to output specific property values. Full documentation of the functions and mixins can be found in the respective scss files.

## Functions
The [/themes/propel/css/__base-includes/functions/_functions.scss](/themes/propel/css/__base-includes/functions/_functions.scss) file contains a number of helpful SCSS mixins. These most frequently used are:

* `rem()` - Converts an pixel value into a rem value. Can take multiple values. For example this SCSS:
	```
	margin-top: rem(16);
	padding: rem(16 32 48 64);
	```
	Will output this CSS:
	```
	margin-top: 1rem;
	padding: 1rem 2rem 3rem 4rem;
	```

* `responsive-values()` (can also use `rv()`) - Creates a CSS clamp value that sizes between breakpoints. For example this SCSS:
	```
	padding-top: responsive-values(16, 32);
	```
	Will output a top padding value that starts at 1rem on the smallest screen sizes, then scale up between the `md` and `xxl` breakpoints (`$grid-breakpoints`) until it gets to 2rem:
	```
	padding-top: clamp(1rem, -0.1428571429rem + 2.380952381vw, 2rem);
	```

* `font()` - Outputs a font family value from the $fonts variable. For example this SCSS:
	```
	font-family: font(base);
	```
	Will output this CSS:
	```
	font-family: 'Open Sans', sans-serif;
	```

* `paint()` - Outputs a color value from the $paints or $additional-paints variables. For example this SCSS:
	```
	color: paint(neutral-85);
	```
	Will output this CSS:
	```
	color: #dadee6;
	```

* `effect()` - Outputs an effect value from the $effects variable. For example this SCSS:
	```
	box-shadow: effect(cards);
	```
	Will output this CSS:
	```
	box-shadow: 0rem 0rem 0.5rem rgba(0, 0, 0, 0.08);
	```

## Mixins
The [/themes/propel/css/__base-includes/mixins/_mixins.scss](/themes/propel/css/__base-includes/mixins/_mixins.scss) file contains a number of helpful SCSS mixins. These most frequently used are:

* `headings` - Used to target heading selectors.
* `grid` - Used to add the CSS Grid properties for the 12-column grid.
* `icon-font` - Used to add properties to a for a pseudo element to make an icon based on the iconfont set.
* `responsive-grid` - Generates CSS to fit an element into the 12-column grid. Only works when used on an element where the parent element is the width of the entire page.
* `alt-text-selectors` - Used to target elements with a background color that has a text color different from the standard color.

Mixins are always added with the `@include` rule. For example this SCSS:
```
.custom-icon {
	&::before {
		@include icon-font( $icon-facebook );
	}
}
```
Will output this CSS (a pseudo element with a Facebook icon):
```
.custom-icon::before {
	content: "\ea2f";
	font-weight: 400;
	font-size: 1.5rem;
	font-family: "iconfont-propel";
	font-style: normal;
	font-variant: normal;
	line-height: 1;
	text-transform: none;
	-webkit-font-smoothing: antialiased;
	-moz-osx-font-smoothing: grayscale;
}
```