<?php

/**
 * Prevent direct access
 */
if (!defined("ABSPATH")) {
    exit();
}

require_once ELEMENTOR_ADDON_PLUGIN_PATH . "/includes/traits/Units.php";

class SiteLogo extends \Elementor\Widget_Base
{
    /**
     * @since 0.0.1
     */
    use Units;

    public function get_name()
    {
        return "site_logo";
    }

    public function get_title()
    {
        return esc_html__(
            "Site Logo",
            \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
        );
    }

    public function get_icon()
    {
        return "eicon-logo";
    }

    public function get_categories()
    {
        return [\Elementor_Addon\Plugin::PLUGIN_CATEGORY];
    }

    public function get_keywords()
    {
        return ["logo", "site", "icon", \Elementor_Addon\Plugin::PLUGIN_NAME];
    }

    protected function register_controls()
    {
        $this->start_controls_section("section_content", [
            "label" => esc_html__(
                "Content",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "tab" => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control("use_custom_image", [
            "label" => esc_html__(
                "Use custom image",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "type" => \Elementor\Controls_Manager::SWITCHER,
            "default" => "no",
        ]);

        $this->add_control("site_logo", [
            "label" => esc_html__(
                "Upload",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "type" => \Elementor\Controls_Manager::MEDIA,
            "condition" => [
                "use_custom_image" => "yes",
            ],
        ]);

        $this->add_control("width_auto", [
            "label" => esc_html__(
                "Width size auto",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "type" => \Elementor\Controls_Manager::SWITCHER,
            "label_on" => "Yes",
            "label_off" => "No",
            "return_value" => "yes",
            "default" => "yes",
            "selectors" => [
                "{{WRAPPER}} div a img" => "width: auto",
            ],
        ]);

        $this->add_control("width", [
            "type" => \Elementor\Controls_Manager::SLIDER,
            "label" => esc_html__(
                "Width",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "size_units" => self::get_units(),
            "range" => self::get_ranges(),
            "default" => [
                "size" => 3,
                "unit" => "rem",
            ],
            "selectors" => [
                "{{WRAPPER}} div a img" => "width: {{size}}{{unit}}",
            ],
            "condition" => [
                "width_auto!" => "yes",
            ],
        ]);

        $this->add_control("height_auto", [
            "label" => esc_html__(
                "Height size auto",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "type" => \Elementor\Controls_Manager::SWITCHER,
            "default" => "yes",
            "selectors" => [
                "{{WRAPPER}} div a img" => "height: auto",
            ],
        ]);

        $this->add_control("height", [
            "type" => \Elementor\Controls_Manager::SLIDER,
            "label" => esc_html__(
                "Height",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "size_units" => self::get_units(),
            "range" => self::get_ranges(),
            "default" => [
                "size" => 3,
                "unit" => "rem",
            ],
            "selectors" => [
                "{{WRAPPER}} div a img" => "height: {{size}}{{unit}}",
            ],
            "condition" => [
                "height_auto!" => "yes",
            ],
        ]);

        $this->end_controls_section();
    }

    /**
     * Get site logo
     */
    private function get_site_logo_url()
    {
        $logo = get_custom_logo(); // Retrieve the HTML markup for the logo
        preg_match('/<img.*?src=["\'](.*?)["\'].*?>/i', $logo, $matches); // Extract the URL from the HTML markup

        if (isset($matches[1])) {
            return $matches[1]; // Return the URL of the logo image
        }

        return "";
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $site_logo_url = $this->get_site_logo_url();

        if ($settings["use_custom_image"] === "yes") {
            $site_logo_url = $settings["site_logo"]["url"];
        }

        $data = [
            "class" => [
                isset($settings["custom_class"])
                    ? $settings["custom_class"]
                    : "",
                isset($settings["class"]) ? $settings["class"] : "",
            ],
        ];

        if (isset($settings["role"])) {
            $data["role"] = $settings["role"];
        }
        if (isset($settings["name"])) {
            $data["aria-label"] = $settings["name"];
        }

        $this->add_render_attribute("wrapper", $data);
        ?>
            <div <?php echo $this->get_render_attribute_string("wrapper"); ?>
            >
                <a href="<?php echo home_url(); ?>">
                    <img src="<?php echo $site_logo_url; ?>" alt="site logo">
                </a>
            </div>
        <?php
    }
}
