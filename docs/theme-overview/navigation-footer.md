[⌂ Table of Contents](/docs/README.md) | [← Previous Article](/docs/theme-overview/compiling-theme-assets.md) | [Next Article →](/docs/best-practices/README.md)

# Navigation/Footer

The current navigation and footer in the Propel theme are older versions that don't match the Propel Design System. A navigation and footer update will be included in a future release.

In the meantime, there are two options for developing the navigation and footer:

1. Use the `Advanced Custom Fields: Nav Menu` plugin (included in the composer packages) and the files found in the following directories. These do not work out-of-the-box and will still require additional dev work.
	* [/themes/propel//custom-menus/](/themes/propel/custom-menus/)
	* [/themes/propel/includes/custom-nav-menus/](/themes/propel/includes/custom-nav-menus/)
	* [/themes/propel/parts/header/](/themes/propel/parts/header/)
	* [/themes/propel/parts/footer/](/themes/propel/parts/footer/)
2. Develop a new menu system for the project. Check with the 829 team and dev guide about which option should be pursued. There's a possibility a previous project has a menu system already developed that could be adapted.