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
    const CUSTOM_POST_TYPE =
        \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN . "-post";

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
        add_action("init", [$this, "create_custom_post_type"]);

        // Add template for custom post type
        add_filter(
            "template_include",
            [$this, "add_custom_post_template_support"],
            99
        );

        /**
         * Add header in frontend
         */
        if ($this->is_header_exists_and_enabled()) {
            add_action("wp_body_open", [$this, "show_header"]);
        }
    }

    /**
     *
     */
    public function create_custom_post_type()
    {
        $labels = [
            "name" => "headers", // Plural name for the post type
            "singular_name" => "header", // Singular name for the post type
        ];

        $args = [
            "labels" => $labels,
            "public" => true,
            "has_archive" => false,
            "exclude_from_search" => true,
            "show_ui" => true,
            "show_in_menu" => \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN,
            "supports" => ["title"],
        ];

        register_post_type(self::CUSTOM_POST_TYPE, $args);

        add_post_type_support(self::CUSTOM_POST_TYPE, "elementor");
    }

    /**
     *
     */
    public function add_custom_post_template_support($template)
    {
        if (is_singular(self::CUSTOM_POST_TYPE)) {
            $template_file =
                ELEMENTOR_ADDON_PLUGIN_PATH .
                "/includes/templates/custom-post-support.php";
            if (file_exists($template_file)) {
                return $template_file;
            }
        }
        return $template;
    }

    /**
     * Checks if header is available and enabled
     *
     * @return bool
     * @since 0.0.1
     */
    public function is_header_exists_and_enabled()
    {
        $args = [
            "numberposts" => 1,
            "post_type" => self::CUSTOM_POST_TYPE,
            "order" => "DESC",
            "orderby" => "id",
        ];
        $posts = get_posts($args);

        if ($posts) {
            $this->post_id = $posts[0]->ID;
            return true;
        }

        return false;
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
        /**
         * Don't print header when previewing or editing
         */
        if (is_singular(self::CUSTOM_POST_TYPE)) {
            return false;
        }
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
        return $this->post_id;
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
        if ($this->should_header_render() === false) {
            return;
        }

        $id = $this->get_header_id();

        $this->load_assets($id);

        echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display(
            $id,
            true
        );
    }
}
