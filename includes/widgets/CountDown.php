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

    public function get_style_depends()
    {
        return [
            \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN . "-count-down-style",
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

        // Get the list of available countries
        // $locales = ResourceBundle::getLocales("");

        // // Create an array of country options
        // $country_options = [];
        // foreach ($locales as $locale) {
        //     $country_code = Locale::getRegion($locale);
        //     $country_name = Locale::getDisplayRegion($locale, $locale);
        //     $country_options[$country_code] = $country_name;
        // }

        // // Add the control for selecting output format
        // $this->add_control("output_format", [
        //     "type" => \Elementor\Controls_Manager::SELECT,
        //     "label" => esc_html__(
        //         "Output Format",
        //         \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
        //     ),
        //     "options" => $country_options,
        // ]);

        $this->add_control("show_title", [
            "type" => \Elementor\Controls_Manager::SWITCHER,
            "label" => esc_html__(
                "Show title",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "label_on" => esc_html__(
                "Show",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "label_off" => esc_html__(
                "Hide",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "return_value" => "yes",
            "default" => "yes",
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
            "condition" => [
                "show_title" => "yes",
            ],
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
            "condition" => [
                "show_title" => "yes",
            ],
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
            "condition" => [
                "show_title" => "yes",
            ],
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
            "condition" => [
                "show_title" => "yes",
            ],
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

        $this->add_control("counter-font-weight", [
            "type" => \Elementor\Controls_Manager::SELECT,
            "label" => esc_html__(
                "Counter Font Weight",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "default" => "normal",
            "options" => [
                "normal" => esc_html__(
                    "Normal",
                    \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
                ),
                "bold" => esc_html__(
                    "Bold",
                    \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
                ),
                "bolder" => esc_html__(
                    "Bolder",
                    \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
                ),
                "lighter" => esc_html__(
                    "Lighter",
                    \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
                ),
                "100" => "100",
                "200" => "200",
                "300" => "300",
                "400" => "400",
                "500" => "500",
                "600" => "600",
                "700" => "700",
                "800" => "800",
                "900" => "900",
            ],
            "selectors" => [
                "{{WRAPPER}} div div span" => "font-weight: {{value}}",
            ],
        ]);

        $this->add_control("counter-font-family", [
            "label" => esc_html__(
                "Counter Font Family",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "type" => \Elementor\Controls_Manager::FONT,
            "selectors" => [
                "{{WRAPPER}} div div span" => "font-family: {{VALUE}}",
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
                    "icon" => "eicon-h-align-left",
                ],
                "center" => [
                    "title" => esc_html__(
                        "Center",
                        \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
                    ),
                    "icon" => "eicon-h-align-center",
                ],
                "right" => [
                    "title" => esc_html__(
                        "Right",
                        \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
                    ),
                    "icon" => "eicon-h-align-right",
                ],
                "space-evenly" => [
                    "title" => esc_html__(
                        "Evenly",
                        \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
                    ),
                    "icon" => "eicon-h-align-stretch",
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

        $this->start_controls_section("section_title", [
            "label" => esc_html__(
                "Title",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "tab" => \Elementor\Controls_Manager::TAB_STYLE,
            "condition" => [
                "show_title" => "yes",
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

        $this->add_control("counter-title-font-weight", [
            "type" => \Elementor\Controls_Manager::SELECT,
            "label" => esc_html__(
                "Title Font Weight",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "default" => "normal",
            "options" => [
                "normal" => esc_html__(
                    "Normal",
                    \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
                ),
                "bold" => esc_html__(
                    "Bold",
                    \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
                ),
                "bolder" => esc_html__(
                    "Bolder",
                    \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
                ),
                "lighter" => esc_html__(
                    "Lighter",
                    \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
                ),
                "100" => "100",
                "200" => "200",
                "300" => "300",
                "400" => "400",
                "500" => "500",
                "600" => "600",
                "700" => "700",
                "800" => "800",
                "900" => "900",
            ],
            "selectors" => [
                "{{WRAPPER}} div div h6" => "font-weight: {{value}}",
            ],
        ]);

        $this->add_control("title-font-family", [
            "label" => esc_html__(
                "Title Font Family",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "type" => \Elementor\Controls_Manager::FONT,
            "selectors" => [
                "{{WRAPPER}} div div h6" => "font-family: {{VALUE}}",
            ],
        ]);

        $this->end_controls_section();

        $this->start_controls_section("days_section", [
            "label" => esc_html__(
                "Days",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "tab" => \Elementor\Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control("counter-day-color", [
            "type" => \Elementor\Controls_Manager::COLOR,
            "label" => esc_html__(
                "Day Color",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "selectors" => [
                "{{WRAPPER}} div.days span" => "color: {{value}}",
            ],
        ]);

        $this->add_control("day-font-size", [
            "type" => \Elementor\Controls_Manager::SLIDER,
            "label" => esc_html__(
                "Day Font Size",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "size_units" => self::get_units(),
            "range" => self::get_ranges(),
            "selectors" => [
                "{{WRAPPER}} div div.days span" =>
                    "font-size: {{size}}{{unit}}",
            ],
        ]);

        $this->add_control("day-font-weight", [
            "type" => \Elementor\Controls_Manager::SELECT,
            "label" => esc_html__(
                "Day Font Weight",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "options" => [
                "normal" => esc_html__(
                    "Normal",
                    \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
                ),
                "bold" => esc_html__(
                    "Bold",
                    \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
                ),
                "bolder" => esc_html__(
                    "Bolder",
                    \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
                ),
                "lighter" => esc_html__(
                    "Lighter",
                    \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
                ),
                "100" => "100",
                "200" => "200",
                "300" => "300",
                "400" => "400",
                "500" => "500",
                "600" => "600",
                "700" => "700",
                "800" => "800",
                "900" => "900",
            ],
            "selectors" => [
                "{{WRAPPER}} div div.days span" => "font-weight: {{value}}",
            ],
        ]);

        $this->add_control("day-font-family", [
            "label" => esc_html__(
                "Day Font Family",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "type" => \Elementor\Controls_Manager::FONT,
            "selectors" => [
                "{{WRAPPER}} div div.days span" => "font-family: {{VALUE}}",
            ],
        ]);

        $this->add_control("day-title-color", [
            "type" => \Elementor\Controls_Manager::COLOR,
            "label" => esc_html__(
                "Days Title Color",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "selectors" => [
                "{{WRAPPER}} div.days h6" => "color: {{value}}",
            ],
            "condition" => [
                "show_title" => "yes",
            ],
        ]);

        $this->add_control("days-title-font-size", [
            "type" => \Elementor\Controls_Manager::SLIDER,
            "label" => esc_html__(
                "Days Title Font Size",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "size_units" => self::get_units(),
            "range" => self::get_ranges(),
            "selectors" => [
                "{{WRAPPER}} div div.days h6" => "font-size: {{size}}{{unit}}",
            ],
            "condition" => [
                "show_title" => "yes",
            ],
        ]);

        $this->add_control("days-title-font-weight", [
            "type" => \Elementor\Controls_Manager::SELECT,
            "label" => esc_html__(
                "Days Title Font Weight",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "options" => [
                "normal" => esc_html__(
                    "Normal",
                    \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
                ),
                "bold" => esc_html__(
                    "Bold",
                    \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
                ),
                "bolder" => esc_html__(
                    "Bolder",
                    \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
                ),
                "lighter" => esc_html__(
                    "Lighter",
                    \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
                ),
                "100" => "100",
                "200" => "200",
                "300" => "300",
                "400" => "400",
                "500" => "500",
                "600" => "600",
                "700" => "700",
                "800" => "800",
                "900" => "900",
            ],
            "selectors" => [
                "{{WRAPPER}} div div.days h6" => "font-weight: {{value}}",
            ],
            "condition" => [
                "show_title" => "yes",
            ],
        ]);

        $this->add_control("days-title-font-family", [
            "label" => esc_html__(
                "Days Title Font Family",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "type" => \Elementor\Controls_Manager::FONT,
            "selectors" => [
                "{{WRAPPER}} div div.days h6" => "font-family: {{VALUE}}",
            ],
            "condition" => [
                "show_title" => "yes",
            ],
        ]);

        $this->end_controls_section();

        $this->start_controls_section("hours_section", [
            "label" => esc_html__(
                "Hours",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "tab" => \Elementor\Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control("counter-hour-color", [
            "type" => \Elementor\Controls_Manager::COLOR,
            "label" => esc_html__(
                "Hour Color",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "selectors" => [
                "{{WRAPPER}} div.hours span" => "color: {{value}}",
            ],
        ]);

        $this->add_control("hour-font-size", [
            "type" => \Elementor\Controls_Manager::SLIDER,
            "label" => esc_html__(
                "Hour Font Size",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "size_units" => self::get_units(),
            "range" => self::get_ranges(),
            "selectors" => [
                "{{WRAPPER}} div div.hours span" =>
                    "font-size: {{size}}{{unit}}",
            ],
        ]);

        $this->add_control("hour-font-weight", [
            "type" => \Elementor\Controls_Manager::SELECT,
            "label" => esc_html__(
                "Hour Font Weight",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "options" => [
                "normal" => esc_html__(
                    "Normal",
                    \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
                ),
                "bold" => esc_html__(
                    "Bold",
                    \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
                ),
                "bolder" => esc_html__(
                    "Bolder",
                    \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
                ),
                "lighter" => esc_html__(
                    "Lighter",
                    \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
                ),
                "100" => "100",
                "200" => "200",
                "300" => "300",
                "400" => "400",
                "500" => "500",
                "600" => "600",
                "700" => "700",
                "800" => "800",
                "900" => "900",
            ],
            "selectors" => [
                "{{WRAPPER}} div div.hours span" => "font-weight: {{value}}",
            ],
        ]);

        $this->add_control("hour-font-family", [
            "label" => esc_html__(
                "Hour Font Family",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "type" => \Elementor\Controls_Manager::FONT,
            "selectors" => [
                "{{WRAPPER}} div div.hours span" => "font-family: {{VALUE}}",
            ],
        ]);

        $this->add_control("hour-title-color", [
            "type" => \Elementor\Controls_Manager::COLOR,
            "label" => esc_html__(
                "Hours Title Color",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "selectors" => [
                "{{WRAPPER}} div.hours h6" => "color: {{value}}",
            ],
            "condition" => [
                "show_title" => "yes",
            ],
        ]);

        $this->add_control("hours-title-font-size", [
            "type" => \Elementor\Controls_Manager::SLIDER,
            "label" => esc_html__(
                "Hours Title Font Size",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "size_units" => self::get_units(),
            "range" => self::get_ranges(),
            "selectors" => [
                "{{WRAPPER}} div div.hours h6" => "font-size: {{size}}{{unit}}",
            ],
            "condition" => [
                "show_title" => "yes",
            ],
        ]);

        $this->add_control("hours-title-font-weight", [
            "type" => \Elementor\Controls_Manager::SELECT,
            "label" => esc_html__(
                "Hours Title Font Weight",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "options" => [
                "normal" => esc_html__(
                    "Normal",
                    \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
                ),
                "bold" => esc_html__(
                    "Bold",
                    \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
                ),
                "bolder" => esc_html__(
                    "Bolder",
                    \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
                ),
                "lighter" => esc_html__(
                    "Lighter",
                    \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
                ),
                "100" => "100",
                "200" => "200",
                "300" => "300",
                "400" => "400",
                "500" => "500",
                "600" => "600",
                "700" => "700",
                "800" => "800",
                "900" => "900",
            ],
            "selectors" => [
                "{{WRAPPER}} div div.hours h6" => "font-weight: {{value}}",
            ],
            "condition" => [
                "show_title" => "yes",
            ],
        ]);

        $this->add_control("hours-title-font-family", [
            "label" => esc_html__(
                "Hours Title Font Family",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "type" => \Elementor\Controls_Manager::FONT,
            "selectors" => [
                "{{WRAPPER}} div div.hours h6" => "font-family: {{VALUE}}",
            ],
            "condition" => [
                "show_title" => "yes",
            ],
        ]);

        $this->end_controls_section();

        $this->start_controls_section("minutes_section", [
            "label" => esc_html__(
                "Minutes",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "tab" => \Elementor\Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control("counter-minutes-color", [
            "type" => \Elementor\Controls_Manager::COLOR,
            "label" => esc_html__(
                "Minutes Color",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "selectors" => [
                "{{WRAPPER}} div.minutes span" => "color: {{value}}",
            ],
        ]);

        $this->add_control("minutes-font-size", [
            "type" => \Elementor\Controls_Manager::SLIDER,
            "label" => esc_html__(
                "Minutes Font Size",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "size_units" => self::get_units(),
            "range" => self::get_ranges(),
            "selectors" => [
                "{{WRAPPER}} div div.minutes span" =>
                    "font-size: {{size}}{{unit}}",
            ],
        ]);

        $this->add_control("minutes-font-weight", [
            "type" => \Elementor\Controls_Manager::SELECT,
            "label" => esc_html__(
                "Minutes Font Weight",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "options" => [
                "normal" => esc_html__(
                    "Normal",
                    \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
                ),
                "bold" => esc_html__(
                    "Bold",
                    \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
                ),
                "bolder" => esc_html__(
                    "Bolder",
                    \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
                ),
                "lighter" => esc_html__(
                    "Lighter",
                    \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
                ),
                "100" => "100",
                "200" => "200",
                "300" => "300",
                "400" => "400",
                "500" => "500",
                "600" => "600",
                "700" => "700",
                "800" => "800",
                "900" => "900",
            ],
            "selectors" => [
                "{{WRAPPER}} div div.minutes span" => "font-weight: {{value}}",
            ],
        ]);

        $this->add_control("minutes-font-family", [
            "label" => esc_html__(
                "Minutes Font Family",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "type" => \Elementor\Controls_Manager::FONT,
            "selectors" => [
                "{{WRAPPER}} div div.minutes span" => "font-family: {{VALUE}}",
            ],
        ]);

        $this->add_control("minutes-title-color", [
            "type" => \Elementor\Controls_Manager::COLOR,
            "label" => esc_html__(
                "Minutes Title Color",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "selectors" => [
                "{{WRAPPER}} div.minutes h6" => "color: {{value}}",
            ],
            "condition" => [
                "show_title" => "yes",
            ],
        ]);

        $this->add_control("minutes-title-font-size", [
            "type" => \Elementor\Controls_Manager::SLIDER,
            "label" => esc_html__(
                "Minutes Title Font Size",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "size_units" => self::get_units(),
            "range" => self::get_ranges(),
            "selectors" => [
                "{{WRAPPER}} div div.minutes h6" =>
                    "font-size: {{size}}{{unit}}",
            ],
            "condition" => [
                "show_title" => "yes",
            ],
        ]);

        $this->add_control("minutes-title-font-weight", [
            "type" => \Elementor\Controls_Manager::SELECT,
            "label" => esc_html__(
                "Minutes Title Font Weight",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "options" => [
                "normal" => esc_html__(
                    "Normal",
                    \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
                ),
                "bold" => esc_html__(
                    "Bold",
                    \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
                ),
                "bolder" => esc_html__(
                    "Bolder",
                    \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
                ),
                "lighter" => esc_html__(
                    "Lighter",
                    \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
                ),
                "100" => "100",
                "200" => "200",
                "300" => "300",
                "400" => "400",
                "500" => "500",
                "600" => "600",
                "700" => "700",
                "800" => "800",
                "900" => "900",
            ],
            "selectors" => [
                "{{WRAPPER}} div div.minutes h6" => "font-weight: {{value}}",
            ],
            "condition" => [
                "show_title" => "yes",
            ],
        ]);

        $this->add_control("minutes-title-font-family", [
            "label" => esc_html__(
                "Minutes Title Font Family",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "type" => \Elementor\Controls_Manager::FONT,
            "selectors" => [
                "{{WRAPPER}} div div.minutes h6" => "font-family: {{VALUE}}",
            ],
            "condition" => [
                "show_title" => "yes",
            ],
        ]);

        $this->end_controls_section();

        $this->start_controls_section("seconds_section", [
            "label" => esc_html__(
                "Seconds",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "tab" => \Elementor\Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control("counter-second-color", [
            "type" => \Elementor\Controls_Manager::COLOR,
            "label" => esc_html__(
                "Seconds Color",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "selectors" => [
                "{{WRAPPER}} div.seconds span" => "color: {{value}}",
            ],
        ]);

        $this->add_control("second-font-size", [
            "type" => \Elementor\Controls_Manager::SLIDER,
            "label" => esc_html__(
                "Seconds Font Size",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "size_units" => self::get_units(),
            "range" => self::get_ranges(),
            "selectors" => [
                "{{WRAPPER}} div div.seconds span" =>
                    "font-size: {{size}}{{unit}}",
            ],
        ]);

        $this->add_control("seconds-font-weight", [
            "type" => \Elementor\Controls_Manager::SELECT,
            "label" => esc_html__(
                "Seconds Font Weight",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "options" => [
                "normal" => esc_html__(
                    "Normal",
                    \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
                ),
                "bold" => esc_html__(
                    "Bold",
                    \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
                ),
                "bolder" => esc_html__(
                    "Bolder",
                    \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
                ),
                "lighter" => esc_html__(
                    "Lighter",
                    \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
                ),
                "100" => "100",
                "200" => "200",
                "300" => "300",
                "400" => "400",
                "500" => "500",
                "600" => "600",
                "700" => "700",
                "800" => "800",
                "900" => "900",
            ],
            "selectors" => [
                "{{WRAPPER}} div div.seconds span" => "font-weight: {{value}}",
            ],
        ]);

        $this->add_control("seconds-font-family", [
            "label" => esc_html__(
                "Seconds Font Family",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "type" => \Elementor\Controls_Manager::FONT,
            "selectors" => [
                "{{WRAPPER}} div div.seconds span" => "font-family: {{VALUE}}",
            ],
        ]);

        $this->add_control("seconds-title-color", [
            "type" => \Elementor\Controls_Manager::COLOR,
            "label" => esc_html__(
                "Seconds Title Color",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "selectors" => [
                "{{WRAPPER}} div.seconds h6" => "color: {{value}}",
            ],
            "condition" => [
                "show_title" => "yes",
            ],
        ]);

        $this->add_control("seconds-title-font-size", [
            "type" => \Elementor\Controls_Manager::SLIDER,
            "label" => esc_html__(
                "Seconds Title Font Size",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "size_units" => self::get_units(),
            "range" => self::get_ranges(),
            "selectors" => [
                "{{WRAPPER}} div div.seconds h6" =>
                    "font-size: {{size}}{{unit}}",
            ],
            "condition" => [
                "show_title" => "yes",
            ],
        ]);

        $this->add_control("seconds-title-font-weight", [
            "type" => \Elementor\Controls_Manager::SELECT,
            "label" => esc_html__(
                "Seconds Title Font Weight",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "options" => [
                "normal" => esc_html__(
                    "Normal",
                    \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
                ),
                "bold" => esc_html__(
                    "Bold",
                    \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
                ),
                "bolder" => esc_html__(
                    "Bolder",
                    \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
                ),
                "lighter" => esc_html__(
                    "Lighter",
                    \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
                ),
                "100" => "100",
                "200" => "200",
                "300" => "300",
                "400" => "400",
                "500" => "500",
                "600" => "600",
                "700" => "700",
                "800" => "800",
                "900" => "900",
            ],
            "selectors" => [
                "{{WRAPPER}} div div.seconds h6" => "font-weight: {{value}}",
            ],
            "condition" => [
                "show_title" => "yes",
            ],
        ]);

        $this->add_control("seconds-title-font-family", [
            "label" => esc_html__(
                "Seconds Title Font Family",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "type" => \Elementor\Controls_Manager::FONT,
            "selectors" => [
                "{{WRAPPER}} div div.seconds h6" => "font-family: {{VALUE}}",
            ],
            "condition" => [
                "show_title" => "yes",
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

        if (isset($settings["output_format"])) {
            $data["output_format"] = $settings["output_format"];
        }

        $this->add_render_attribute("wrapper", $data);
        ?>
            <div <?php echo $this->get_render_attribute_string("wrapper"); ?>
            >
                    <div class="days <?php echo \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN .
                        "--center"; ?>">
                        <span ><?php echo $due_date_in_days; ?></span>
                        <?php if ($settings["show_title"]) { ?>
                            <h6>
                                <?php echo $settings["days_title"]; ?>
                            </h6>
                        <?php } ?>
                    </div>
                    <div class="hours <?php echo \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN .
                        "--center"; ?>"">
                        <span ><?php echo $due_date_in_hours; ?></span>
                        <?php if ($settings["show_title"]) { ?>
                            <h6>
                                <?php echo $settings["hours_title"]; ?>
                            </h6>
                        <?php } ?>
                    </div>
                    <div class="minutes <?php echo \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN .
                        "--center"; ?>"">
                        <span ><?php echo $due_date_in_minutes; ?></span>
                        <?php if ($settings["show_title"]) { ?>
                            
                            <h6>
                                <?php echo $settings["minutes_title"]; ?>
                            </h6>
                        <?php } ?>
                        </div>
                        <div class="seconds <?php echo \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN .
                            "--center"; ?>"">
                        <span ><?php echo $due_date_in_seconds; ?></span>
                        <?php if ($settings["show_title"]) { ?>
                            <h6>
                                <?php echo $settings["seconds_title"]; ?>
                            </h6>
                        <?php } ?>
                    </div>
            </div>
        <?php
    }
}
