[⌂ Table of Contents](/docs/README.md) | [← Previous Article](/docs/composer/README.md) | [Next Article →](/docs/setup/README.md)

# Installing WordPress plugins

Find the plugin on [https://wpackagist.org/ ↗](https://wpackagist.org/). To install it run:
```
composer require wpackagist-plugin/plugin-name
```
For example, for WooCommerce:
```
composer require wpackagist-plugin/woocommerce
```

If the plugin is not available on wpackagist (e.g. it's a paid plugin), then put the files in `packages` folder - in a subfolder. Subfolder can be named anything, but for clarity it's best to give it the same name as the plugin. E.g. for Gravity Forms that would be:
```
packages
  gravityforms
    gravityforms
      ...files here...
```

Inside the plugin folder itself add `composer.json` file with the following content:
```json
{
    "name": "gravityforms/gravityforms",
    "version": "X.Y.Z",
    "type": "wordpress-plugin"
}
```
Ensure the following:
* `name` is just a subfolder/plugin folder inside `package`.
* `type` should **always** be `wordpress-plugin`.
* `version` should reflect the version of the plugin (so it would be something like `4.1.3` instead of `X.Y.Z`).

Above is the example for Gravity Forms.

Then you require it like any other Composer plugin.
```text
composer require gravityforms/gravityforms:^X.Y.Z
```

For example, if you install Gravity Forms 4.1.3, you'd do:
```text
composer require gravityforms/gravityforms:^4.1.3
```

<details>
<summary>What does "^" in version mean?</summary>

`^4.1.3` tells Composer to install at least version `4.1.3`, but any higher is accepted too (so we can upgrade the plugin!), but it must be lower than `5.0.0`. Plugins with different major version (first number) might not be compatible with each other, so upgrading from `4.X.X` to `5.0.0` might break things. Read more about versions on [Composer website ↗](https://getcomposer.org/doc/articles/versions.md).
</details>


If you need to upload new version of the plugin you have to additionally change the version in the _plugins_ `composer.json` to the new one before running:
```text
composer update
```

<details>
<summary>Why?</summary>

When determining if the plugin needs updating Composer looks at the plugins `composer.json` file. If the version is the same as currently installed Composer will not re-install the plugin. So if you update plugins files, but not the version in `composer.json` Composer will think that nothing has changed.
</details>

## Creating custom plugins

Custom developed plugins can be added directly to the `plugins` directory. Just be sure to add a rule to track the plugin's folder in the .gitignore file.