<?php
/*
* Plugin Name: CreaHive Custom Visual Composer Elements
* Plugin URI: https://www.creahive.com
* Description: A plugin to add custom elements to the visual composer plugin.
* Version: 1.0
* Author: btdogan
* Author URI: https://btdogan.com
*/

// Don't load directly
if (!defined('ABSPATH')) die('-1');

// Check if Visual Composer Plugin is installed and active
function chvce_plugin_active() {
	if (!is_plugin_active('js_composer/js_composer.php')) {
		wp_die('Please activate Visual Composer, and try again');
	}
}
register_activation_hook(__FILE__, 'chvce_plugin_active');

require_once plugin_dir_path(__FILE__) . 'vce-librarian.php';