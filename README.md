# Drupal Password Auth for WP

**Contributors:** Techrays Labs Private Limited  
**Plugin Name:** Drupal Password Auth for WP  
**Description:** This plugin allows WordPress to authenticate users using Drupal 9 password hashes. Please note that this is designed for Legacy hash compatibility only.  
**Author:** Techrays Labs Private Limited  
**Author URI:** [https://techrayslabs.com/](https://techrayslabs.com/)  
**Version:** 1.0  
**License:** GPLv2 or later  
**License URI:** [http://www.gnu.org/licenses/gpl-2.0.html](http://www.gnu.org/licenses/gpl-2.0.html)

## Description

This WordPress plugin enables authentication using Drupal 9 password hashes for users with legacy password hashes. It is intended for websites migrating from Drupal to WordPress or those with users who have changed their passwords within WordPress.

**Important Note:** This plugin is specifically designed for compatibility with legacy Drupal password hashes. If your Drupal installation uses a different password hashing method, this plugin may not be suitable.

## Installation

1. Upload the `drupal-password-auth-for-wp` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. No additional configuration is needed. The plugin will handle the authentication process.

## Usage

Once activated, the plugin automatically checks if a user's password hash is a legacy Drupal 9 hash. If it is, the plugin uses Drupal's hashing algorithm to authenticate the user.

## Frequently Asked Questions

**Q: Can I use this plugin if my Drupal installation uses a different hashing algorithm?**  
A: No, this plugin is specifically designed for compatibility with Drupal 9 password hashes. If your Drupal installation uses a different hashing algorithm, this plugin may not work as intended.

## Changelog

**1.0**  
- Initial release.

## Upgrade Notice

**1.0**  
Initial release.

## Screenshots

No screenshots available.

## Credits

This plugin was developed by Techrays Labs Private Limited.

## Contact

For support or inquiries, please contact us at [https://techrayslabs.com/](https://techrayslabs.com/).

## License

This plugin is released under the GPLv2 or later license. For more details, see [http://www.gnu.org/licenses/gpl-2.0.html](http://www.gnu.org/licenses/gpl-2.0.html).
