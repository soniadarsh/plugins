<?php

namespace InkLeadXplode\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * Elementor Hello World
 *
 * Elementor widget for hello world.
 *
 * @since 1.0.0
 */

class InkLeadXplode extends Widget_Base {

    /**
     * Retrieve the widget name.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'ink-leadxplode-element';
    }

    /**
     * Retrieve the widget title.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return __('LeadUp', 'leadcapture');
    }

    /**
     * Retrieve the widget icon.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'fa fa-envelope-open';
    }

    /**
     * Whether the reload preview is required.
     *
     * Used to determine whether the reload preview is required or not.
     *
     * @since 1.0.0
     * @access public
     *
     * @return bool Whether the reload preview is required.
     */
//public function is_reload_preview_required() {
//return true;
//}

    /**
     * Retrieve the list of categories the widget belongs to.
     *
     * Used to determine where to display the widget in the editor.
     *
     * Note that currently Elementor supports only one category.
     * When multiple categories passed, Elementor uses the first one.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return array Widget categories.
     */
    public function get_categories() {
        return ['lead-elements'];
    }

    /**
     * Retrieve the list of scripts the widget depended on.
     *
     * Used to set scripts dependencies required to run the widget.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return array Widget scripts dependencies.
     */
    public function get_script_depends() {
        return ['leadcapture-ink-lead'];
    }

    /**
     * Register the widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function _register_controls() {

        //===form_settings===//

        $this->start_controls_section(
                'form_settings', [
            'label' => __('Form Settings', 'leadcapture'),
            'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_control(
                'bg_color', [
            'label' => __('Form Background Color', 'leadcapture'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'scheme' => [
                'type' => \Elementor\Scheme_Color::get_type(),
                'value' => \Elementor\Scheme_Color::COLOR_1,
            ],
            'default' => '#565656',
            'selectors' => [
                '{{WRAPPER}} .inkleadsform-conatainer' => 'background: {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'form_border_stylings', [
            'label' => __(' Form Border Settings', 'leadcapture'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
                ]
        );

        $this->add_control(
                'form_border_right_color', [
            'label' => __('Border Right', 'leadcapture'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'scheme' => [
                'type' => \Elementor\Scheme_Color::get_type(),
                'value' => \Elementor\Scheme_Color::COLOR_4,
            ],
            'default' => '#777777',
            'selectors' => [
                '{{WRAPPER}} .inkleadsform-conatainer' => 'border-right-color: {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'form_border_left_color', [
            'label' => __('Border Left', 'leadcapture'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'scheme' => [
                'type' => \Elementor\Scheme_Color::get_type(),
                'value' => \Elementor\Scheme_Color::COLOR_4,
            ],
            'default' => '#777777',
            'selectors' => [
                '{{WRAPPER}} .inkleadsform-conatainer' => 'border-left-color: {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'form_border_top_color', [
            'label' => __('Border top', 'leadcapture'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'scheme' => [
                'type' => \Elementor\Scheme_Color::get_type(),
                'value' => \Elementor\Scheme_Color::COLOR_4,
            ],
            'default' => '#777777',
            'selectors' => [
                '{{WRAPPER}} .inkleadsform-conatainer' => 'border-top-color: {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'form_border_bottom_color', [
            'label' => __('Border Bottom', 'leadcapture'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'scheme' => [
                'type' => \Elementor\Scheme_Color::get_type(),
                'value' => \Elementor\Scheme_Color::COLOR_4,
            ],
            'default' => '#777777',
            'selectors' => [
                '{{WRAPPER}} .inkleadsform-conatainer' => 'border-bottom-color: {{VALUE}}',
            ],
                ]
        );

        $this->add_responsive_control(
                'form_border_width', [
            'label' => __('Form border Width', 'leadcapture'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .inkleadsform-conatainer' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}!important;',
            ],
                ]
        );

        $this->add_control(
                'main_heading_text_typo', [
            'label' => __('Main Heading', 'leadcapture'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
                ]
        );

        $this->add_control(
                'form_text_color', [
            'label' => __('Text color', 'leadcapture'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'scheme' => [
                'type' => \Elementor\Scheme_Color::get_type(),
                'value' => \Elementor\Scheme_Color::COLOR_2,
            ],
            'default' => '#fff',
            'selectors' => [
                '{{WRAPPER}}  .inkleadsform-conatainer h2.heading' => 'color: {{VALUE}};',
            ],
                ]
        );

        $this->add_control(
                'main_head_bg_color', [
            'label' => __('Background color', 'leadcapture'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'scheme' => [
                'type' => \Elementor\Scheme_Color::get_type(),
                'value' => \Elementor\Scheme_Color::COLOR_2,
            ],
            'default' => '#565656',
            'selectors' => [
                '{{WRAPPER}}  .inkleadsform-conatainer h2.heading' => 'background-color: {{VALUE}};',
            ],
                ]
        );

        $this->add_responsive_control(
                'main_heading_border_radius', [
            'label' => __('Border Radius', 'leadcapture'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .inkleadsform-conatainer h2.heading' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );


        $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(), [
            'name' => 'title_typography',
            'label' => __('Typography', 'leadcapture'),
            'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
            'selector' => '{{WRAPPER}} .inkleadsform-conatainer h2.heading',
            '(desktop){{WRAPPER}} .inkleadsform-conatainer h2.heading',
            '(tablet){{WRAPPER}} .inkleadsform-conatainer h2.heading',
            '(mobile){{WRAPPER}} .inkleadsform-conatainer h2.heading',
                ]
        );



        $this->add_responsive_control(
                'excrept_align', [
            'label' => __('Text Align', 'leadcapture'),
            'type' => Controls_Manager::CHOOSE,
            'options' => [
                'left' => [
                    'title' => __('Left', 'leadcapture'),
                    'icon' => 'fa fa-align-left',
                ],
                'center' => [
                    'title' => __('Center', 'leadcapture'),
                    'icon' => 'fa fa-align-center',
                ],
                'right' => [
                    'title' => __('Right', 'leadcapture'),
                    'icon' => 'fa fa-align-right',
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .inkleadsform-conatainer h2.heading' => 'text-align: {{VALUE}};',
            ],
                ]
        );

        $this->add_control(
                'main_heading_display', [
            'label' => __('Main Heading Display', 'leadcapture'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => __('Yes', 'leadcapture'),
            'label_off' => __('No', 'leadcapture'),
            'return_value' => 'yes',
            'default' => 'yes',
                ]
        );

        $this->add_control(
                'divider_stylings', [
            'label' => __('Divider Settings', 'leadcapture'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
                ]
        );


        $this->add_control(
                'content_divider_color', [
            'label' => __('Color', 'leadcapture'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'scheme' => [
                'type' => \Elementor\Scheme_Color::get_type(),
                'value' => \Elementor\Scheme_Color::COLOR_4,
            ],
            'default' => '#777777',
            'selectors' => [
                '{{WRAPPER}} .inkleadsform-conatainer h2.heading' => 'border-bottom-color: {{VALUE}}',
            ],
                ]
        );

        $this->add_responsive_control(
                'content_divider_height', [
            'label' => __('Height', 'leadcapture'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'default' => [
                'unit' => 'px',
            ],
            'range' => [
                'px' => [
                    'max' => 15,
                    'min' => 0,
                ],
            ],
            'devices' => ['desktop', 'tablet', 'mobile'],
            'desktop_default' => [
                'size' => 30,
                'unit' => 'px',
            ],
            'tablet_default' => [
                'size' => 20,
                'unit' => 'px',
            ],
            'mobile_default' => [
                'size' => 10,
                'unit' => 'px',
            ],
            'selectors' => [
                '{{WRAPPER}} .inkleadsform-conatainer h2.heading' => 'border-bottom-width: {{SIZE}}{{UNIT}};',
            ],
                ]
        );


        $this->add_control(
                'Form_advanced_settings', [
            'label' => __('Advanced Settings', 'leadcapture'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
                ]
        );

        $this->add_responsive_control(
                'form_border_radius', [
            'label' => __('Form Border Radius', 'leadcapture'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .inkleadsform-conatainer' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );



        $this->add_responsive_control(
                'main_heading_margin_control', [
            'label' => __('Main Heading Margin', 'leadcapture'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .inkleadsform-conatainer h2.heading' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );


        $this->add_responsive_control(
                'form_width_control', [
            'label' => __('Form Padding', 'leadcapture'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .inkleadsform-conatainer .sign_in_form' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_control(
                'Other_settings', [
            'label' => __('Other Settings', 'leadcapture'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
                ]
        );

        $this->add_control(
                'error_msg_color', [
            'label' => __('Error Message Color', 'leadcapture'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'scheme' => [
                'type' => \Elementor\Scheme_Color::get_type(),
                'value' => \Elementor\Scheme_Color::COLOR_4,
            ],
            'default' => '#e93656e3',
            'selectors' => [
                '{{WRAPPER}} label.error' => 'color: {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'captcha_txt_color', [
            'label' => __('Captcha Text Color', 'leadcapture'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'scheme' => [
                'type' => \Elementor\Scheme_Color::get_type(),
                'value' => \Elementor\Scheme_Color::COLOR_4,
            ],
            'default' => '#e93656e3',
            'selectors' => [
                '{{WRAPPER}} .captcha_color p#error_msg' => 'color: {{VALUE}}!important',
            ],
                ]
        );

        $this->add_responsive_control(
                'google_captcha_align', [
            'label' => __('Captcha Align', 'leadcapture'),
            'type' => Controls_Manager::CHOOSE,
            'options' => [
                '-webkit-left' => [
                    'title' => __('Chrome Left', 'leadcapture'),
                    'icon' => 'fa fa-align-left',
                ],
                '-moz-left' => [
                    'title' => __('Mozilla Left', 'leadcapture'),
                    'icon' => 'fa fa-align-left',
                ],
                '-webkit-center' => [
                    'title' => __('Chrome Center', 'leadcapture'),
                    'icon' => 'fa fa-align-center',
                ],
                '-moz-center' => [
                    'title' => __('Mozilla Center', 'leadcapture'),
                    'icon' => 'fa fa-align-center',
                ],
                
                '-webkit-right' => [
                    'title' => __('Chrome Right', 'leadcapture'),
                    'icon' => 'fa fa-align-right',
                ],
                '-moz-right' => [
                    'title' => __('Mozilla Right', 'leadcapture'),
                    'icon' => 'fa fa-align-right',
                ],

            ],
            'selectors' => [
                '{{WRAPPER}} .g-recaptcha, .captcha_color p#error_msg' => 'text-align: {{VALUE}};',
            ],
                ]
        );
        
        $this->end_controls_section();

        //===field_settings===//

        $this->start_controls_section(
                'field_settings', [
            'label' => __('Field Settings', 'leadcapture'),
            'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_control(
                'field_bg_color', [
            'label' => __('Text Fields Background Color', 'leadcapture'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'scheme' => [
                'type' => \Elementor\Scheme_Color::get_type(),
                'value' => \Elementor\Scheme_Color::COLOR_3,
            ],
            'default' => '#3A3A3A',
            'selectors' => [
                '{{WRAPPER}} .inkleadsform .sign_in_form ul.inkleadsul li textarea, .inkleadsform .sign_in_form ul.inkleadsul li input[type="text"], .inkleadsform .sign_in_form ul.inkleadsul li input[type="number"], .inkleadsform .sign_in_form ul.inkleadsul li input[type="email"]' => 'background: {{VALUE}}',
            ],
                ]
        );


        $this->add_control(
                'input_fields_styling', [
            'label' => __('Input Fields Styling', 'leadcapture'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
                ]
        );

        $this->add_control(
                'input_Text_color', [
            'label' => __('Text Color', 'leadcapture'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'scheme' => [
                'type' => \Elementor\Scheme_Color::get_type(),
                'value' => \Elementor\Scheme_Color::COLOR_2,
            ],
            'default' => '#fff',
            'selectors' => [
                '{{WRAPPER}} .inkleadsform .sign_in_form ul.inkleadsul li input[type="text"], .inkleadsform .sign_in_form ul.inkleadsul li input[type="text"]::placeholder, .inkleadsform .sign_in_form ul.inkleadsul li input[type="email"], .inkleadsform .sign_in_form ul.inkleadsul li input[type="email"]::placeholder, .inkleadsform .sign_in_form ul.inkleadsul li input[type="number"], .inkleadsform .sign_in_form ul.inkleadsul li input[type="number"]::placeholder, .inkleadsform .sign_in_form ul.inkleadsul li textarea, .inkleadsform .sign_in_form ul.inkleadsul li textarea::placeholder' => 'color: {{VALUE}}',
            ],
                ]
        );

        $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(), [
            'name' => 'input_text_typography',
            'label' => __('Text Typography', 'leadcapture'),
            'selector' => '{{WRAPPER}} .inkleadsform .sign_in_form ul.inkleadsul li input[type="text"], .inkleadsform .sign_in_form ul.inkleadsul li input[type="text"]::placeholder, .inkleadsform .sign_in_form ul.inkleadsul li input[type="email"], .inkleadsform .sign_in_form ul.inkleadsul li input[type="email"]::placeholder, .inkleadsform .sign_in_form ul.inkleadsul li input[type="number"], .inkleadsform .sign_in_form ul.inkleadsul li input[type="number"]::placeholder, .inkleadsform .sign_in_form ul.inkleadsul li textarea, .inkleadsform .sign_in_form ul.inkleadsul li textarea::placeholder',
            '(desktop){{WRAPPER}} .inkleadsform .sign_in_form ul.inkleadsul li input[type="text"], .inkleadsform .sign_in_form ul.inkleadsul li input[type="text"]::placeholder, .inkleadsform .sign_in_form ul.inkleadsul li input[type="email"], .inkleadsform .sign_in_form ul.inkleadsul li input[type="email"]::placeholder, .inkleadsform .sign_in_form ul.inkleadsul li input[type="number"], .inkleadsform .sign_in_form ul.inkleadsul li input[type="number"]::placeholder, .inkleadsform .sign_in_form ul.inkleadsul li textarea, .inkleadsform .sign_in_form ul.inkleadsul li textarea::placeholder',
            '(tablet){{WRAPPER}}  .inkleadsform .sign_in_form ul.inkleadsul li input[type="text"], .inkleadsform .sign_in_form ul.inkleadsul li input[type="text"]::placeholder, .inkleadsform .sign_in_form ul.inkleadsul li input[type="email"], .inkleadsform .sign_in_form ul.inkleadsul li input[type="email"]::placeholder, .inkleadsform .sign_in_form ul.inkleadsul li input[type="number"], .inkleadsform .sign_in_form ul.inkleadsul li input[type="number"]::placeholder, .inkleadsform .sign_in_form ul.inkleadsul li textarea, .inkleadsform .sign_in_form ul.inkleadsul li textarea::placeholder',
            '(mobile){{WRAPPER}} .inkleadsform .sign_in_form ul.inkleadsul li input[type="text"], .inkleadsform .sign_in_form ul.inkleadsul li input[type="text"]::placeholder, .inkleadsform .sign_in_form ul.inkleadsul li input[type="email"], .inkleadsform .sign_in_form ul.inkleadsul li input[type="email"]::placeholder, .inkleadsform .sign_in_form ul.inkleadsul li input[type="number"], .inkleadsform .sign_in_form ul.inkleadsul li input[type="number"]::placeholder, .inkleadsform .sign_in_form ul.inkleadsul li textarea, .inkleadsform .sign_in_form ul.inkleadsul li textarea::placeholder',
                ]
        );

        $this->add_control(
                'field_border_color', [
            'label' => __('Field Border Stylings', 'leadcapture'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
                ]
        );

        $this->add_control(
                'field_border_top_color', [
            'label' => __('Border top', 'leadcapture'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'scheme' => [
                'type' => \Elementor\Scheme_Color::get_type(),
                'value' => \Elementor\Scheme_Color::COLOR_4,
            ],
            'default' => '#777777',
            'selectors' => [
                '{{WRAPPER}} .inkleadsform-conatainer .inkleadsform .sign_in_form ul.inkleadsul li input[type="text"], .inkleadsform-conatainer .inkleadsform .sign_in_form ul.inkleadsul li input[type="text"]:focus, .inkleadsform-conatainer .inkleadsform .sign_in_form ul.inkleadsul li input[type="email"], .inkleadsform-conatainer .inkleadsform .sign_in_form ul.inkleadsul li input[type="email"]:focus, .inkleadsform-conatainer .inkleadsform .sign_in_form ul.inkleadsul li input[type="number"], .inkleadsform-conatainer .inkleadsform .sign_in_form ul.inkleadsul li input[type="number"]:focus, .inkleadsform-conatainer .inkleadsform .sign_in_form ul.inkleadsul li textarea, .inkleadsform-conatainer .inkleadsform .sign_in_form ul.inkleadsul li textarea:focus' => 'border-top-color: {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'field_border_right_color', [
            'label' => __('Border Right', 'leadcapture'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'scheme' => [
                'type' => \Elementor\Scheme_Color::get_type(),
                'value' => \Elementor\Scheme_Color::COLOR_4,
            ],
            'default' => '#777777',
            'selectors' => [
                '{{WRAPPER}} .inkleadsform-conatainer .inkleadsform .sign_in_form ul.inkleadsul li input[type="text"], .inkleadsform-conatainer .inkleadsform .sign_in_form ul.inkleadsul li input[type="text"]:focus, .inkleadsform-conatainer .inkleadsform .sign_in_form ul.inkleadsul li input[type="email"], .inkleadsform-conatainer .inkleadsform .sign_in_form ul.inkleadsul li input[type="email"]:focus, .inkleadsform-conatainer .inkleadsform .sign_in_form ul.inkleadsul li input[type="number"], .inkleadsform-conatainer .inkleadsform .sign_in_form ul.inkleadsul li input[type="number"]:focus, .inkleadsform-conatainer .inkleadsform .sign_in_form ul.inkleadsul li textarea, .inkleadsform-conatainer .inkleadsform .sign_in_form ul.inkleadsul li textarea:focus' => 'border-right-color: {{VALUE}}',
            ],
                ]
        );


        $this->add_control(
                'field_border_bottom_color', [
            'label' => __('Border Bottom', 'leadcapture'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'scheme' => [
                'type' => \Elementor\Scheme_Color::get_type(),
                'value' => \Elementor\Scheme_Color::COLOR_4,
            ],
            'default' => '#777777',
            'selectors' => [
                '{{WRAPPER}} .inkleadsform-conatainer .inkleadsform .sign_in_form ul.inkleadsul li input[type="text"], .inkleadsform-conatainer .inkleadsform .sign_in_form ul.inkleadsul li input[type="text"]:focus, .inkleadsform-conatainer .inkleadsform .sign_in_form ul.inkleadsul li input[type="email"], .inkleadsform-conatainer .inkleadsform .sign_in_form ul.inkleadsul li input[type="email"]:focus, .inkleadsform-conatainer .inkleadsform .sign_in_form ul.inkleadsul li input[type="number"], .inkleadsform-conatainer .inkleadsform .sign_in_form ul.inkleadsul li input[type="number"]:focus, .inkleadsform-conatainer .inkleadsform .sign_in_form ul.inkleadsul li textarea, .inkleadsform-conatainer .inkleadsform .sign_in_form ul.inkleadsul li textarea:focus' => 'border-bottom-color: {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'field_border_left_color', [
            'label' => __('Border Left', 'leadcapture'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'scheme' => [
                'type' => \Elementor\Scheme_Color::get_type(),
                'value' => \Elementor\Scheme_Color::COLOR_4,
            ],
            'default' => '#777777',
            'selectors' => [
                '{{WRAPPER}} .inkleadsform-conatainer .inkleadsform .sign_in_form ul.inkleadsul li input[type="text"], .inkleadsform-conatainer .inkleadsform .sign_in_form ul.inkleadsul li input[type="text"]:focus, .inkleadsform-conatainer .inkleadsform .sign_in_form ul.inkleadsul li input[type="email"], .inkleadsform-conatainer .inkleadsform .sign_in_form ul.inkleadsul li input[type="email"]:focus, .inkleadsform-conatainer .inkleadsform .sign_in_form ul.inkleadsul li input[type="number"], .inkleadsform-conatainer .inkleadsform .sign_in_form ul.inkleadsul li input[type="number"]:focus, .inkleadsform-conatainer .inkleadsform .sign_in_form ul.inkleadsul li textarea, .inkleadsform-conatainer .inkleadsform .sign_in_form ul.inkleadsul li textarea:focus' => 'border-left-color: {{VALUE}}',
            ],
                ]
        );

        $this->add_responsive_control(
                'field_border_width', [
            'label' => __('Field border Width', 'leadcapture'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .inkleadsform-conatainer .inkleadsform .sign_in_form ul.inkleadsul li input[type="text"], .inkleadsform-conatainer .inkleadsform .sign_in_form ul.inkleadsul li input[type="number"], .inkleadsform-conatainer .inkleadsform .sign_in_form ul.inkleadsul li input[type="email"], .inkleadsform-conatainer .inkleadsform .sign_in_form ul.inkleadsul li textarea, .inkleadsform-conatainer .inkleadsform .sign_in_form ul.inkleadsul li textarea:focus, .inkleadsform-conatainer .inkleadsform .sign_in_form ul.inkleadsul li input[type="text"]:focus, .inkleadsform-conatainer .inkleadsform .sign_in_form ul.inkleadsul li input[type="number"]:focus, .inkleadsform-conatainer .inkleadsform .sign_in_form ul.inkleadsul li input[type="email"]:focus' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}!important;',
            ],
                ]
        );

        $this->add_control(
                'advanced_settings', [
            'label' => __('Advanced Settings', 'leadcapture'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
                ]
        );
        $this->add_responsive_control(
                'input_border_radius', [
            'label' => __('Border Radius', 'leadcapture'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .inkleadsform .sign_in_form ul.inkleadsul li textarea, .inkleadsform .sign_in_form ul.inkleadsul li input[type="text"], .inkleadsform .sign_in_form ul.inkleadsul li input[type="number"], .inkleadsform .sign_in_form ul.inkleadsul li input[type="email"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_responsive_control(
                'field_padding_control', [
            'label' => __('Single Line Field Padding', 'leadcapture'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .inkleadsform-conatainer .inkleadsform .sign_in_form ul.inkleadsul li input[type="text"], .inkleadsform-conatainer .inkleadsform .sign_in_form ul.inkleadsul li input[type="number"], .inkleadsform-conatainer .inkleadsform .sign_in_form ul.inkleadsul li input[type="email"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}!important;',
            ],
                ]
        );


        $this->add_responsive_control(
                'multi_line_field_padding_control', [
            'label' => __('Multi Line Field Padding', 'leadcapture'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .inkleadsform-conatainer .inkleadsform .sign_in_form ul.inkleadsul li textarea' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}!important;',
            ],
                ]
        );

        $this->add_responsive_control(
                'field_box_height', [
            'label' => __('Field Height', 'leadcapture'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'default' => [
                'unit' => 'px',
            ],
            'range' => [
                'px' => [
                    'max' => 100,
                    'min' => 46
                ],
            ],
            'devices' => ['desktop', 'tablet', 'mobile'],
            'desktop_default' => [
                'size' => 30,
                'unit' => 'px',
            ],
            'tablet_default' => [
                'size' => 25,
                'unit' => 'px',
            ],
            'mobile_default' => [
                'size' => 20,
                'unit' => 'px',
            ],
            'selectors' => [
                '{{WRAPPER}} .inkleadsform-conatainer .inkleadsform .sign_in_form ul.inkleadsul li input[type="text"], .inkleadsform-conatainer .inkleadsform .sign_in_form ul.inkleadsul li input[type="number"], .inkleadsform-conatainer .inklead'
                . 'sform .sign_in_form ul.inkleadsul li input[type="email"]' => 'height: {{SIZE}}{{UNIT}};',
            ],
                ]
        );

        $this->add_responsive_control(
                'message_box_height', [
            'label' => __('Multi Line Field Height', 'leadcapture'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'default' => [
                'unit' => 'px',
            ],
            'range' => [
                'px' => [
                    'max' => 300,
                    'min' => 46
                ],
            ],
            'size_units' => ['px'],
            'default' => [
                'unit' => 'px',
            ],
            'devices' => ['desktop', 'tablet', 'mobile'],
            'desktop_default' => [
                'size' => 150,
                'unit' => 'px',
            ],
            'tablet_default' => [
                'size' => 120,
                'unit' => 'px',
            ],
            'mobile_default' => [
                'size' => 120,
                'unit' => 'px',
            ],
            'selectors' => [
                '{{WRAPPER}} .inkleadsform .sign_in_form ul.inkleadsul textarea' => 'height: {{SIZE}}{{UNIT}};',
            ],
                ]
        );


        $this->add_control(
                'field_width_settings', [
            'label' => __('Field Width Settings', 'leadcapture'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
                ]
        );

        $this->add_control(
                'default_text_field_width', [
            'label' => __('Text Field', 'appointment'),
            'type' => Controls_Manager::SELECT,
            'options' => [
                '20.000' => __('20%', 'appointment'),
                '25.000' => __('25%', 'appointment'),
                '30.000' => __('30%', 'appointment'),
                '33.333' => __('33%', 'appointment'),
                '40.000' => __('40%', 'appointment'),
                '50.000' => __('50%', 'appointment'),
                '60.000' => __('60%', 'appointment'),
                '66.666' => __('66%', 'appointment'),
                '70.000' => __('70%', 'appointment'),
                '75.000' => __('75%', 'appointment'),
                '80.000' => __('80%', 'appointment'),
                '90.000' => __('90%', 'appointment'),
                '100.0' => __('100%', 'appointment'),
            ],
            'default' => '100',
            'selectors' => [
                '{{WRAPPER}} ul.inkleadsul li.sl_text_name' => 'width: {{VALUE}}%;',
            ],
                ]
        );

        $this->add_control(
                'default_email_field_width', [
            'label' => __('Email Field', 'appointment'),
            'type' => Controls_Manager::SELECT,
            'options' => [
                '20.000' => __('20%', 'appointment'),
                '25.000' => __('25%', 'appointment'),
                '30.000' => __('30%', 'appointment'),
                '33.333' => __('33%', 'appointment'),
                '40.000' => __('40%', 'appointment'),
                '50.000' => __('50%', 'appointment'),
                '60.000' => __('60%', 'appointment'),
                '66.666' => __('66%', 'appointment'),
                '70.000' => __('70%', 'appointment'),
                '75.000' => __('75%', 'appointment'),
                '80.000' => __('80%', 'appointment'),
                '90.000' => __('90%', 'appointment'),
                '100.0' => __('100%', 'appointment'),
            ],
            'default' => '100',
            'selectors' => [
                '{{WRAPPER}} ul.inkleadsul li.sl_mail_address' => 'width: {{VALUE}}%;',
            ],
                ]
        );

        $this->add_control(
                '_default_number_field_width', [
            'label' => __('Number Field', 'appointment'),
            'type' => Controls_Manager::SELECT,
            'options' => [
                '20.000' => __('20%', 'appointment'),
                '25.000' => __('25%', 'appointment'),
                '30.000' => __('30%', 'appointment'),
                '33.333' => __('33%', 'appointment'),
                '40.000' => __('40%', 'appointment'),
                '50.000' => __('50%', 'appointment'),
                '60.000' => __('60%', 'appointment'),
                '66.666' => __('66%', 'appointment'),
                '70.000' => __('70%', 'appointment'),
                '75.000' => __('75%', 'appointment'),
                '80.000' => __('80%', 'appointment'),
                '90.000' => __('90%', 'appointment'),
                '100.0' => __('100%', 'appointment'),
            ],
            'default' => '100',
            'selectors' => [
                '{{WRAPPER}} ul.inkleadsul li.num_field' => 'width: {{VALUE}}%;',
            ],
                ]
        );

        $this->add_control(
                'default_messsage_field_width', [
            'label' => __('Message Field', 'appointment'),
            'type' => Controls_Manager::SELECT,
            'options' => [
                '20.000' => __('20%', 'appointment'),
                '25.000' => __('25%', 'appointment'),
                '30.000' => __('30%', 'appointment'),
                '33.333' => __('33%', 'appointment'),
                '40.000' => __('40%', 'appointment'),
                '50.000' => __('50%', 'appointment'),
                '60.000' => __('60%', 'appointment'),
                '66.666' => __('66%', 'appointment'),
                '70.000' => __('70%', 'appointment'),
                '75.000' => __('75%', 'appointment'),
                '80.000' => __('80%', 'appointment'),
                '90.000' => __('90%', 'appointment'),
                '100.0' => __('100%', 'appointment'),
            ],
            'default' => '100',
            'selectors' => [
                '{{WRAPPER}} ul.inkleadsul li.ml_textarea' => 'width: {{VALUE}}%;',
            ],
                ]
        );

        $this->add_control(
                'singleline_field_width', [
            'label' => __('Single Line Field', 'appointment'),
            'type' => Controls_Manager::SELECT,
            'options' => [
                '20.000' => __('20%', 'appointment'),
                '25.000' => __('25%', 'appointment'),
                '30.000' => __('30%', 'appointment'),
                '33.333' => __('33%', 'appointment'),
                '40.000' => __('40%', 'appointment'),
                '50.000' => __('50%', 'appointment'),
                '60.000' => __('60%', 'appointment'),
                '66.666' => __('66%', 'appointment'),
                '70.000' => __('70%', 'appointment'),
                '75.000' => __('75%', 'appointment'),
                '80.000' => __('80%', 'appointment'),
                '90.000' => __('90%', 'appointment'),
                '100.0' => __('100%', 'appointment'),
            ],
            'default' => '100',
            'selectors' => [
                '{{WRAPPER}} ul.inkleadsul li.add_sl_text_name' => 'width: {{VALUE}}%;',
            ],
                ]
        );

        $this->add_control(
                'add_number_field', [
            'label' => __('Contact Field', 'appointment'),
            'type' => Controls_Manager::SELECT,
            'options' => [
                '20.000' => __('20%', 'appointment'),
                '25.000' => __('25%', 'appointment'),
                '30.000' => __('30%', 'appointment'),
                '33.333' => __('33%', 'appointment'),
                '40.000' => __('40%', 'appointment'),
                '50.000' => __('50%', 'appointment'),
                '60.000' => __('60%', 'appointment'),
                '66.666' => __('66%', 'appointment'),
                '70.000' => __('70%', 'appointment'),
                '75.000' => __('75%', 'appointment'),
                '80.000' => __('80%', 'appointment'),
                '90.000' => __('90%', 'appointment'),
                '100.0' => __('100%', 'appointment'),
            ],
            'default' => '100',
            'selectors' => [
                '{{WRAPPER}} ul.inkleadsul li.add_num_field' => 'width: {{VALUE}}%;',
            ],
                ]
        );


        $this->add_control(
                'column_gap', [
            'label' => __('Field Columns Gap', 'leadcapture'),
            'type' => Controls_Manager::SLIDER,
            'default' => [
                'size' => 10,
            ],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 60,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .inkleadsform-conatainer .inkleadsform ul.inkleadsul li' => 'padding-right: calc( {{SIZE}}{{UNIT}}/2 ); padding-left: calc( {{SIZE}}{{UNIT}}/2 );',
                '{{WRAPPER}} .inkleadsform-conatainer .inkleadsform ul.inkleadsul' => 'margin-left: calc( -{{SIZE}}{{UNIT}}/2 ); margin-right: calc( -{{SIZE}}{{UNIT}}/2 );',
            ],
                ]
        );

        $this->add_control(
                'row_gap', [
            'label' => __('Field Rows Gap', 'leadcapture'),
            'type' => Controls_Manager::SLIDER,
            'default' => [
                'size' => 10,
            ],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 60,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .inkleadsform-conatainer .inkleadsform ul.inkleadsul li' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .inkleadsform-conatainer .inkleadsform ul.inkleadsul' => 'margin-bottom: -{{SIZE}}{{UNIT}};',
            ],
                ]
        );

        $this->end_controls_section();




        //========Button-settings=======//


        $this->start_controls_section(
                'btn_section_style', [
            'label' => __('Button Settings', 'leadcapture'),
            'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_control(
                'button_stylings ', [
            'label' => __('Button Stylings', 'leadcapture'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
                ]
        );

        $this->start_controls_tabs('eael_cta_button_tabs');


        // Normal State Tab
        $this->start_controls_tab('btn_normal', ['label' => esc_html__('Normal', 'essential-addons-elementor')]);



        $this->add_control(
                'submit_btn_text_color', [
            'label' => __('Text Color', 'leadcapture'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'scheme' => [
                'type' => \Elementor\Scheme_Color::get_type(),
                'value' => \Elementor\Scheme_Color::COLOR_4,
            ],
            'default' => '#fff',
            'selectors' => [
                '{{WRAPPER}} .inkleadsform-conatainer .inkleadsform div.btn_btn_submit div.inkleadsbutton input.btnsubmit' => 'color: {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'button_bg_color', [
            'label' => __('Background Color', 'leadcapture'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'scheme' => [
                'type' => \Elementor\Scheme_Color::get_type(),
                'value' => \Elementor\Scheme_Color::COLOR_1,
            ],
            'default' => '#C8933F',
            'selectors' => [
                '{{WRAPPER}} .inkleadsform-conatainer .inkleadsform div.btn_btn_submit div.inkleadsbutton input.btnsubmit ' => 'background: {{VALUE}}',
            ],
                ]
        );
        $this->add_control(
                'button_border_color', [
            'label' => __('Border Color', 'leadcapture'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'scheme' => [
                'type' => \Elementor\Scheme_Color::get_type(),
                'value' => \Elementor\Scheme_Color::COLOR_2,
            ],
            'default' => '#E0B064',
            'selectors' => [
                '{{WRAPPER}} .inkleadsform-conatainer .inkleadsform div.btn_btn_submit div.inkleadsbutton input.btnsubmit' => 'border-color: {{VALUE}}',
            ],
                ]
        );



        $this->end_controls_tab();

        // Hover State Tab
        $this->start_controls_tab('eael_cta_btn_hover', ['label' => esc_html__('Hover', 'essential-addons-elementor')]);



        $this->add_control(
                'submit_btn_hover_text_color', [
            'label' => __('Hover Text Color', 'leadcapture'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'scheme' => [
                'type' => \Elementor\Scheme_Color::get_type(),
                'value' => \Elementor\Scheme_Color::COLOR_4,
            ],
            'default' => '#fff',
            'selectors' => [
                '{{WRAPPER}} .inkleadsform-conatainer .inkleadsform div.btn_btn_submit div.inkleadsbutton input.btnsubmit:hover' => 'color: {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'button_hover_bg_color', [
            'label' => __('Hover Background Color', 'leadcapture'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'scheme' => [
                'type' => \Elementor\Scheme_Color::get_type(),
                'value' => \Elementor\Scheme_Color::COLOR_2,
            ],
            'default' => '#E0B064',
            'selectors' => [
                '{{WRAPPER}} .inkleadsform-conatainer .inkleadsform div.btn_btn_submit div.inkleadsbutton input.btnsubmit:hover' => 'background: {{VALUE}}',
            ],
                ]
        );
        $this->add_control(
                'button_border_hover_color', [
            'label' => __('Border Hover Color', 'leadcapture'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'scheme' => [
                'type' => \Elementor\Scheme_Color::get_type(),
                'value' => \Elementor\Scheme_Color::COLOR_2,
            ],
            'default' => '#E0B064',
            'selectors' => [
                '{{WRAPPER}} .inkleadsform-conatainer .inkleadsform div.btn_btn_submit div.inkleadsbutton input.btnsubmit:hover' => 'border-color: {{VALUE}}',
            ],
                ]
        );


        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
                'button_border_display', [
            'label' => __('Show Border', 'leadcapture'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => __('Yes', 'leadcapture'),
            'label_off' => __('No', 'leadcapture'),
            'return_value' => 'yes',
            'default' => 'yes',
                ]
        );


        $this->add_group_control(
                Group_Control_Box_Shadow::get_type(), [
            'name' => 'button_box_shadow',
            'label' => __('Box Shadow', 'leadcapture'),
            'selector' => '{{WRAPPER}} .inkleadsform .sign_in_form div.btn_btn_submit div.inkleadsbutton input[type="submit"]',
            'separator' => 'before'
                ]
        );


        $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(), [
            'name' => 'submit_btn_typography',
            'label' => __('Typography', 'leadcapture'),
            'selector' => '{{WRAPPER}} .inkleadsform-conatainer .inkleadsform div.btn_btn_submit div.inkleadsbutton input.btnsubmit',
                ]
        );

        $this->add_responsive_control(
                'submit_btn_align', [
            'label' => __('Button Align', 'leadcapture'),
            'type' => Controls_Manager::CHOOSE,
            'options' => [
                'left' => [
                    'title' => __('Left', 'leadcapture'),
                    'icon' => 'fa fa-align-left',
                ],
                'center' => [
                    'title' => __('Center', 'leadcapture'),
                    'icon' => 'fa fa-align-center',
                ],
                'right' => [
                    'title' => __('Right', 'leadcapture'),
                    'icon' => 'fa fa-align-right',
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .inkleadsform-conatainer .inkleadsform div.btn_btn_submit div.inkleadsbutton input.btnsubmit' => 'float: {{VALUE}};',
            ],
                ]
        );


        $this->add_control(
                'button_advanced_settings ', [
            'label' => __('Advanced Settings', 'leadcapture'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
                ]
        );

        $this->add_responsive_control(
                'submit_btn_height', [
            'label' => __('Height', 'leadcapture'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'default' => [
                'unit' => 'px',
            ],
            'range' => [
                'px' => [
                    'min' => 46,
                    'max' => 100
                ]
            ],
            'devices' => ['desktop', 'tablet', 'mobile'],
            'desktop_default' => [
                'size' => 46,
                'unit' => 'px',
            ],
            'tablet_default' => [
                'size' => 40,
                'unit' => 'px',
            ],
            'mobile_default' => [
                'size' => 35,
                'unit' => 'px',
            ],
            'selectors' => [
                '{{WRAPPER}} .inkleadsform-conatainer .inkleadsform div.btn_btn_submit div.inkleadsbutton input.btnsubmit' => 'height: {{SIZE}}{{UNIT}};',
            ],
                ]
        );

        $this->add_responsive_control(
                'submit_btn_width12', [
            'label' => __('Width', 'leadcapture'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['%'],
            'default' => [
                'unit' => '%',
            ],
            'range' => [
                '%' => [
                    'max' => 100,
                    'min' => 10
                ],
            ],
            'devices' => ['desktop', 'tablet', 'mobile'],
            'desktop_default' => [
                'size' => 100,
                'unit' => '%',
            ],
            'tablet_default' => [
                'size' => 100,
                'unit' => '%',
            ],
            'mobile_default' => [
                'size' => 100,
                'unit' => '%',
            ],
            'selectors' => [
                '{{WRAPPER}} .inkleadsform-conatainer .inkleadsform div.btn_btn_submit div.inkleadsbutton input.btnsubmit' => 'width: {{SIZE}}{{UNIT}};',
            ],
                ]
        );

//        $this->add_control(
//                'drop_cap_border_radius', [
//            'label' => __('Border Radius', 'leadcapture'),
//            'type' => Controls_Manager::SLIDER,
//            'size_units' => ['%', 'px'],
//            'default' => [
//                'unit' => 'px',
//            ],
//            'range' => [
//                '%' => [
//                    'max' => 50,
//                ],
//                'px' => [
//                    'max' => 50,
//                ]
//            ],
//            'selectors' => [
//                '{{WRAPPER}} .inkleadsform-conatainer .inkleadsform ul.btn_btn_submit div.inkleadsbutton input.btnsubmit' => 'border-radius: {{SIZE}}{{UNIT}};',
//            ],
//                ]
//        );

        $this->add_responsive_control(
                'drop_cap_border_radius', [
            'label' => __('Border Radius', 'appointment'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .inkleadsform-conatainer .inkleadsform div.btn_btn_submit div.inkleadsbutton input.btnsubmit' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_responsive_control(
                'submit_btn_margin', [
            'label' => __('Button Margins', 'leadcapture'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .inkleadsform-conatainer .inkleadsform div.btn_btn_submit' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );




        $this->end_controls_section();



        //===custom_field_settings===//

        $this->start_controls_section(
                'custom_field_settings', [
            'label' => __('Custom Field Settings', 'leadcapture'),
            'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_responsive_control(
                'text_field_label_input_typo', [
            'label' => __('Single Line Field', 'leadcapture'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
                ]
        );


        $this->add_control(
                'text_field_label_color', [
            'label' => __('Text Color', 'leadcapture'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'scheme' => [
                'type' => \Elementor\Scheme_Color::get_type(),
                'value' => \Elementor\Scheme_Color::COLOR_2,
            ],
            'default' => '#fff',
            'selectors' => [
                '{{WRAPPER}} .inkleadsform-conatainer .inkleadsform .sign_in_form .inkleadsul h4.single_line_text_field' => 'color: {{VALUE}}',
            ],
                ]
        );


        $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(), [
            'name' => 'ti_typography_label',
            'label' => __('Typography', 'leadcapture'),
            'selector' => '{{WRAPPER}} .inkleadsform-conatainer .inkleadsform .sign_in_form .inkleadsul h4.single_line_text_field',
            '(desktop){{WRAPPER}} .inkleadsform-conatainer .inkleadsform .sign_in_form .inkleadsul h4.single_line_text_field',
            '(tablet){{WRAPPER}}  .inkleadsform-conatainer .inkleadsform .sign_in_form .inkleadsul h4.single_line_text_field',
            '(mobile){{WRAPPER}} .inkleadsform-conatainer .inkleadsform .sign_in_form .inkleadsul h4.single_line_text_field',
                ]
        );

        $this->add_responsive_control(
                'text_field_label_align', [
            'label' => __('Text Align', 'leadcapture'),
            'type' => Controls_Manager::CHOOSE,
            'options' => [
                'left' => [
                    'title' => __('Left', 'leadcapture'),
                    'icon' => 'fa fa-align-left',
                ],
                'center' => [
                    'title' => __('Center', 'leadcapture'),
                    'icon' => 'fa fa-align-center',
                ],
                'right' => [
                    'title' => __('Right', 'leadcapture'),
                    'icon' => 'fa fa-align-right',
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .inkleadsform-conatainer .inkleadsform .sign_in_form .inkleadsul h4.single_line_text_field' => 'text-align: {{VALUE}};',
            ],
                ]
        );



        $this->add_responsive_control(
                'textarea_field_label_input_typo', [
            'label' => __('Multi Line Field', 'leadcapture'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
                ]
        );


        $this->add_control(
                'textarea_field_label_color', [
            'label' => __('Text Color', 'leadcapture'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'scheme' => [
                'type' => \Elementor\Scheme_Color::get_type(),
                'value' => \Elementor\Scheme_Color::COLOR_2,
            ],
            'default' => '#fff',
            'selectors' => [
                '{{WRAPPER}} .inkleadsform-conatainer .inkleadsform .sign_in_form .inkleadsul h4.multi_line_textarea_field' => 'color: {{VALUE}}',
            ],
                ]
        );


        $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(), [
            'name' => 'ti_textarea_typography_label',
            'label' => __('Typography', 'leadcapture'),
            'selector' => '{{WRAPPER}} .inkleadsform-conatainer .inkleadsform .sign_in_form .inkleadsul h4.multi_line_textarea_field',
            '(desktop){{WRAPPER}} .inkleadsform-conatainer .inkleadsform .sign_in_form .inkleadsul h4.multi_line_textarea_field',
            '(tablet){{WRAPPER}}  .inkleadsform-conatainer .inkleadsform .sign_in_form .inkleadsul h4.multi_line_textarea_field',
            '(mobile){{WRAPPER}} .inkleadsform-conatainer .inkleadsform .sign_in_form .inkleadsul h4.multi_line_textarea_field',
                ]
        );

        $this->add_responsive_control(
                'textarea_field_label_align', [
            'label' => __('Text Align', 'leadcapture'),
            'type' => Controls_Manager::CHOOSE,
            'options' => [
                'left' => [
                    'title' => __('Left', 'leadcapture'),
                    'icon' => 'fa fa-align-left',
                ],
                'center' => [
                    'title' => __('Center', 'leadcapture'),
                    'icon' => 'fa fa-align-center',
                ],
                'right' => [
                    'title' => __('Right', 'leadcapture'),
                    'icon' => 'fa fa-align-right',
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .inkleadsform-conatainer .inkleadsform .sign_in_form .inkleadsul h4.multi_line_textarea_field' => 'text-align: {{VALUE}};',
            ],
                ]
        );



        $this->add_responsive_control(
                'number_field_label_input_typo', [
            'label' => __('Number Field', 'leadcapture'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
                ]
        );


        $this->add_control(
                'number_field_label_color', [
            'label' => __('Text Color', 'leadcapture'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'scheme' => [
                'type' => \Elementor\Scheme_Color::get_type(),
                'value' => \Elementor\Scheme_Color::COLOR_2,
            ],
            'default' => '#fff',
            'selectors' => [
                '{{WRAPPER}} .inkleadsform-conatainer .inkleadsform .sign_in_form .inkleadsul h4.label_num_field' => 'color: {{VALUE}}',
            ],
                ]
        );

        $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(), [
            'name' => 'ti_number_typography_label',
            'label' => __('Typography', 'leadcapture'),
            'selector' => '{{WRAPPER}} h4.label_num_field',
            '(desktop){{WRAPPER}} .inkleadsform-conatainer .inkleadsform .sign_in_form .inkleadsul h4.label_num_field',
            '(tablet){{WRAPPER}}  .inkleadsform-conatainer .inkleadsform .sign_in_form .inkleadsul h4.label_num_field',
            '(mobile){{WRAPPER}} .inkleadsform-conatainer .inkleadsform .sign_in_form .inkleadsul h4.label_num_field',
                ]
        );

        $this->add_responsive_control(
                'number_field_label_align', [
            'label' => __('Label Align', 'leadcapture'),
            'type' => Controls_Manager::CHOOSE,
            'options' => [
                'left' => [
                    'title' => __('Left', 'leadcapture'),
                    'icon' => 'fa fa-align-left',
                ],
                'center' => [
                    'title' => __('Center', 'leadcapture'),
                    'icon' => 'fa fa-align-center',
                ],
                'right' => [
                    'title' => __('Right', 'leadcapture'),
                    'icon' => 'fa fa-align-right',
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .inkleadsform-conatainer .inkleadsform .sign_in_form .inkleadsul h4.label_num_field' => 'text-align: {{VALUE}};',
            ],
                ]
        );


        $this->add_control(
                'checkbox_text_field', [
            'label' => __('Check box Field', 'leadcapture'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
                ]
        );

        $this->add_control(
                'chkbox_heading_color', [
            'label' => __('Heading Color', 'leadcapture'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'scheme' => [
                'type' => \Elementor\Scheme_Color::get_type(),
                'value' => \Elementor\Scheme_Color::COLOR_2,
            ],
            'default' => '#fff',
            'selectors' => [
                '{{WRAPPER}} .inkleadsform-conatainer .inkleadsform .sign_in_form ul.inklead_btn_box span.lead_checkheading' => 'color: {{VALUE}}',
            ],
                ]
        );

        $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(), [
            'name' => 'chkbox_heading_typography',
            'label' => __('Heading Typography', 'leadcapture'),
            'selector' => '{{WRAPPER}}  .inkleadsform-conatainer .inkleadsform .sign_in_form ul.inklead_btn_box span.lead_checkheading',
            '(desktop){{WRAPPER}} .inkleadsform-conatainer .inkleadsform .sign_in_form ul.inklead_btn_box span.lead_checkheading',
            '(tablet){{WRAPPER}} .inkleadsform-conatainer .inkleadsform .sign_in_form ul.inklead_btn_box span.lead_checkheading',
            '(mobile){{WRAPPER}} .inkleadsform-conatainer .inkleadsform .sign_in_form ul.inklead_btn_box span.lead_checkheading',
                ]
        );

        $this->add_responsive_control(
                'checkbox_align', [
            'label' => __('Text Align', 'leadcapture'),
            'type' => Controls_Manager::CHOOSE,
            'options' => [
                'left' => [
                    'title' => __('Left', 'leadcapture'),
                    'icon' => 'fa fa-align-left',
                ],
                'center' => [
                    'title' => __('Center', 'leadcapture'),
                    'icon' => 'fa fa-align-center',
                ],
                'right' => [
                    'title' => __('Right', 'leadcapture'),
                    'icon' => 'fa fa-align-right',
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .inkleadsform-conatainer .inkleadsform .sign_in_form ul.inklead_btn_box span.lead_checkheading' => 'text-align: {{VALUE}};',
            ],
                ]
        );

        $this->add_control(
                'chkbox_option_color', [
            'label' => __('Option Color', 'leadcapture'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'scheme' => [
                'type' => \Elementor\Scheme_Color::get_type(),
                'value' => \Elementor\Scheme_Color::COLOR_2,
            ],
            'default' => '#fff',
            'selectors' => [
                '{{WRAPPER}} .inkleadsform-conatainer .inkleadsform .sign_in_form ul.inklead_btn_box li div.checkname' => 'color: {{VALUE}}',
            ],
                ]
        );

        $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(), [
            'name' => 'chkbox_option_typography',
            'label' => __('Option Typography', 'leadcapture'),
            'selector' => '{{WRAPPER}} .inkleadsform-conatainer .inkleadsform .sign_in_form ul.inklead_btn_box li div.checkname',
            '(desktop){{WRAPPER}} .inkleadsform-conatainer .inkleadsform .sign_in_form ul.inklead_btn_box li div.checkname',
            '(tablet){{WRAPPER}} .inkleadsform-conatainer .inkleadsform .sign_in_form ul.inklead_btn_box li div.checkname',
            '(mobile){{WRAPPER}} .inkleadsform-conatainer .inkleadsform .sign_in_form ul.inklead_btn_box li div.checkname',
                ]
        );



        $this->add_control(
                'chkbox_bg_color', [
            'label' => __('Background Color', 'leadcapture'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'scheme' => [
                'type' => \Elementor\Scheme_Color::get_type(),
                'value' => \Elementor\Scheme_Color::COLOR_3,
            ],
            'default' => '#3A3A3A',
            'selectors' => [
                '{{WRAPPER}} .leads-check-div input:checked ~ .checkmark' => 'background-color: {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'chk_option_display', [
            'label' => __('Display Options Vertically', 'leadcapture'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => __('Yes', 'leadcapture'),
            'label_off' => __('No', 'leadcapture'),
            'return_value' => 'yes',
            'default' => 'yes',
                ]
        );

        $this->add_responsive_control(
                'chkbox_heading_margin_control', [
            'label' => __('Heading Margin', 'leadcapture'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} ul.inklead_btn_box div.checkpanel' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );


        $this->add_responsive_control(
                'chkbox_option_margins_control', [
            'label' => __('Options Margin', 'leadcapture'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} ul.inklead_btn_box .leads-check-div' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_control(
                'radiobox_text_field', [
            'label' => __('Radio button Field', 'leadcapture'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
                ]
        );


        $this->add_control(
                'radio_heading_color', [
            'label' => __('Heading Color', 'leadcapture'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'scheme' => [
                'type' => \Elementor\Scheme_Color::get_type(),
                'value' => \Elementor\Scheme_Color::COLOR_2,
            ],
            'default' => '#fff',
            'selectors' => [
                '{{WRAPPER}} .inkleadsform-conatainer .inkleadsform .sign_in_form ul.inklead_btn_box span.lead_radioheading' => 'color: {{VALUE}}',
            ],
                ]
        );

        $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(), [
            'name' => 'radio_heading_typography',
            'label' => __('Heading Typography', 'leadcapture'),
            'selector' => '{{WRAPPER}}  .inkleadsform-conatainer .inkleadsform .sign_in_form ul.inklead_btn_box span.lead_radioheading',
            '(desktop){{WRAPPER}} .inkleadsform-conatainer .inkleadsform .sign_in_form ul.inklead_btn_box span.lead_radioheading',
            '(tablet){{WRAPPER}} .inkleadsform-conatainer .inkleadsform .sign_in_form ul.inklead_btn_box span.lead_radioheading',
            '(mobile){{WRAPPER}} .inkleadsform-conatainer .inkleadsform .sign_in_form ul.inklead_btn_box span.lead_radioheading',
                ]
        );


        $this->add_responsive_control(
                'radio_align', [
            'label' => __('Label Align', 'leadcapture'),
            'type' => Controls_Manager::CHOOSE,
            'options' => [
                'left' => [
                    'title' => __('Left', 'leadcapture'),
                    'icon' => 'fa fa-align-left',
                ],
                'center' => [
                    'title' => __('Center', 'leadcapture'),
                    'icon' => 'fa fa-align-center',
                ],
                'right' => [
                    'title' => __('Right', 'leadcapture'),
                    'icon' => 'fa fa-align-right',
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .inkleadsform-conatainer .inkleadsform .sign_in_form ul.inklead_btn_box span.lead_radioheading' => 'text-align: {{VALUE}};',
            ],
                ]
        );

        $this->add_control(
                'radio_option_color', [
            'label' => __('Option Color', 'leadcapture'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'scheme' => [
                'type' => \Elementor\Scheme_Color::get_type(),
                'value' => \Elementor\Scheme_Color::COLOR_2,
            ],
            'default' => '#fff',
            'selectors' => [
                '{{WRAPPER}} .inkleadsform-conatainer .inkleadsform .sign_in_form ul.inklead_btn_box li div.radioname' => 'color: {{VALUE}}',
            ],
                ]
        );



        $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(), [
            'name' => 'radio_option_typography',
            'label' => __('Option Typography', 'leadcapture'),
            'selector' => '{{WRAPPER}} .inkleadsform-conatainer .inkleadsform .sign_in_form ul.inklead_btn_box li div.radioname',
            '(desktop){{WRAPPER}} .inkleadsform-conatainer .inkleadsform .sign_in_form ul.inklead_btn_box li div.radioname',
            '(tablet){{WRAPPER}} .inkleadsform-conatainer .inkleadsform .sign_in_form ul.inklead_btn_box li div.radioname',
            '(mobile){{WRAPPER}} .inkleadsform-conatainer .inkleadsform .sign_in_form ul.inklead_btn_box li div.radioname',
                ]
        );

        $this->add_control(
                'radiobox_bg_color', [
            'label' => __('Background Color', 'leadcapture'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'scheme' => [
                'type' => \Elementor\Scheme_Color::get_type(),
                'value' => \Elementor\Scheme_Color::COLOR_3,
            ],
            'default' => '#3A3A3A',
            'selectors' => [
                '{{WRAPPER}} .leads-radio-div input:checked ~ .radiomark' => 'background-color: {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'radio_option_display', [
            'label' => __('Display Options Vertically ', 'leadcapture'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => __('Yes', 'leadcapture'),
            'label_off' => __('No', 'leadcapture'),
            'return_value' => 'yes',
            'default' => 'yes',
                ]
        );

        $this->add_responsive_control(
                'radiobtn_heading_margin_control', [
            'label' => __('Heading Margin', 'leadcapture'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} ul.inklead_btn_box div.radiopanel' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_responsive_control(
                'radiobtn_options_margin_control', [
            'label' => __('Options Margin', 'leadcapture'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} ul.inklead_btn_box .leads-radio-div' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );



        $this->add_responsive_control(
                'label_display', [
            'label' => __('Show/Hide Headings For', 'leadcapture'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
                ]
        );

        $this->add_control(
                'text_field_label_display', [
            'label' => __('Single Line Field', 'leadcapture'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => __('Yes', 'leadcapture'),
            'label_off' => __('No', 'leadcapture'),
            'return_value' => 'yes',
            'default' => 'yes',
                ]
        );

        $this->add_control(
                'textarea_field_label_display', [
            'label' => __('Multi Line Field', 'leadcapture'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => __('Yes', 'leadcapture'),
            'label_off' => __('No', 'leadcapture'),
            'return_value' => 'yes',
            'default' => 'yes',
                ]
        );

        $this->add_control(
                'number_field_label_display', [
            'label' => __('Number Field', 'leadcapture'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => __('Yes', 'leadcapture'),
            'label_off' => __('No', 'leadcapture'),
            'return_value' => 'yes',
            'default' => 'yes',
                ]
        );
        $this->end_controls_section();
    }

    /**
     * Render the widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function render() {

        $shortcode = $this->get_settings();
        $shortcode = do_shortcode('[ink-leadcapture]');
        ?>
        <div class="leadcapture-shortcode"><?php echo $shortcode; ?></div>
        <?php
        $settings = $this->get_settings_for_display();
        if ('yes' === $settings['main_heading_display']) {
            echo '<style>.inkleadheading h2.heading {
   display: block;}</style>';
        } else {
            echo '<style>.inkleadheading h2.heading {
   display: none;}
   </style>';
        }

        $settings = $this->get_settings_for_display();
        if ('yes' === $settings['chk_option_display']) {
            echo '<style>.leads-check-div {
   display: block;}</style>';
        } else {
            echo '<style>.leads-check-div {
   display: inline;}</style>';
        }

        $settings = $this->get_settings_for_display();
        if ('yes' === $settings['radio_option_display']) {
            echo '<style>.leads-radio-div {
   display: block;}</style>';
        } else {
            echo '<style>.leads-radio-div {
   display: inline;}</style>';
        }

        $settings = $this->get_settings_for_display();
        if ('yes' === $settings['text_field_label_display']) {
            echo '<style>h4.single_line_text_field {
   display: block;}</style>';
        } else {
            echo '<style>h4.single_line_text_field {
   display: none;}
   
   </style>';
        }

        $settings = $this->get_settings_for_display();
        if ('yes' === $settings['textarea_field_label_display']) {
            echo '<style>h4.multi_line_textarea_field {
   display: block;}</style>';
        } else {
            echo '<style>h4.multi_line_textarea_field {
   display: none;}
   
   </style>';
        }

        $settings = $this->get_settings_for_display();
        if ('yes' === $settings['number_field_label_display']) {
            echo '<style>h4.label_num_field {
   display: block;}</style>';
        } else {
            echo '<style>h4.label_num_field {
   display: none;}
   </style>';
        }

        $settings = $this->get_settings_for_display();
        if ('yes' === $settings['button_border_display']) {
            echo '<style>.inkleadsform .sign_in_form div.inkleadsbutton input[type="submit"] {
   border: 2px solid #bcbcbc;}</style>';
        } else {
            echo '<style>.inkleadsform .sign_in_form div.inkleadsbutton input[type="submit"] {
   border: none !important;}</style>';
        }
    }

    /**
     * Render the widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function _content_template() {
        
    }

}
