<?php

/**
 * Prevent direct access
 */
if (!defined("ABSPATH")) {
    exit();
}

require_once ELEMENTOR_ADDON_PLUGIN_PATH . "/includes/traits/Units.php";

class CountDown extends \Elementor\Widget_Base
{
    /**
     * @since 0.0.1
     */
    use Units;

    public function get_name()
    {
        return "count_down";
    }

    public function get_title()
    {
        return esc_html__(
            "Count Down",
            \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
        );
    }

    public function get_icon()
    {
        return "eicon-countdown";
    }

    public function get_categories()
    {
        return [\Elementor_Addon\Plugin::PLUGIN_CATEGORY];
    }

    public function get_keywords()
    {
        return ["count", "down", "timer", \Elementor_Addon\Plugin::PLUGIN_NAME];
    }

    public function get_script_depends()
    {
        return [
            \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN . "-count-down-script",
        ];
    }

    protected function register_controls()
    {
        // -------- Count Down -----
        $this->start_controls_section("section_content", [
            "label" => esc_html__(
                "Count Down",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "tab" => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control("due_date", [
            "type" => \Elementor\Controls_Manager::DATE_TIME,
            "label" => esc_html__(
                "Due Date & Time",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "picker_options" => [
                "enableTime:true",
                "minuteIncrement:1",
                "enableSeconds:true",
                "time_24hr:true",
                "monthSelectorType:'dropdown'",
            ],
        ]);

        $this->add_control("days_title", [
            "type" => \Elementor\Controls_Manager::TEXT,
            "label" => esc_html__(
                "Days Title",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "placeholder" => esc_html__(
                "Days",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "default" => "Days",
        ]);

        $this->add_control("hours_title", [
            "type" => \Elementor\Controls_Manager::TEXT,
            "label" => esc_html__(
                "Hours Title",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "placeholder" => esc_html__(
                "Hours",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "default" => "Hours",
        ]);

        $this->add_control("minutes_title", [
            "type" => \Elementor\Controls_Manager::TEXT,
            "label" => esc_html__(
                "Minutes Title",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "placeholder" => esc_html__(
                "Minutes",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "default" => "Minutes",
        ]);

        $this->add_control("seconds_title", [
            "type" => \Elementor\Controls_Manager::TEXT,
            "label" => esc_html__(
                "Seconds Title",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "placeholder" => esc_html__(
                "Seconds",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "default" => "Seconds",
        ]);

        $this->end_controls_section();

        // ------- STYLE SECTION -------

        // Counter
        $this->start_controls_section("section_counter", [
            "label" => esc_html__(
                "Counter",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "tab" => \Elementor\Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control("counter-color", [
            "type" => \Elementor\Controls_Manager::COLOR,
            "label" => esc_html__(
                "Counter Color",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "default" => "#000",
            "selectors" => [
                "{{WRAPPER}} div span" => "color: {{value}}",
            ],
        ]);

        $this->add_control("counter-title-color", [
            "type" => \Elementor\Controls_Manager::COLOR,
            "label" => esc_html__(
                "Title Color",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "default" => "#000",
            "selectors" => [
                "{{WRAPPER}} div h6" => "color: {{value}}",
            ],
        ]);

        // Counter font size
        $this->add_control("counter-font-size", [
            "type" => \Elementor\Controls_Manager::SLIDER,
            "label" => esc_html__(
                "Counter Font Size",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "size_units" => self::get_units(),
            "range" => self::get_ranges(),
            "default" => [
                "size" => 3,
                "unit" => "rem",
            ],
            "selectors" => [
                "{{WRAPPER}} div div span" => "font-size: {{size}}{{unit}}",
            ],
        ]);

        // Title font size
        $this->add_control("counter-title-font-size", [
            "type" => \Elementor\Controls_Manager::SLIDER,
            "label" => esc_html__(
                "Title Font Size",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "size_units" => self::get_units(),
            "range" => self::get_ranges(),
            "default" => [
                "size" => 1,
                "unit" => "rem",
            ],
            "selectors" => [
                "{{WRAPPER}} div div h6" => "font-size: {{size}}{{unit}}",
            ],
        ]);

        // Gap
        $this->add_control("counter-gap", [
            "type" => \Elementor\Controls_Manager::SLIDER,
            "label" => esc_html__(
                "Gap",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "size_units" => self::get_units(),
            "range" => self::get_ranges(),
            "default" => [
                "size" => 3,
                "unit" => "rem",
            ],
            "selectors" => [
                "{{WRAPPER}} div" => "gap: {{size}}{{unit}}",
            ],
        ]);

        // Position
        $this->add_control("counter-position", [
            "type" => \Elementor\Controls_Manager::CHOOSE,
            "label" => esc_html__(
                "Position items",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "options" => [
                "left" => [
                    "title" => esc_html__(
                        "Left",
                        \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
                    ),
                    "icon" => "eicon-text-align-left",
                ],
                "center" => [
                    "title" => esc_html__(
                        "Center",
                        \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
                    ),
                    "icon" => "eicon-text-align-center",
                ],
                "right" => [
                    "title" => esc_html__(
                        "Right",
                        \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
                    ),
                    "icon" => "eicon-text-align-right",
                ],
                "space-evenly" => [
                    "title" => esc_html__(
                        "Evenly",
                        \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
                    ),
                    "icon" => "eicon-text-align-between",
                ],
                "space-between" => [
                    "title" => esc_html__(
                        "Space Between",
                        \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
                    ),
                    "icon" => "eicon-text-align-justify",
                ],
            ],
            "default" => "space-between",
            "selectors" => [
                "{{WRAPPER}} div" => "justify-content: {{value}}",
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
