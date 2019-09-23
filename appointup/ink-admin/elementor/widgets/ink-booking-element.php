<?php

namespace InkAppointment\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Utils;
use Elementor\Group_Control_Box_Shadow;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * Elementor Hello World
 *
 * Elementor widget for hello world.
 *
 * @since 1.0.0
 */

class InkAppointmentElement extends Widget_Base {

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
        return 'ink-booking-element';
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
        return __('AppointUp', 'appointment');
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
        return 'fa fa-briefcase';
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
        return ['booking-elements'];
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
        return ['elementor-ink-appointment'];
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



        //=============Background section start=================//

        $this->start_controls_section(
                'form_section_style', [
            'label' => __('Form Settings', 'appointment'),
            'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_control(
                'form_style_section', [
            'label' => __('Form Background Color', 'appointment'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'scheme' => [
                'type' => \Elementor\Scheme_Color::get_type(),
                'value' => \Elementor\Scheme_Color::COLOR_1,
            ],
            'default' => '#565656',
            'selectors' => [
                '{{WRAPPER}} .ink-container' => 'background: {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'form_border_settings', [
            'label' => __('Form Border Settings', 'appointment'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
                ]
        );

        $this->add_control(
                'form_border_left_color', [
            'label' => __('Form Border Left Color', 'appointment'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'scheme' => [
                'type' => \Elementor\Scheme_Color::get_type(),
                'value' => \Elementor\Scheme_Color::COLOR_1,
            ],
            'default' => '#565656',
            'selectors' => [
                '{{WRAPPER}} .ink-container' => 'border-left-color : {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'form_border_top_color', [
            'label' => __('Form Border Top Color', 'appointment'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'scheme' => [
                'type' => \Elementor\Scheme_Color::get_type(),
                'value' => \Elementor\Scheme_Color::COLOR_1,
            ],
            'default' => '#565656',
            'selectors' => [
                '{{WRAPPER}} .ink-container' => 'border-top-color : {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'form_border_right_color', [
            'label' => __('Form Border Right Color', 'appointment'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'scheme' => [
                'type' => \Elementor\Scheme_Color::get_type(),
                'value' => \Elementor\Scheme_Color::COLOR_1,
            ],
            'default' => '#565656',
            'selectors' => [
                '{{WRAPPER}} .ink-container' => 'border-right-color : {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'form_border_bottom_color', [
            'label' => __('Form Border Bottom Color', 'appointment'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'scheme' => [
                'type' => \Elementor\Scheme_Color::get_type(),
                'value' => \Elementor\Scheme_Color::COLOR_1,
            ],
            'default' => '#565656',
            'selectors' => [
                '{{WRAPPER}} .ink-container' => 'border-bottom-color : {{VALUE}}',
            ],
                ]
        );

        $this->add_responsive_control(
                'form_border_width', [
            'label' => __('Form Border Width', 'appointment'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .ink-container' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_control(
                'main_heading_text_typography', [
            'label' => __('Main Heading', 'appointment'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
                ]
        );

        $this->add_control(
                'main_text_color', [
            'label' => __('Text Color', 'appointment'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'scheme' => [
                'type' => \Elementor\Scheme_Color::get_type(),
                'value' => \Elementor\Scheme_Color::COLOR_1,
            ],
            'default' => '#fff',
            'selectors' => [
                '{{WRAPPER}} .ink-container .textheading h2' => 'color: {{VALUE}}',
            ],
                ]
        );

        $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(), [
            'name' => 'main_form_typography',
            'label' => __('Typography', 'appointment'),
            'selector' => '{{WRAPPER}} .ink-container .textheading h2',
            '(desktop){{WRAPPER}} .ink-container .textheading h2',
            '(tablet){{WRAPPER}} .ink-container .textheading h2',
            '(mobile){{WRAPPER}} .ink-container .textheading h2',
                ]
        );

        $this->add_control(
                'main_headtext_align', [
            'label' => __('Text Align', 'appointment'),
            'type' => Controls_Manager::CHOOSE,
            'options' => [
                'left' => [
                    'title' => __('Left', 'appointment'),
                    'icon' => 'fa fa-align-left',
                ],
                'center' => [
                    'title' => __('Center', 'appointment'),
                    'icon' => 'fa fa-align-center',
                ],
                'right' => [
                    'title' => __('Right', 'appointment'),
                    'icon' => 'fa fa-align-right',
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .ink-container .textheading h2' => 'text-align: {{VALUE}};',
            ],
            'default' => 'center'
                ]
        );

        $this->add_control(
                'main_head_display', [
            'label' => __('Show/Hide Main Heading', 'appointment'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => __('on', 'appointment'),
            'label_off' => __('off', 'appointment'),
            'return_value' => 'on',
            'default' => 'on'
                ]
        );

        $this->add_control(
                'divider_stylings', [
            'label' => __('Divider Stylings', 'appointment'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
                ]
        );

        $this->add_control(
                'content_divider_color', [
            'label' => __('Divider Color', 'appointment'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'scheme' => [
                'type' => \Elementor\Scheme_Color::get_type(),
                'value' => \Elementor\Scheme_Color::COLOR_4,
            ],
            'default' => '#777777',
            'selectors' => [
                '{{WRAPPER}} .head_divider' => 'border-bottom-color: {{VALUE}}',
            ],
                ]
        );

        $this->add_responsive_control(
                'divider_border_height', [
            'label' => __('Divider Border Height', 'appointment'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'default' => [
                'unit' => 'px',
                'size' => '1',
            ],
            'range' => [
                'px' => [
                    'min' => 1,
                    'max' => 30,
                ],
            ],
            'devices' => ['desktop', 'tablet', 'mobile'],
            'desktop_default' => [
//                'size' => 30,
                'unit' => 'px',
            ],
            'tablet_default' => [
//                'size' => 20,
                'unit' => 'px',
            ],
            'mobile_default' => [
//                'size' => 10,
                'unit' => 'px',
            ],
            'selectors' => [
                '{{WRAPPER}} .head_divider' => 'border-bottom-width: {{SIZE}}{{UNIT}};',
            ],
                ]
        );

        $this->add_control(
                'label1_heading_text_typography', [
            'label' => __('Appointment Date Section', 'appointment'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
                ]
        );

        $this->add_control(
                'label1_text_color', [
            'label' => __('Text Color', 'appointment'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'scheme' => [
                'type' => \Elementor\Scheme_Color::get_type(),
                'value' => \Elementor\Scheme_Color::COLOR_2,
            ],
            'default' => '#fff',
            'selectors' => [
                '{{WRAPPER}} .ink-container .textfixdate h4' => 'color: {{VALUE}}',
            ],
                ]
        );

        $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(), [
            'name' => 'label1_form_typography',
            'label' => __('Typography', 'appointment'),
            'selector' => '{{WRAPPER}} .ink-container .textfixdate h4',
            '(desktop){{WRAPPER}} .ink-container .textfixdate h4',
            '(tablet){{WRAPPER}} .ink-container .textfixdate h4',
            '(mobile){{WRAPPER}} .ink-container .textfixdate h4',
                ]
        );

        $this->add_control(
                'label1_text_align', [
            'label' => __('Text Align', 'appointment'),
            'type' => Controls_Manager::CHOOSE,
            'options' => [
                'left' => [
                    'title' => __('Left', 'appointment'),
                    'icon' => 'fa fa-align-left',
                ],
                'center' => [
                    'title' => __('Center', 'appointment'),
                    'icon' => 'fa fa-align-center',
                ],
                'right' => [
                    'title' => __('Right', 'appointment'),
                    'icon' => 'fa fa-align-right',
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .ink-container .textfixdate h4' => 'text-align: {{VALUE}};',
            ],
            'default' => 'center'
                ]
        );

        $this->add_control(
                'sub_head_display', [
            'label' => __('Show/Hide Heading', 'appointment'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => __('on', 'appointment'),
            'label_off' => __('off', 'appointment'),
            'return_value' => 'on',
            'default' => 'on'
                ]
        );

        $this->add_control(
                'form_advance_settings', [
            'label' => __('Advanced Settings', 'appointment'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
                ]
        );

        $this->add_responsive_control(
                'form_margin', [
            'label' => __('Form Margin', 'appointment'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'default' => [
                'top' => 0,
                'right' => -5,
                'bottom' => 0,
                'left' => -5,
                'unit' => 'px',
            ],
            'selectors' => [
                '{{WRAPPER}} .inkappointment_wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_responsive_control(
                'form_border_radius', [
            'label' => __('Form Border Radius', 'appointment'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .ink-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_control(
                'other_stylings', [
            'label' => __('Other Stylings', 'appointment'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
                ]
        );

        $this->add_control(
                'error_msg_color', [
            'label' => __('Error Message Color', 'appointment'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'scheme' => [
                'type' => \Elementor\Scheme_Color::get_type(),
                'value' => \Elementor\Scheme_Color::COLOR_4,
            ],
            'default' => '#ff0000',
            'selectors' => [
                '{{WRAPPER}} label.error, p.error_msg' => 'color: {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'captcha_msg_color', [
            'label' => __('Captcha Message Text Color', 'appointment'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'scheme' => [
                'type' => \Elementor\Scheme_Color::get_type(),
                'value' => \Elementor\Scheme_Color::COLOR_4,
            ],
            'default' => '#2196F3',
            'selectors' => [
                '{{WRAPPER}} ul.inkappform li span.msg' => 'color: {{VALUE}}',
            ],
                ]
        );

        $this->end_controls_section();


        /* ================== Field Settings Start======================= */

        $this->start_controls_section(
                'field_style_section', [
            'label' => __('Field Settings', 'appointment'),
            'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_control(
                'input_bg_color', [
            'label' => __('Text Fields Background Color', 'appointment'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'scheme' => [
                'type' => \Elementor\Scheme_Color::get_type(),
                'value' => \Elementor\Scheme_Color::COLOR_2,
            ],
            'default' => '#3A3A3A',
            'selectors' => [
                '{{WRAPPER}} .ink-container ul.inkappform input.inktext, .ink-container ul.inkappform select.inktext, .ink-container ul.inkappform textarea.inklarge, .ink-container ul.inkappform input#aptcal' => 'background: {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'heading_field_text_typography', [
            'label' => __('Input Field Text', 'appointment'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
                ]
        );

        $this->add_control(
                'field_text_color', [
            'label' => __('Text Color', 'appointment'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'scheme' => [
                'type' => \Elementor\Scheme_Color::get_type(),
                'value' => \Elementor\Scheme_Color::COLOR_3,
            ],
            'default' => '#fff',
            'selectors' => [
                '{{WRAPPER}} .ink-container ul.inkappform input.inktext, .ink-container ul.inkappform input.inktext::placeholder, .ink-container ul.inkappform select.inktext, textarea#textmsg::placeholder, textarea#textmsg, .radioname, .checkname' => 'color: {{VALUE}}',
            ],
                ]
        );

        $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(), [
            'name' => 'field_typography',
            'label' => __('Typography', 'appointment'),
            'selector' => '{{WRAPPER}} .ink-container ul.inkappform input.inktext, .ink-container ul.inkappform select.inktext, .ink-container ul.inkappform textarea.inktext',
            '(desktop){{WRAPPER}} .ink-container ul.inkappform input.inktext, .ink-container ul.inkappform select.inktext, .ink-container ul.inkappform textarea.inktext',
            '(tablet){{WRAPPER}} .ink-container ul.inkappform input.inktext, .ink-container ul.inkappform select.inktext, .ink-container ul.inkappform textarea.inktext',
            '(mobile){{WRAPPER}} .ink-container ul.inkappform input.inktext, .ink-container ul.inkappform select.inktext, .ink-container ul.inkappform textarea.inktext',
                ]
        );

        $this->add_control(
                'field_border_color', [
            'label' => __('Field Border Stylings', 'appointment'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
                ]
        );

        $this->add_control(
                'field_border_left_color', [
            'label' => __('Border Left Color', 'appointment'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'scheme' => [
                'type' => \Elementor\Scheme_Color::get_type(),
                'value' => \Elementor\Scheme_Color::COLOR_4,
            ],
            'default' => '#777777',
            'selectors' => [
                '{{WRAPPER}} .ink-container ul.inkappform input.inktext, .ink-container ul.inkappform textarea.inktext, #elementor .elementor-element-2f9a1eb .ink-container ul.inkappform input.inktext, .ink-container ul.inkappform select.inktext, .ink-container ul.inkappform textarea.inklarge' => 'border-left-color: {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'field_border_right_color', [
            'label' => __('Border Right Color', 'appointment'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'scheme' => [
                'type' => \Elementor\Scheme_Color::get_type(),
                'value' => \Elementor\Scheme_Color::COLOR_4,
            ],
            'default' => '#777777',
            'selectors' => [
                '{{WRAPPER}} .ink-container ul.inkappform input.inktext, .ink-container ul.inkappform textarea.inktext, #elementor .elementor-element-2f9a1eb .ink-container ul.inkappform input.inktext, .ink-container ul.inkappform select.inktext, .ink-container ul.inkappform textarea.inklarge' => 'border-right-color: {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'field_border_top_color', [
            'label' => __('Border Top Color', 'appointment'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'scheme' => [
                'type' => \Elementor\Scheme_Color::get_type(),
                'value' => \Elementor\Scheme_Color::COLOR_4,
            ],
            'default' => '#777777',
            'selectors' => [
                '{{WRAPPER}} .ink-container ul.inkappform input.inktext, .ink-container ul.inkappform textarea.inktext, #elementor .elementor-element-2f9a1eb .ink-container ul.inkappform input.inktext, .ink-container ul.inkappform select.inktext, .ink-container ul.inkappform textarea.inklarge' => 'border-top-color: {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'field_border_bottom_color', [
            'label' => __('Border Bottom Color', 'appointment'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'scheme' => [
                'type' => \Elementor\Scheme_Color::get_type(),
                'value' => \Elementor\Scheme_Color::COLOR_4,
            ],
            'default' => '#777777',
            'selectors' => [
                '{{WRAPPER}} .ink-container ul.inkappform input.inktext, .ink-container ul.inkappform textarea.inktext, #elementor .elementor-element-2f9a1eb .ink-container ul.inkappform input.inktext, .ink-container ul.inkappform select.inktext, .ink-container ul.inkappform textarea.inklarge' => 'border-bottom-color: {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'field_advance_settings', [
            'label' => __('Advanced Settings', 'appointment'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
                ]
        );

        $this->add_responsive_control(
                'field_border_radius', [
            'label' => __('Field Border Radius', 'appointment'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .ink-container ul.inkappform input.inktext, .ink-container ul.inkappform textarea.inktext, #elementor .elementor-element-2f9a1eb .ink-container ul.inkappform input.inktext, .ink-container ul.inkappform select.inktext, .ink-container ul.inkappform textarea.inklarge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_responsive_control(
                'field_input_border', [
            'label' => __('Field Border Size', 'appointment'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .ink-container ul.inkappform input.inktext, .ink-container ul.inkappform textarea.inktext, #elementor .elementor-element-2f9a1eb .ink-container ul.inkappform input.inktext, .ink-container ul.inkappform select.inktext, .ink-container ul.inkappform textarea.inklarge' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

//        $this->add_responsive_control(
//                'field_margin_control', [
//            'label' => __('Field Margin', 'appointment'),
//            'type' => Controls_Manager::DIMENSIONS,
//            'size_units' => ['px', '%'],
//            'selectors' => [
//                '{{WRAPPER}} .ink-container .ink-form ul.inkappform li, .ink-container ul.inkappform textarea.inktext' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
//            ],
//                ]
//        );

        $this->add_responsive_control(
                'field_padding_control', [
            'label' => __('Field Padding', 'appointment'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} input#fname, input#aptemail, input#aptphone, select#service_select, input#aptcal, select#time, input#sr_price, input#leaduser, input#leadnum, textarea#textmsg' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_responsive_control(
                'field_margin_control', [
            'label' => __('Field Top Margin', 'appointment'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['%'],
            'default' => [
                'unit' => '%',
                'size' => 0,
            ],
            'range' => [
                'px' => [
                    'min' => 30,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .ink-container ul.inkappform' => 'margin-top: {{SIZE}}{{UNIT}};',
            ],
                ]
        );

        $this->add_responsive_control(
                'field_height', [
            'label' => __('Field Height', 'appointment'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['%', 'px'],
            'default' => [
                'unit' => 'px',
                'size' => 40,
            ],
            'range' => [
                'px' => [
                    'min' => 30,
                    'max' => 100,
                ],
                '%' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'devices' => ['desktop', 'tablet', 'mobile'],
            'desktop_default' => [
//                'size' => 30,
                'unit' => 'px',
            ],
            'tablet_default' => [
//                'size' => 20,
                'unit' => 'px',
            ],
            'mobile_default' => [
//                'size' => 10,
                'unit' => 'px',
            ],
            'selectors' => [
                '{{WRAPPER}} .ink-container ul.inkappform input.inktext, .ink-container ul.inkappform select.inktext' => 'height: {{SIZE}}{{UNIT}};',
            ],
                ]
        );

//        $this->add_responsive_control(
//                'fields_width', [
//            'label' => __('Field Width', 'appointment'),
//            'type' => Controls_Manager::SLIDER,
//            'size_units' => ['%'],
//            'default' => [
//                'unit' => '%',
//                'size' => '100',
//            ],
//            'range' => [
//                '%' => [
//                    'min' => 24,
//                    'max' => 100,
//                ],
//            ],
//            'devices' => ['desktop', 'tablet', 'mobile'],
//            'desktop_default' => [
////                'size' => 30,
//                'unit' => '%',
//            ],
//            'tablet_default' => [
////                'size' => 20,
//                'unit' => '%',
//            ],
//            'mobile_default' => [
//                'size' => 100,
//                'unit' => '%',
//            ],
//            'selectors' => [
//                '{{WRAPPER}} ul.inkappform li' => 'width: {{SIZE}}{{UNIT}};',
//            ],
//                ]
//        );

        $this->add_control(
                'input_field_width_settings', [
            'label' => __('Field Width Settings', 'appointment'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
                ]
        );

        $this->add_control(
                'input_text_name_field', [
            'label' => __('Name Field', 'appointment'),
            'type' => Controls_Manager::SELECT,
            'options' => [
//                '10' => __('10%', 'appointment'),
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
                '100.0' => __('100%', 'appointment'),
            ],
            'default' => '100',
            'selectors' => [
                '{{WRAPPER}} ul.inkappform li.textfname' => 'width: {{VALUE}}%;',
            ],
                ]
        );

        $this->add_control(
                'email_text_field', [
            'label' => __('Email Field', 'appointment'),
            'type' => Controls_Manager::SELECT,
            'options' => [
//                '10' => __('10%', 'appointment'),
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
                '100.0' => __('100%', 'appointment'),
            ],
            'default' => '100',
            'selectors' => [
                '{{WRAPPER}} ul.inkappform li.textaptemail' => 'width: {{VALUE}}%;',
            ],
                ]
        );

        $this->add_control(
                'contact_text_field', [
            'label' => __('Contact Field', 'appointment'),
            'type' => Controls_Manager::SELECT,
            'options' => [
//                '10' => __('10%', 'appointment'),
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
                '100.0' => __('100%', 'appointment'),
            ],
            'default' => '100',
            'selectors' => [
                '{{WRAPPER}} ul.inkappform li.textaptphone' => 'width: {{VALUE}}%;',
            ],
                ]
        );

        $this->add_control(
                'service_select_field', [
            'label' => __('Service Field', 'appointment'),
            'type' => Controls_Manager::SELECT,
            'options' => [
//                '10' => __('10%', 'appointment'),
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
                '100.0' => __('100%', 'appointment'),
            ],
            'default' => '100',
            'selectors' => [
                '{{WRAPPER}} ul.inkappform li.select_item' => 'width: {{VALUE}}%;',
            ],
                ]
        );

        $this->add_control(
                'date_select_field', [
            'label' => __('Date Field', 'appointment'),
            'type' => Controls_Manager::SELECT,
            'options' => [
//                '10' => __('10%', 'appointment'),
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
                '100.0' => __('100%', 'appointment'),
            ],
            'default' => '100',
            'selectors' => [
                '{{WRAPPER}} ul.inkappform li.textaptcal' => 'width: {{VALUE}}%;',
            ],
                ]
        );

        $this->add_control(
                'time_select_field', [
            'label' => __('Time Field', 'appointment'),
            'type' => Controls_Manager::SELECT,
            'options' => [
//                '10' => __('10%', 'appointment'),
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
                '100.0' => __('100%', 'appointment'),
            ],
            'default' => '100',
            'selectors' => [
                '{{WRAPPER}} ul.inkappform li.select_item_time' => 'width: {{VALUE}}%;',
            ],
                ]
        );

        $this->add_control(
                'service_price_field', [
            'label' => __('Service Price Field', 'appointment'),
            'type' => Controls_Manager::SELECT,
            'options' => [
//                '10' => __('10%', 'appointment'),
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
                '100.0' => __('100%', 'appointment'),
            ],
            'default' => '100',
            'selectors' => [
                '{{WRAPPER}} ul.inkappform li.textprice' => 'width: {{VALUE}}%;',
            ],
                ]
        );

        $this->add_control(
                'single_line_field', [
            'label' => __('Single Line Field', 'appointment'),
            'type' => Controls_Manager::SELECT,
            'options' => [
//                '10' => __('10%', 'appointment'),
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
                '100.0' => __('100%', 'appointment'),
            ],
            'default' => '100',
            'selectors' => [
                '{{WRAPPER}} ul.inkappform li.text_field' => 'width: {{VALUE}}%;',
            ],
                ]
        );

        $this->add_control(
                'number_field_acf', [
            'label' => __('Number Field', 'appointment'),
            'type' => Controls_Manager::SELECT,
            'options' => [
//                '10' => __('10%', 'appointment'),
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
                '100.0' => __('100%', 'appointment'),
            ],
            'default' => '100',
            'selectors' => [
                '{{WRAPPER}} ul.inkappform li.num_field' => 'width: {{VALUE}}%;',
            ],
                ]
        );

        $this->add_control(
                'field_column_gap', [
            'label' => __('Field Columns Gap', 'appointment'),
            'type' => Controls_Manager::SLIDER,
            'default' => [
                'size' => 10,
            ],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .ink-container .ink-form ul.inkappform li' => 'padding-right: calc( {{SIZE}}{{UNIT}}/2 ); padding-left: calc( {{SIZE}}{{UNIT}}/2 );',
                '{{WRAPPER}} .ink-container .ink-form ul.inkappform' => 'margin-left: calc( -{{SIZE}}{{UNIT}}/2 ); margin-right: calc( -{{SIZE}}{{UNIT}}/2 );',
            ],
                ]
        );

        $this->add_control(
                'field_row_gap', [
            'label' => __('Field Rows Gap', 'appointment'),
            'type' => Controls_Manager::SLIDER,
            'default' => [
                'size' => 0,
            ],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .ink-container .ink-form ul.inkappform li, .ink-container ul.inkappform textarea.inktext' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .ink-container .ink-form ul.inkappform' => 'margin-bottom: -{{SIZE}}{{UNIT}};',
            ],
                ]
        );

        $this->add_control(
                'dropdown_option_style', [
            'label' => __('Dropdown Option Stylings', 'appointment'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
                ]
        );

        $this->add_control(
                'field_option_bg_color', [
            'label' => __('Option Background Color', 'appointment'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'scheme' => [
                'type' => \Elementor\Scheme_Color::get_type(),
                'value' => \Elementor\Scheme_Color::COLOR_4,
            ],
            'default' => '#fff',
            'selectors' => [
                '{{WRAPPER}} ul.inkappform li select.inktext option' => 'background-color: {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'field_option_text_color', [
            'label' => __('Option Text Color', 'appointment'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'scheme' => [
                'type' => \Elementor\Scheme_Color::get_type(),
                'value' => \Elementor\Scheme_Color::COLOR_4,
            ],
            'default' => '#000',
            'selectors' => [
                '{{WRAPPER}} ul.inkappform li select.inktext option' => 'color: {{VALUE}}',
            ],
                ]
        );

        $this->end_controls_section();


        /* =======================Button Section =========================== */


        $this->start_controls_section(
                'btn_section_style', [
            'label' => __('Button Settings', 'appointment'),
            'tab' => Controls_Manager::TAB_STYLE,
                ]
        );
        $this->add_control(
                'heading_button_text_colors', [
            'label' => __('Color Settings', 'appointment'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
                ]
        );
        $this->start_controls_tabs(
                'style_tabs'
        );

        $this->start_controls_tab(
                'style_normal_tab', [
            'label' => __('Normal', 'appointment'),
                ]
        );

        $this->add_control(
                'button_text_color', [
            'label' => __('Text Color', 'appointment'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'scheme' => [
                'type' => \Elementor\Scheme_Color::get_type(),
                'value' => \Elementor\Scheme_Color::COLOR_4,
            ],
            'default' => '#fff',
            'selectors' => [
                '{{WRAPPER}} .ink-container input#submit' => 'color: {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'button_bg_color', [
            'label' => __('Background Color', 'appointment'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'scheme' => [
                'type' => \Elementor\Scheme_Color::get_type(),
                'value' => \Elementor\Scheme_Color::COLOR_1,
            ],
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .ink-container input#submit' => 'background: {{VALUE}}',
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
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .ink-container input#submit' => 'border-color: {{VALUE}}',
            ],
                ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
                'button_style_hover_tab', [
            'label' => __('Hover', 'appointment'),
                ]
        );

        $this->add_control(
                'button_text_hover_color', [
            'label' => __('Text Color', 'appointment'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'scheme' => [
                'type' => \Elementor\Scheme_Color::get_type(),
                'value' => \Elementor\Scheme_Color::COLOR_4,
            ],
            'default' => '#fff',
            'selectors' => [
                '{{WRAPPER}} .ink-container input#submit:hover' => 'color: {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'button_hover_bg_color', [
            'label' => __('Background Color', 'appointment'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'scheme' => [
                'type' => \Elementor\Scheme_Color::get_type(),
                'value' => \Elementor\Scheme_Color::COLOR_2,
            ],
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .ink-container input#submit:hover' => 'background: {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'button_border_hover_color', [
            'label' => __('Border Color', 'leadcapture'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'scheme' => [
                'type' => \Elementor\Scheme_Color::get_type(),
                'value' => \Elementor\Scheme_Color::COLOR_2,
            ],
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .ink-container input#submit:hover' => 'border-color: {{VALUE}}',
            ],
                ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
                'heading_button_text_typography', [
            'label' => __('Button Styling', 'appointment'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
                ]
        );

        $this->add_control(
                'button_border_display', [
            'label' => __('Show Border', 'leadcapture'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => __('Yes', 'leadcapture'),
            'label_off' => __('No', 'leadcapture'),
            'return_value' => 'yes',
            'default' => 'no',
                ]
        );
        $this->add_responsive_control(
                'button_border_size', [
            'label' => __('Border Size', 'appointment'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .ink-container input#submit' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Box_Shadow::get_type(), [
            'name' => 'button_box_shadow',
            'label' => __('Box Shadow', 'leadcapture'),
            'selector' => '{{WRAPPER}} .ink-container input#submit',
            'separator' => 'before'
                ]
        );


        $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(), [
            'name' => 'btn_typography',
            'label' => __('Typography', 'appointment'),
            'selector' => '{{WRAPPER}} .ink-container input#submit',
            '(desktop){{WRAPPER}} .ink-container input#submit',
            '(tablet){{WRAPPER}} .ink-container input#submit',
            '(mobile){{WRAPPER}} .ink-container input#submit',
                ]
        );

        $this->add_control(
                'button_advance_settings', [
            'label' => __('Advanced Settings', 'appointment'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
                ]
        );

        $this->add_responsive_control(
                'button_border_radius', [
            'label' => __('Border Radius', 'appointment'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .ink-container input#submit' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_responsive_control(
                'button_spacing_control', [
            'label' => __('Button Margin', 'appointment'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .ink-container .ink-form .submit_bg' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_responsive_control(
                'button_width', [
            'label' => __('Button Width', 'appointment'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['%', 'px'],
            'default' => [
                'unit' => '%',
                'size' => 100,
            ],
            'range' => [
                '%' => [
                    'min' => 0,
                    'max' => 100,
                ],
                'px' => [
                    'min' => 80 ,
                    'max' => 1000,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .ink-container input#submit' => 'width: {{SIZE}}{{UNIT}};',
            ],
                ]
        );

        $this->add_responsive_control(
                'button_height', [
            'label' => __('Button Height', 'appointment'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'default' => [
                'unit' => 'px',
                'size' => 50,
            ],
            'range' => [
                'px' => [
                    'min' => 50,
                    'max' => 200,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .ink-container input#submit' => 'height: {{SIZE}}{{UNIT}};',
            ],
                ]
        );

        $this->add_control(
                'button_alignment', [
            'label' => __('Button Alignment', 'appointment'),
            'type' => Controls_Manager::CHOOSE,
            'options' => [
                'left' => [
                    'title' => __('Left', 'appointment'),
                    'icon' => 'fa fa-align-left',
                ],
                'center' => [
                    'title' => __('Center', 'appointment'),
                    'icon' => 'fa fa-align-center',
                ],
                'right' => [
                    'title' => __('Right', 'appointment'),
                    'icon' => 'fa fa-align-right',
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .ink-container .submit_bg' => 'text-align: {{VALUE}};',
            ],
            'default' => 'center'
                ]
        );

        $this->end_controls_section();


        /* ================= Custom Field Settings Section ======================== */


        $this->start_controls_section(
                'custom_field_section_settings', [
            'label' => __('Custom Field Settings', 'appointment'),
            'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_control(
                'label3_heading_text_typography', [
            'label' => __('Single Line Field', 'appointment'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
                ]
        );

        $this->add_control(
                'label3_text_color', [
            'label' => __('Text Color', 'appointment'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'scheme' => [
                'type' => \Elementor\Scheme_Color::get_type(),
                'value' => \Elementor\Scheme_Color::COLOR_2,
            ],
            'default' => '#fff',
            'selectors' => [
                '{{WRAPPER}} .ink-container .textfixdate2 h4' => 'color: {{VALUE}}',
            ],
                ]
        );

        $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(), [
            'name' => 'label3_form_typography',
            'label' => __('Typography', 'appointment'),
            'selector' => '{{WRAPPER}} .ink-container .textfixdate2 h4',
            '(desktop){{WRAPPER}} .ink-container .textfixdate2 h4',
            '(tablet){{WRAPPER}} .ink-container .textfixdate2 h4',
            '(mobile){{WRAPPER}} .ink-container .textfixdate2 h4',
                ]
        );

        $this->add_control(
                'label3_text_align', [
            'label' => __('Text Align', 'appointment'),
            'type' => Controls_Manager::CHOOSE,
            'options' => [
                'left' => [
                    'title' => __('Left', 'appointment'),
                    'icon' => 'fa fa-align-left',
                ],
                'center' => [
                    'title' => __('Center', 'appointment'),
                    'icon' => 'fa fa-align-center',
                ],
                'right' => [
                    'title' => __('Right', 'appointment'),
                    'icon' => 'fa fa-align-right',
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .ink-container .textfixdate2 h4' => 'text-align: {{VALUE}};',
            ],
            'default' => 'center'
                ]
        );

        $this->add_control(
                'label2_heading_text_typography', [
            'label' => __('Multi Line Field', 'appointment'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
                ]
        );

        $this->add_control(
                'label2_text_color', [
            'label' => __('Text Color', 'appointment'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'scheme' => [
                'type' => \Elementor\Scheme_Color::get_type(),
                'value' => \Elementor\Scheme_Color::COLOR_2,
            ],
            'default' => '#fff',
            'selectors' => [
                '{{WRAPPER}} .ink-container .textfixdate1 h4' => 'color: {{VALUE}}',
            ],
                ]
        );

        $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(), [
            'name' => 'label2_form_typography',
            'label' => __('Typography', 'appointment'),
            'selector' => '{{WRAPPER}} .ink-container .textfixdate1 h4',
            '(desktop){{WRAPPER}} .ink-container .textfixdate1 h4',
            '(tablet){{WRAPPER}} .ink-container .textfixdate1 h4',
            '(mobile){{WRAPPER}} .ink-container .textfixdate1 h4',
                ]
        );

        $this->add_control(
                'label2_text_align', [
            'label' => __('Text Align', 'appointment'),
            'type' => Controls_Manager::CHOOSE,
            'options' => [
                'left' => [
                    'title' => __('Left', 'appointment'),
                    'icon' => 'fa fa-align-left',
                ],
                'center' => [
                    'title' => __('Center', 'appointment'),
                    'icon' => 'fa fa-align-center',
                ],
                'right' => [
                    'title' => __('Right', 'appointment'),
                    'icon' => 'fa fa-align-right',
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .ink-container .textfixdate1 h4' => 'text-align: {{VALUE}};',
            ],
            'default' => 'center'
                ]
        );

        $this->add_responsive_control(
                'msgbox_height', [
            'label' => __('Multi Line Field Height', 'appointment'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'default' => [
                'unit' => 'px',
                'size' => '150',
            ],
            'range' => [
                'px' => [
                    'min' => 40,
                    'max' => 300,
                ],
            ],
            'devices' => ['desktop', 'tablet', 'mobile'],
            'desktop_default' => [
//                'size' => 30,
                'unit' => 'px',
            ],
            'tablet_default' => [
//                'size' => 20,
                'unit' => 'px',
            ],
            'mobile_default' => [
//                'size' => 10,
                'unit' => 'px',
            ],
            'selectors' => [
                '{{WRAPPER}} .ink-container ul.inkappform textarea.inktext' => 'height: {{SIZE}}{{UNIT}};',
            ],
                ]
        );

        $this->add_responsive_control(
                'msgbox_width', [
            'label' => __('Multi Line Field Width', 'appointment'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['%'],
            'default' => [
                'unit' => '%',
                'size' => '',
            ],
            'range' => [
                '%' => [
                    'min' => 40,
                    'max' => 100,
                ],
            ],
            'devices' => ['desktop', 'tablet', 'mobile'],
            'desktop_default' => [
//                'size' => 30,
                'unit' => '%',
            ],
            'tablet_default' => [
//                'size' => 20,
                'unit' => '%',
            ],
            'mobile_default' => [
//                'size' => 10,
                'unit' => '%',
            ],
            'selectors' => [
                '{{WRAPPER}} .ink-container ul.inkappform textarea.inktext' => 'width: {{SIZE}}{{UNIT}};',
            ],
                ]
        );

        $this->add_responsive_control(
                'msg_field_padding_control', [
            'label' => __('Field Padding', 'appointment'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} textarea#textmsg' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_control(
                'label4_heading_text_typography', [
            'label' => __('Number Field', 'appointment'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
                ]
        );

        $this->add_control(
                'label4_text_color', [
            'label' => __('Text Color', 'appointment'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'scheme' => [
                'type' => \Elementor\Scheme_Color::get_type(),
                'value' => \Elementor\Scheme_Color::COLOR_2,
            ],
            'default' => '#fff',
            'selectors' => [
                '{{WRAPPER}} .ink-container .textfixdate3 h4' => 'color: {{VALUE}}',
            ],
                ]
        );

        $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(), [
            'name' => 'label4_form_typography',
            'label' => __('Typography', 'appointment'),
            'selector' => '{{WRAPPER}} .ink-container .textfixdate3 h4',
            '(desktop){{WRAPPER}} .ink-container .textfixdate3 h4',
            '(tablet){{WRAPPER}} .ink-container .textfixdate3 h4',
            '(mobile){{WRAPPER}} .ink-container .textfixdate3 h4',
                ]
        );

        $this->add_control(
                'label4_text_align', [
            'label' => __('Text Align', 'appointment'),
            'type' => Controls_Manager::CHOOSE,
            'options' => [
                'left' => [
                    'title' => __('Left', 'appointment'),
                    'icon' => 'fa fa-align-left',
                ],
                'center' => [
                    'title' => __('Center', 'appointment'),
                    'icon' => 'fa fa-align-center',
                ],
                'right' => [
                    'title' => __('Right', 'appointment'),
                    'icon' => 'fa fa-align-right',
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .ink-container .textfixdate3 h4' => 'text-align: {{VALUE}};',
            ],
            'default' => 'center'
                ]
        );

        $this->add_control(
                'checkbox_text_typography', [
            'label' => __('Check Box Field', 'appointment'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
                ]
        );

        $this->add_control(
                'checkbox_heading_color', [
            'label' => __('Heading Color', 'appointment'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'scheme' => [
                'type' => \Elementor\Scheme_Color::get_type(),
                'value' => \Elementor\Scheme_Color::COLOR_4,
            ],
            'default' => '#fff',
            'selectors' => [
                '{{WRAPPER}} .checkpanel span span.checkheading h4' => 'color: {{VALUE}}',
            ],
                ]
        );

        $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(), [
            'name' => 'checkbox_heading_typography',
            'label' => __('Heading Typography', 'appointment'),
            'selector' => '{{WRAPPER}} .checkpanel span span.checkheading h4',
            '(desktop){{WRAPPER}} .checkpanel span span.checkheading h4',
            '(tablet){{WRAPPER}} .checkpanel span span.checkheading h4',
            '(mobile){{WRAPPER}} .checkpanel span span.checkheading h4',
                ]
        );

        $this->add_control(
                'checkbox_text_align', [
            'label' => __('Text Align', 'appointment'),
            'type' => Controls_Manager::CHOOSE,
            'options' => [
                'left' => [
                    'title' => __('Left', 'appointment'),
                    'icon' => 'fa fa-align-left',
                ],
                'center' => [
                    'title' => __('Center', 'appointment'),
                    'icon' => 'fa fa-align-center',
                ],
                'right' => [
                    'title' => __('Right', 'appointment'),
                    'icon' => 'fa fa-align-right',
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .checkpanel span span.checkheading h4' => 'text-align: {{VALUE}};',
            ],
            'default' => 'center'
                ]
        );

        $this->add_control(
                'checkbox_label_color', [
            'label' => __('Option Color', 'appointment'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'scheme' => [
                'type' => \Elementor\Scheme_Color::get_type(),
                'value' => \Elementor\Scheme_Color::COLOR_4,
            ],
            'default' => '#fff',
            'selectors' => [
                '{{WRAPPER}} .checkname' => 'color: {{VALUE}}',
            ],
                ]
        );

        $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(), [
            'name' => 'checkbox_label_typography',
            'label' => __('Option Typography', 'appointment'),
            'selector' => '{{WRAPPER}} .checkname',
            '(desktop){{WRAPPER}} .checkname',
            '(tablet){{WRAPPER}} .checkname',
            '(mobile){{WRAPPER}} .checkname',
                ]
        );

        $this->add_control(
                'chkbox_bg_color', [
            'label' => __('Background Color', 'appointment'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'scheme' => [
                'type' => \Elementor\Scheme_Color::get_type(),
                'value' => \Elementor\Scheme_Color::COLOR_4,
            ],
            'default' => '#2196F3',
            'selectors' => [
                '{{WRAPPER}} .lead-check-div input:checked ~ .checkmark' => 'background-color: {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'chk_option_display', [
            'label' => __('Display Options Vertically', 'appointment'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => __('Yes', 'appointment'),
            'label_off' => __('No', 'appointment'),
            'return_value' => 'yes',
            'default' => 'yes',
                ]
        );

        $this->add_control(
                'radio_button_text_typography', [
            'label' => __('Radio Button Field', 'appointment'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
                ]
        );

        $this->add_control(
                'radio_heading_color', [
            'label' => __('Heading Color', 'appointment'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'scheme' => [
                'type' => \Elementor\Scheme_Color::get_type(),
                'value' => \Elementor\Scheme_Color::COLOR_4,
            ],
            'default' => '#fff',
            'selectors' => [
                '{{WRAPPER}} .inkleadradiobox span span.radioheading h4' => 'color: {{VALUE}}',
            ],
                ]
        );

        $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(), [
            'name' => 'radio_btn_typography',
            'label' => __('Heading Typography', 'appointment'),
            'selector' => '{{WRAPPER}} .inkleadradiobox span span.radioheading h4',
            '(desktop){{WRAPPER}} .inkleadradiobox span span.radioheading h4',
            '(tablet){{WRAPPER}} .inkleadradiobox span span.radioheading h4',
            '(mobile){{WRAPPER}} .inkleadradiobox span span.radioheading h4',
                ]
        );

        $this->add_control(
                'radio_text_align', [
            'label' => __('Text Align', 'appointment'),
            'type' => Controls_Manager::CHOOSE,
            'options' => [
                'left' => [
                    'title' => __('Left', 'appointment'),
                    'icon' => 'fa fa-align-left',
                ],
                'center' => [
                    'title' => __('Center', 'appointment'),
                    'icon' => 'fa fa-align-center',
                ],
                'right' => [
                    'title' => __('Right', 'appointment'),
                    'icon' => 'fa fa-align-right',
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .inkleadradiobox span span.radioheading h4' => 'text-align: {{VALUE}};',
            ],
            'default' => 'center'
                ]
        );

        $this->add_control(
                'radio_label_color', [
            'label' => __('Option Color', 'appointment'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'scheme' => [
                'type' => \Elementor\Scheme_Color::get_type(),
                'value' => \Elementor\Scheme_Color::COLOR_4,
            ],
            'default' => '#fff',
            'selectors' => [
                '{{WRAPPER}} .radioname' => 'color: {{VALUE}}',
            ],
                ]
        );

        $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(), [
            'name' => 'radio_btn_label_typography',
            'label' => __('Option Typography', 'appointment'),
            'selector' => '{{WRAPPER}} .radioname',
            '(desktop){{WRAPPER}} .radioname',
            '(tablet){{WRAPPER}} .radioname',
            '(mobile){{WRAPPER}} .radioname',
                ]
        );

        $this->add_control(
                'radio_bg_color', [
            'label' => __('Background Color', 'appointment'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'scheme' => [
                'type' => \Elementor\Scheme_Color::get_type(),
                'value' => \Elementor\Scheme_Color::COLOR_4,
            ],
            'default' => '#2196F3',
            'selectors' => [
                '{{WRAPPER}} .lead-radio-div input:checked ~ .radiomark' => 'background-color: {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'radio_option_display', [
            'label' => __('Display Options Vertically', 'appointment'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => __('Yes', 'appointment'),
            'label_off' => __('No', 'appointment'),
            'return_value' => 'yes',
            'default' => 'yes',
                ]
        );

        $this->add_control(
                'headings_on_off', [
            'label' => __('Show/Hide Headings For', 'appointment'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
                ]
        );

        $this->add_control(
                'text_field_display', [
            'label' => __('Single Line Field', 'appointment'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => __('on', 'appointment'),
            'label_off' => __('off', 'appointment'),
            'return_value' => 'on',
            'default' => 'on',
                ]
        );

        $this->add_control(
                'textarea_field_display', [
            'label' => __('Multi Line Field', 'appointment'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => __('on', 'appointment'),
            'label_off' => __('off', 'appointment'),
            'return_value' => 'on',
            'default' => 'on',
                ]
        );

        $this->add_control(
                'number_field_display', [
            'label' => __('Number', 'appointment'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => __('on', 'appointment'),
            'label_off' => __('off', 'appointment'),
            'return_value' => 'on',
            'default' => 'on',
                ]
        );

        $this->add_control(
                'radio_field_display', [
            'label' => __('Radio Button', 'appointment'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => __('on', 'appointment'),
            'label_off' => __('off', 'appointment'),
            'return_value' => 'on',
            'default' => 'on',
                ]
        );

        $this->add_control(
                'checkbox_field_display', [
            'label' => __('Checkbox', 'appointment'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => __('on', 'appointment'),
            'label_off' => __('off', 'appointment'),
            'return_value' => 'on',
            'default' => 'on',
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

        /*        Checkbox Render Function       */

        $settings = $this->get_settings_for_display();
        if ('yes' === $settings['chk_option_display']) {
            echo '<style>span.cname label {
    display: block;}</style>';
        } else {
            echo '<style>span.cname label {
    display: inline;}</style>';
        }

        /*        Radio Button Render Function      */

        $settings = $this->get_settings_for_display();
        if ('yes' === $settings['radio_option_display']) {
            echo '<style>span.rname label {
    display: block;}</style>';
        } else {
            echo '<style>span.rname label{
    display: inline;}</style>';
        }

        $settings = $this->get_settings_for_display();
        if ('on' === $settings['textarea_field_display']) {
            echo '<style>.ink-container .textfixdate1 {
    display: block;}</style>';
        } else {
            echo '<style> .ink-container .textfixdate1{
    display: none;}</style>';
        }

        $settings = $this->get_settings_for_display();
        if ('on' === $settings['text_field_display']) {
            echo '<style>.ink-container .textfixdate2 {
    display: block;}</style>';
        } else {
            echo '<style> .ink-container .textfixdate2{
    display: none;}</style>';
        }

        $settings = $this->get_settings_for_display();
        if ('on' === $settings['number_field_display']) {
            echo '<style>.ink-container .textfixdate3 {
    display: block;}</style>';
        } else {
            echo '<style> .ink-container .textfixdate3{
    display: none;}</style>';
        }

        $settings = $this->get_settings_for_display();
        if ('on' === $settings['radio_field_display']) {
            echo '<style> .inkleadradiobox span span.radioheading h4 {
    display: block;}</style>';
        } else {
            echo '<style> .inkleadradiobox span span.radioheading h4{
    display: none;}</style>';
        }

        $settings = $this->get_settings_for_display();
        if ('on' === $settings['checkbox_field_display']) {
            echo '<style> .checkpanel span span.checkheading h4 {
    display: block;}</style>';
        } else {
            echo '<style> .checkpanel span span.checkheading h4{
    display: none;}</style>';
        }
        $settings = $this->get_settings_for_display();
        if ('on' === $settings['main_head_display']) {
            echo '<style> .textheading {
    display: block;}</style>';
        } else {
            echo '<style> .textheading{
    display: none;}</style>';
        }
        $settings = $this->get_settings_for_display();
        if ('on' === $settings['sub_head_display']) {
            echo '<style> .textfixdate {
    display: block;}</style>';
        } else {
            echo '<style> .textfixdate{
    display: none;}</style>';
        }

        /* Button border display Render Function */

        $settings = $this->get_settings_for_display();
        if ('yes' === $settings['button_border_display']) {
            echo '<style>.ink-container input#submit {
   border: 2px solid #bcbcbc;}</style>';
        } else {
            echo '<style>.ink-container input#submit {
   border: none !important;}</style>';
        }

        /*        Shortcode Render Function      */

        $shortcode = $this->get_settings();
        $shortcode = do_shortcode('[ink-appointments-form]');
        ?>
        <div class="elementor-shortcode"><?php echo $shortcode; ?></div>
        <?php
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
