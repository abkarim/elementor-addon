<?php
/**
 * Plugin Name: Elementor Addon
 * Description:
 * Version:     0.0.1
 * Author:
 * Author URI:
 * Text Domain: elementor-addon
 *
 * Elementor tested up to: x.x.x
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
 * Don't break site if some other plugin or theme
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
