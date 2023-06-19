<?php

/**
 * Prevent direct access
 */
if (!defined("ABSPATH")) {
    exit();
}

require_once ELEMENTOR_ADDON_PLUGIN_PATH . "/includes/traits/Units.php";

class MegaMenu extends \Elementor\Widget_Base
{
    /**
     * @since 0.0.1
     */
    use Units;

    public function get_name()
    {
        return "mega_menu";
    }

    public function get_title()
    {
        return esc_html__(
            "Mega menu",
            \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
        );
    }

    public function get_icon()
    {
        return "eicon-code";
    }

    public function get_categories()
    {
        return [\Elementor_Addon\Plugin::PLUGIN_CATEGORY];
    }

    public function get_keywords()
    {
        return [
            "menu",
            "mega",
            "hamburger",
            \Elementor_Addon\Plugin::PLUGIN_NAME,
        ];
    }

    public function get_script_depends()
    {
        return [\Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN . "-mega-menu"];
    }

    public function get_style_depends()
    {
        return [\Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN . "-mega-menu"];
    }

    protected function register_controls()
    {
        // Logo
        $this->start_controls_section("section_content", [
            "label" => esc_html__(
                "Content",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "tab" => Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control("logo", [
            "label" => esc_html__(
                "Logo",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "type" => Controls_Manager::MEDIA,
            "default" => [
                "url" => "", // Default placeholder image URL
            ],
        ]);
        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $due_date_in_days = 0;
        $due_date_in_hours = 0;
        $due_date_in_minutes = 0;
        $due_date_in_seconds = 0;

        /**
         * Get total seconds
         * subtract past time from in
         * get Future time only
         *
         * @since 0.0.1
         */
        $due_date = strtotime($this->get_settings("due_date")) - time();
        if (0 < $due_date) {
            $due_date_in_days = intval($due_date / DAY_IN_SECONDS);
            // Subtract days from total time
            $due_date = $due_date - DAY_IN_SECONDS * $due_date_in_days;

            $due_date_in_hours = intval($due_date / HOUR_IN_SECONDS);
            // Subtract hours from total time
            $due_date = $due_date - HOUR_IN_SECONDS * $due_date_in_hours;

            $due_date_in_minutes = intval($due_date / MINUTE_IN_SECONDS);
            // Subtract minutes from total time
            $due_date = $due_date - MINUTE_IN_SECONDS * $due_date_in_minutes;

            $due_date_in_seconds = $due_date;
        }

        /**
         * Numbers should be at least 2 digit
         * if not add 0 ahead
         */
        if ($due_date_in_days < 10) {
            $due_date_in_days = "0$due_date_in_days";
        }
        if ($due_date_in_hours < 10) {
            $due_date_in_hours = "0$due_date_in_hours";
        }
        if ($due_date_in_minutes < 10) {
            $due_date_in_minutes = "0$due_date_in_minutes";
        }
        if ($due_date_in_seconds < 10) {
            $due_date_in_seconds = "0$due_date_in_seconds";
        }

        $data = [
            "class" => [
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN . "--count-down",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN . "--flex",
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
                    <div class="days <?php echo \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN .
                        "--center"; ?>">
                        <span ><?php echo $due_date_in_days; ?></span>
                        <h6>
                            <?php echo $settings["days_title"]; ?>
                        </h6>
                    </div>
                    <div class="hours <?php echo \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN .
                        "--center"; ?>"">
                        <span ><?php echo $due_date_in_hours; ?></span>
                        <h6>
                            <?php echo $settings["hours_title"]; ?>
                        </h6>
                    </div>
                    <div class="minutes <?php echo \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN .
                        "--center"; ?>"">
                        <span ><?php echo $due_date_in_minutes; ?></span>
                        <h6>
                          <?php echo $settings["minutes_title"]; ?>
                        </h6>
                    </div>
                    <div class="seconds <?php echo \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN .
                        "--center"; ?>"">
                        <span ><?php echo $due_date_in_seconds; ?></span>
                        <h6>
                            <?php echo $settings["seconds_title"]; ?>
                        </h6>
                    </div>
            </div>
        <?php
    }
}
