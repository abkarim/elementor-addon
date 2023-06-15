<?php

namespace Elementor_Addon;

/**
 * Prevent direct access
 */
if (!defined("ABSPATH")) {
    exit();
}

final class Plugin
{
    private static $_instance = null;

    /**
     * Addon Version
     *
     * @since 0.0.1
     * @var string The addon version.
     */
    const PLUGIN_VERSION = false;

    /**
     * Plugin Name
     *
     * @since 0.0.1
     * @var string Plugin Name
     */
    const PLUGIN_NAME = "Elementor Addon";

    /**
     * Plugin Text Domain
     *
     * @since 0.0.1
     * @var string Text Domain Name
     */
    const PLUGIN_TEXT_DOMAIN = "elementor-addon";

    /**
     * Plugin widgets category name
     *
     * @since 0.0.1
     * @var string widgets category name
     */
    const PLUGIN_CATEGORY = "elementor-addon-category";

    /**
     * Minimum Elementor Version
     *
     * @since 0.0.1
     * @var string Minimum Elementor version required to run this addon
     */
    const MINIMUM_ELEMENTOR_VERSION_REQUIRED = "3.2.0";

    /**
     * Minimum PHP Version
     *
     * @since 0.0.1
     * @var string Minimum PHP Version required to run this addon
     */
    const MINIMUM_PHP_VERSION_REQUIRED = "7.0";

    /**
     * Instance
     *
     * Ensures only one instance of the class is loaded or can be loaded.
     *
     * @since 0.0.1
     * @access public
     * @static
     * @return \Elementor_Addon\Plugin An instance of the class.
     */
    public static function instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Constructor
     *
     * Perform some compatibility checks to make sure basic requirements are meet.
     * If all compatibility checks pass, initialize the functionality.
     *
     * @since 0.0.1
     * @access public
     */
    public function __construct()
    {
        if ($this->is_compatible()) {
            // Init plugin
            $this->init();

            // After elementor load this hook will be fired
            add_action("elementor/init", [$this, "elementor_init"]);
        }
    }

    /**
     * Compatibility Checks
     *
     * Checks whether the site meets the addon requirement.
     *
     * @since 0.0.1
     * @access public
     */
    public function is_compatible()
    {
        // Check if elementor is installed and activated
        if (!did_action("elementor/loaded")) {
            // Show notification
            add_action("admin_notices", [
                $this,
                "admin_notice_missing_main_plugin",
            ]);
            return false;
        }

        // Check for required version
        if (
            !version_compare(
                ELEMENTOR_VERSION,
                self::MINIMUM_ELEMENTOR_VERSION_REQUIRED,
                ">="
            )
        ) {
            // Show notification
            add_action("admin_notices", [
                $this,
                "admin_notice_minimum_elementor_version",
            ]);
            return false;
        }

        // Check for required PHP version
        if (
            version_compare(
                PHP_VERSION,
                self::MINIMUM_PHP_VERSION_REQUIRED,
                "<"
            )
        ) {
            add_action("admin_notices", [
                $this,
                "admin_notice_minimum_php_version",
            ]);
            return false;
        }

        //* All Ok
        return true;
    }

    /**
     * Admin notice
     *
     * Warning when the site doesn't have Elementor installed or activated.
     *
     * @since 0.0.1
     * @access public
     */
    public function admin_notice_missing_main_plugin()
    {
        if (isset($_GET["activate"])) {
            unset($_GET["activate"]);
        }

        $message = sprintf(
            /* translators: 1: Plugin name 2: Elementor */
            esc_html__(
                '"%1$s" requires "%2$s" to be installed and activated.',
                self::PLUGIN_NAME
            ),
            "<strong>" .
                esc_html__(self::PLUGIN_NAME, self::PLUGIN_TEXT_DOMAIN) .
                "</strong>",
            "<strong>" .
                esc_html__("Elementor", self::PLUGIN_TEXT_DOMAIN) .
                "</strong>"
        );

        printf(
            '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>',
            $message
        );
    }

    /**
     * Admin notice
     *
     * Warning when the site doesn't have a minimum required Elementor version.
     *
     * @since 0.0.1
     * @access public
     */
    public function admin_notice_minimum_elementor_version()
    {
        if (isset($_GET["activate"])) {
            unset($_GET["activate"]);
        }

        $message = sprintf(
            /* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
            esc_html__(
                '"%1$s" requires "%2$s" version %3$s or greater.',
                self::PLUGIN_NAME
            ),
            "<strong>" .
                esc_html__(self::PLUGIN_NAME, self::PLUGIN_TEXT_DOMAIN) .
                "</strong>",
            "<strong>" .
                esc_html__("Elementor", self::PLUGIN_TEXT_DOMAIN) .
                "</strong>",
            self::MINIMUM_ELEMENTOR_VERSION_REQUIRED
        );

        printf(
            '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>',
            $message
        );
    }

    /**
     * Admin notice
     *
     * Warning when the site doesn't have a minimum required PHP version.
     *
     * @since 0.0.1
     * @access public
     */
    public function admin_notice_minimum_php_version()
    {
        if (isset($_GET["activate"])) {
            unset($_GET["activate"]);
        }

        $message = sprintf(
            /* translators: 1: Plugin name 2: PHP 3: Required PHP version */
            esc_html__(
                '"%1$s" requires "%2$s" version %3$s or greater.',
                self::PLUGIN_NAME
            ),
            "<strong>" .
                esc_html__(self::PLUGIN_NAME, self::PLUGIN_TEXT_DOMAIN) .
                "</strong>",
            "<strong>" .
                esc_html__("PHP", self::PLUGIN_TEXT_DOMAIN) .
                "</strong>",
            self::MINIMUM_PHP_VERSION_REQUIRED
        );

        printf(
            '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>',
            $message
        );
    }

    /**
     * Initializes features
     *
     * Load the addons functionality only after Elementor is initialized.
     *
     * Fired by `elementor/init` action hook.
     *
     * @since 0.0.1
     * @access public
     */
    public function elementor_init()
    {
        // Load Styles
        add_action("elementor/frontend/after_enqueue_styles", [
            $this,
            "load_styles",
        ]);

        // Load Scripts
        add_action("elementor/frontend/after_register_scripts", [
            $this,
            "load_scripts",
        ]);

        // Add category
        add_action("elementor/elements/categories_registered", [
            $this,
            "add_widgets_category",
        ]);

        // Register widgets
        add_action("elementor/widgets/register", [$this, "register_widgets"]);
        // Unregister Widgets
        add_action("elementor/widgets/register", [$this, "unregister_widgets"]);

        // Register controls
        add_action("elementor/controls/register", [$this, "register_controls"]);
        // Unregister controls
        add_action("elementor/controls/register", [
            $this,
            "unregister_controls",
        ]);
    }

    /**
     * Init plugin
     *
     * @since 0.0.1
     */
    private function init()
    {
        // Load styles
        add_action("admin_enqueue_scripts", [$this, "load_admin_styles"], 100);

        // Load styles
        add_action("admin_enqueue_scripts", [$this, "load_admin_scripts"]);

        // Load class
        require_once ELEMENTOR_ADDON_PLUGIN_PATH .
            "/includes/classes/Header_Footer.php";
        new \Elementor_Addon\Header_And_Footer();
    }

    /**
     * Add frontend style
     *
     * @since 0.0.1
     * @access public
     */
    public function load_styles()
    {
        /**
         * Common styles
         */
        wp_register_style(
            self::PLUGIN_TEXT_DOMAIN . "-common",
            ELEMENTOR_ADDON_PLUGIN_URL . "/assets/css/common.css",
            [],
            self::PLUGIN_VERSION
        );
        wp_enqueue_style(self::PLUGIN_TEXT_DOMAIN . "-common");

        /**
         * Frontend styles
         */
        wp_register_style(
            self::PLUGIN_TEXT_DOMAIN . "-frontend",
            ELEMENTOR_ADDON_PLUGIN_URL . "/assets/css/frontend.css",
            [self::PLUGIN_TEXT_DOMAIN . "-common"],
            self::PLUGIN_VERSION
        );
        wp_enqueue_style(self::PLUGIN_TEXT_DOMAIN . "-frontend-style");
    }

    /**
     * Load admin styles
     *
     * @since 0.0.1
     */
    public function load_admin_styles()
    {
        /**
         * Common styles
         */
        wp_register_style(
            self::PLUGIN_TEXT_DOMAIN . "-common",
            ELEMENTOR_ADDON_PLUGIN_URL . "/assets/css/common.css",
            [],
            self::PLUGIN_VERSION
        );
        wp_enqueue_style(self::PLUGIN_TEXT_DOMAIN . "-common");
    }

    /**
     * Add frontend scripts
     *
     * @since 0.0.1
     * @access public
     */
    public function load_scripts()
    {
        /**
         * Frontend scripts
         */
        wp_register_script(
            self::PLUGIN_TEXT_DOMAIN . "-frontend-script",
            ELEMENTOR_ADDON_PLUGIN_URL . "/assets/js/frontend-script.js",
            [],
            self::PLUGIN_VERSION,
            false
        );
        wp_enqueue_script(self::PLUGIN_TEXT_DOMAIN . "-frontend-script");

        /**
         * Count Down widgets JavaScript
         */
        wp_register_script(
            self::PLUGIN_TEXT_DOMAIN . "-count-down-script",
            ELEMENTOR_ADDON_PLUGIN_URL . "/assets/js/count-down.js",
            [self::PLUGIN_TEXT_DOMAIN . "-frontend-script"],
            self::PLUGIN_VERSION,
            true
        );
    }

    /**
     * Add admin scripts
     *
     * @since 0.0.1
     * @access public
     */
    public function load_admin_scripts()
    {
    }

    /**
     * Register Widgets
     *
     * Load widgets files and register new Elementor widgets.
     *
     * Fired by `elementor/widgets/register` action hook.
     *
     * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager.
     */
    public function register_widgets($widgets_manager)
    {
        require_once ELEMENTOR_ADDON_PLUGIN_PATH .
            "/includes/widgets/CountDown.php";

        $widgets_manager->register(new \CountDown());
    }

    /**
     * !UnRegister Widgets
     *
     * Fired by `elementor/widgets/unregister` action hook.
     *
     * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager.
     * @since 0.0.1
     */
    public function unregister_widgets($widgets_manager)
    {
        // $widgets_manager->unregister("");
    }

    /**
     * Register Controls
     *
     * Load controls files and register new Elementor controls.
     *
     * Fired by `elementor/controls/register` action hook.
     *
     * @param \Elementor\Controls_Manager $controls_manager Elementor controls manager.
     * @since 0.0.1
     */
    public function register_controls($controls_manager)
    {
        // require_once __DIR__ . "/includes/controls/control-1.php";

        // $controls_manager->register(new \Control_2());
    }

    /**
     * Unregister Controls
     *
     * Fired by `elementor/controls/register` action hook.
     *
     * @param \Elementor\Controls_Manager $controls_manager Elementor controls manager.
     * @since 0.0.1
     */
    public function unregister_controls($controls_manager)
    {
        // $controls_manager->unregister("");
    }

    /**
     * Add widgets category
     *
     * Add category to widgets section
     *
     * @since 0.0.1
     */
    public function add_widgets_category($elements_manager)
    {
        $elements_manager->add_category(self::PLUGIN_CATEGORY, [
            "title" => \esc_html__(self::PLUGIN_NAME, self::PLUGIN_TEXT_DOMAIN),
            "icon" => "fa fa-plug",
        ]);
    }
}
