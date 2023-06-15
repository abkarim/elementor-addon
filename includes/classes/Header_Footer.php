<?php

namespace Elementor_Addon;

/**
 * Prevent direct access
 */
if (!defined("ABSPATH")) {
    exit();
}

class Header_And_Footer
{
    /**
     * Constructor function
     *
     * @since 0.0.1
     */
    public function __construct()
    {
        $this->init();
    }

    /**
     * Initialize setup
     *
     * @since 0.0.1
     */
    public function init()
    {
        // Add menu
        add_action("admin_menu", [$this, "add_admin_menu"]);

        /**
         * Add header in frontend
         */
        if (
            $this->is_header_exists_and_enabled() &&
            $this->should_header_render()
        ) {
            add_action("wp_body_open", [$this, "show_header"]);
        }
    }

    /**
     * Checks if header is available and enabled
     *
     * @return bool
     * @since 0.0.1
     */
    public function is_header_exists_and_enabled()
    {
        return true;
    }

    /**
     * Should header render
     *
     * Is header is available for current post type
     *
     * @return bool
     * @since 0.0.1
     */
    public function should_header_render()
    {
        return true;
    }

    /**
     * Get Header id
     *
     * @return int
     * @since 0.0.1
     */
    public function get_header_id()
    {
        $id = 2085;

        return $id;
    }

    /**
     * Add admin menu
     *
     * Adds menu and page tp wordpress admin dashboard
     *
     * @since 0.0.1
     */
    public function add_admin_menu()
    {
        // Add Headers page
        add_submenu_page(
            "themes.php",
            "Manage headers",
            \Elementor_Addon\Plugin::PLUGIN_NAME . " headers",
            "manage_options",
            ELEMENTOR_ADDON_PLUGIN_PATH .
                "/includes/dashboard/pages/manage-headers.php",
            null
        );
    }

    /**
     * Load assets
     *
     * Load required assets
     *
     * @since 0.0.1
     */
    public function load_assets($_id)
    {
        \Elementor\Plugin::$instance->frontend->enqueue_styles();
        \Elementor\Plugin::$instance->frontend->enqueue_scripts();

        $css_file = new \Elementor\Core\Files\CSS\Post($_id);
        $css_file->enqueue();
    }

    /**
     * Show header
     *
     * @since 0.0.1
     */
    public function show_header()
    {
        $id = $this->get_header_id();

        $this->load_assets($id);

        echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display(
            $id,
            true
        );
    }
}
