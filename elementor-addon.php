<?php
/**
 * Plugin Name: Elementor Addon
 * Plugin URI:  https://github.com/abkarim/elementor-addon
 * Description: Elementor addon
 * Version:     0.0.1
 * Author: Karim
 * Author URI: https://github.com/abkarim
 * Text Domain: elementor-addon
 *
 * Elementor tested up to: 3.14.0
 * Elementor Pro tested up to: x.x.x
 */

/**
 * !Prevent direct access
 */
if (!defined("ABSPATH")) {
    exit();
}

/**
 * Checks if the function already exists or not
 *
 * Doesn't break site if some other plugin or theme
 * is already using this function name
 *
 */
if (!function_exists("elementor_addon_init")) {
    function elementor_addon_init()
    {
        // Plugins Path
        define("ELEMENTOR_ADDON_PLUGIN_PATH", plugin_dir_path(__FILE__));

        // Plugins URL
        define("ELEMENTOR_ADDON_PLUGIN_URL", plugin_dir_url(__FILE__));

        // Load plugin file
        require_once __DIR__ . "/includes/plugin.php";

        // Run the plugin
        \Elementor_Addon\Plugin::instance();
    }

    add_action("plugins_loaded", "elementor_addon_init");
}
