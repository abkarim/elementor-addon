<?php

/**
 * Prevent direct access
 */
if (!defined("ABSPATH")) {
    exit();
}

class CountDown extends \Elementor\Widget_Base
{
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
        return "eicon-code";
    }

    public function get_categories()
    {
        return [
            "general",
            \Elementor_Addon\Plugin::PLUGIN_WIDGETS_CATEGORY_SLUG,
        ];
    }

    public function get_keywords()
    {
        return ["count", "down"];
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
        // ------- Title -------
        $this->start_controls_section("section_title", [
            "label" => esc_html__(
                "Title",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "tab" => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control("title", [
            "type" => \Elementor\Controls_Manager::TEXT,
            "label" => esc_html__(
                "Title",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "default" => "Time Left",
        ]);

        $this->add_control("alignment", [
            "type" => \Elementor\Controls_Manager::CHOOSE,
            "label" => esc_html__(
                "Alignment",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "options" => [
                "has-text-align-left" => [
                    "title" => esc_html__(
                        "Left",
                        \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
                    ),
                    "icon" => "eicon-text-align-left",
                ],
                "has-text-align-center" => [
                    "title" => esc_html__(
                        "Center",
                        \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
                    ),
                    "icon" => "eicon-text-align-center",
                ],
                "has-text-align-right" => [
                    "title" => esc_html__(
                        "Right",
                        \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
                    ),
                    "icon" => "eicon-text-align-right",
                ],
            ],
            "default" => "center",
        ]);

        $this->add_control("size", [
            "type" => \Elementor\Controls_Manager::NUMBER,
            "label" => esc_html__(
                "Size",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "placeholder" => "0",
            "min" => 0,
            "max" => 100,
            "step" => 1,
            "default" => 50,
        ]);

        $this->end_controls_section();

        // -------- Set Time -----
        $this->start_controls_section("section_content", [
            "label" => esc_html__(
                "Time",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "tab" => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control("seconds", [
            "type" => \Elementor\Controls_Manager::NUMBER,
            "label" => esc_html__(
                "Seconds",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "min" => 0,
            "max" => 60,
            "step" => 1,
            "default" => 10,
        ]);

        $this->add_control("minutes", [
            "type" => \Elementor\Controls_Manager::NUMBER,
            "label" => esc_html__(
                "Minutes",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "min" => 0,
            "max" => 60,
            "step" => 1,
            "default" => 0,
        ]);

        $this->add_control("hours", [
            "type" => \Elementor\Controls_Manager::NUMBER,
            "label" => esc_html__(
                "Hours",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "min" => 0,
            "max" => 24,
            "step" => 1,
            "default" => 0,
        ]);

        $this->add_control("days", [
            "type" => \Elementor\Controls_Manager::NUMBER,
            "label" => esc_html__(
                "Days",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "min" => 0,
            "step" => 1,
            "default" => 0,
        ]);

        $this->end_controls_section();

        // ------- STYLE SECTION -------

        // Title
        $this->start_controls_section("section_title_style", [
            "label" => esc_html__(
                "Title",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "tab" => \Elementor\Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control("title-color", [
            "type" => \Elementor\Controls_Manager::COLOR,
            "label" => esc_html__(
                "Title Color",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "default" => "#000",
            "selectors" => [
                "{{WRAPPER}} div header h5" => "color: {{value}}",
            ],
        ]);

        $this->end_controls_section();

        // Counter
        $this->start_controls_section("section_counter", [
            "label" => esc_html__(
                "Counter",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "tab" => \Elementor\Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control("numbers-color", [
            "type" => \Elementor\Controls_Manager::COLOR,
            "label" => esc_html__(
                "Number Color",
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN
            ),
            "default" => "#000",
            "selectors" => [
                "{{WRAPPER}} div span" => "color: {{value}}",
            ],
        ]);

        $this->add_control("numbers-title-color", [
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

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $data = [
            "class" => [
                \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN . "-count-down",
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
        // Add Inline editing
        $this->add_inline_editing_attributes("title", "basic");
        ?>
            <div <?php echo $this->get_render_attribute_string("wrapper"); ?>
            >
                <header class="<?php echo $settings["alignment"]; ?>">
                    <h5 <?php echo $this->get_render_attribute_string(
                        "title"
                    ); ?>>
                        <?php echo $settings["title"]; ?>
                    </h5>
                </header>
                <figure>
                    <div class="days">
                        <span ><?php echo $settings["days"]; ?></span>
                        <h6>Days</h6>
                    </div>
                    <div class="hours">
                        <span ><?php echo $settings["hours"]; ?></span>
                        <h6>Hours</h6>
                    </div>
                    <div class="minutes">
                        <span ><?php echo $settings["minutes"]; ?></span>
                        <h6>Minutes</h6>
                    </div>
                    <div class="seconds">
                        <span ><?php echo $settings["seconds"]; ?></span>
                        <h6>Seconds</h6>
                    </div>
                </figure>
            </div>
        <?php
    }

    protected function content_template()
    {
        ?>
        	<#
                view.addRenderAttribute(
                    'wrapper',
                    {
                        'class': [ '<?php echo \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN .
                            "-count-down"; ?>', settings.custom_class, settings.class ],
                        'role': settings.role,
                        'aria-label': settings.name,
                    }
                );
                view.addInlineEditingAttributes( 'title', 'basic' ); 
            #>
            <div {{{ view.getRenderAttributeString( 'wrapper' ) }}}>
                <header class="{{ settings.alignment }}">
                    <h5 {{{ view.getRenderAttributeString( 'title' ) }}} >{{ settings.title }}</h5>
                </header>
                <figure>
                    <div class="days">
                        <span>{{ settings.days }}</span>
                        <h6>Days</h6>
                    </div>
                    <div class="hours">
                        <span >{{ settings.hours }}</span>
                        <h6>Hours</h6>
                    </div>
                    <div class="minutes">
                        <span>{{ settings.minutes }}</span>
                        <h6>Minutes</h6>
                    </div>
                    <div class="seconds">
                        <span>{{ settings.seconds }}</span>
                        <h6>Seconds</h6>
                    </div>
                 </figure>
            </div>
        <?php
    }
}
