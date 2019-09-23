<?php

namespace CwAddons\Modules\Stickynav\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Stickynav extends Widget_Base {

    public function get_name() {
        return 'ink-stickynav';
    }

    public function get_title() {
        return esc_html__('Sticky Nav', 'colorway-addons');
    }

    public function get_icon() {
        return 'ink-widget-icon fa fa-sticky-note';
    }

    public function get_categories() {
        return ['colorway-addons'];
    }

    protected function _register_controls() {

        $this->start_controls_section(
                'section_content_scrollnav', [
            'label' => esc_html__('Stickynav', 'colorway-addons'),
                ]
        );

        $this->add_control(
                'navs', [
            'label' => esc_html__('Nav Items', 'colorway-addons'),
            'type' => Controls_Manager::REPEATER,
            'default' => [
                [
                    'nav_title' => esc_html__('Nav #1', 'colorway-addons'),
                    'nav_link' => [
                        'url' => esc_html__('#section-1', 'colorway-addons'),
                    ]
                ],
                [
                    'nav_title' => esc_html__('Nav #2', 'colorway-addons'),
                    'nav_link' => [
                        'url' => esc_html__('#section-2', 'colorway-addons'),
                    ]
                ],
                [
                    'nav_title' => esc_html__('Nav #3', 'colorway-addons'),
                    'nav_link' => [
                        'url' => esc_html__('#section-3', 'colorway-addons'),
                    ]
                ],
                [
                    'nav_title' => esc_html__('Nav #4', 'colorway-addons'),
                    'nav_link' => [
                        'url' => esc_html__('#section-4', 'colorway-addons'),
                    ]
                ],
                [
                    'nav_title' => esc_html__('Nav #5', 'colorway-addons'),
                    'nav_link' => [
                        'url' => esc_html__('#section-5', 'colorway-addons'),
                    ]
                ],
            ],
            'fields' => [
                [
                    'name' => 'nav_title',
                    'label' => esc_html__('Nav Title', 'colorway-addons'),
                    'type' => Controls_Manager::TEXT,
                    'dynamic' => ['active' => true],
                    'default' => esc_html__('Nav Title', 'colorway-addons'),
                ],
                [
                    'name' => 'nav_link',
                    'label' => esc_html__('Link', 'colorway-addons'),
                    'type' => Controls_Manager::URL,
                    'dynamic' => ['active' => true],
                    'default' => ['url' => '#'],
                    'description' => 'Add your section id WITH the # key. e.g: #my-id also you can add internal/external URL',
                ],
                [
                    'name' => 'nav_icon',
                    'label' => esc_html__('Icon', 'colorway-addons'),
                    'type' => Controls_Manager::ICON,
                ],
            ],
            'title_field' => '{{{ nav_title }}}',
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'section_content_layout', [
            'label' => esc_html__('Layout', 'colorway-addons'),
            'tab' => Controls_Manager::TAB_CONTENT,
                ]
        );

        $this->add_responsive_control(
                'stickynav_display', [
            'label' => __('Show/Hide Nav', 'colorway-addons'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => __('on', 'colorway-addons'),
            'label_off' => __('off', 'colorway-addons'),
            'return_value' => 'on',
            'default' => 'on'
                ]
        );

        $this->add_responsive_control(
                'alignment', [
            'label' => esc_html__('Alignment', 'colorway-addons'),
            'type' => Controls_Manager::CHOOSE,
            'label_block' => false,
            'options' => [
                'left' => [
                    'title' => esc_html__('Left', 'colorway-addons'),
                    'icon' => 'fa fa-align-left',
                ],
                'center' => [
                    'title' => esc_html__('Center', 'colorway-addons'),
                    'icon' => 'fa fa-align-center',
                ],
                'right' => [
                    'title' => esc_html__('Right', 'colorway-addons'),
                    'icon' => 'fa fa-align-right',
                ],
            ],
            'default' => 'left',
            'condition' => [
                'fixed_nav!' => 'yes',
            ]
                ]
        );

        $this->add_responsive_control(
                'nav_style', [
            'label' => esc_html__('Nav Style', 'colorway-addons'),
            'type' => Controls_Manager::SELECT,
            'default' => 'default',
            'options' => [
                'default' => esc_html__('Text', 'colorway-addons'),
                'dot' => esc_html__('Dots', 'colorway-addons'),
            ]
                ]
        );

        $this->add_responsive_control(
                'tooltip_position', [
            'label' => esc_html__('Tooltip Position', 'colorway-addons'),
            'type' => Controls_Manager::SELECT,
            'default' => 'right',
            'options' => [
                'top' => esc_html__('Top', 'colorway-addons'),
                'top-left' => esc_html__('Top-Left', 'colorway-addons'),
                'top-right' => esc_html__('Top-Right', 'colorway-addons'),
                'bottom' => esc_html__('Bottom', 'colorway-addons'),
                'bottom-left' => esc_html__('Bottom-Left', 'colorway-addons'),
                'bottom-right' => esc_html__('Bottom-Right', 'colorway-addons'),
                'left' => esc_html__('Left', 'colorway-addons'),
                'right' => esc_html__('Right', 'colorway-addons'),
            ],
            'condition' => [
                'nav_style' => 'dot',
            ]
                ]
        );

        $this->add_responsive_control(
                'vertical_nav', [
            'label' => esc_html__('Vertical Nav', 'colorway-addons'),
            'type' => Controls_Manager::SWITCHER,
                ]
        );

        $this->add_responsive_control(
                'fixed_nav', [
            'label' => esc_html__('Fixed Nav', 'colorway-addons'),
            'type' => Controls_Manager::SWITCHER,
            'prefix_class' => 'ink-scrollnav-fixed-',
            'render_type' => 'template',
                ]
        );

        $this->add_responsive_control(
                'nav_position', [
            'label' => esc_html__('Nav Position', 'colorway-addons'),
            'type' => Controls_Manager::SELECT,
            'default' => 'center-left',
            'options' => colorway_addons_position(),
            'condition' => [
                'fixed_nav' => 'yes',
            ],
                ]
        );

        $this->add_responsive_control(
                'nav_offset', [
            'label' => esc_html__('Nav Offset', 'colorway-addons'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 250,
                    'step' => 5,
                ],
            ],
            'condition' => [
                'fixed_nav' => 'yes',
            ],
            'selectors' => [
                '{{WRAPPER}} .ink-scrollnav div[class*="ink-navbar"]' => 'margin: {{SIZE}}{{UNIT}};',
            ],
                ]
        );

        $this->add_responsive_control(
                'nav_spacing', [
            'label' => __('Nav Spacing', 'colorway-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '{{WRAPPER}} .ink-scrollnav ul li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_responsive_control(
                'nav_padding', [
            'label' => esc_html__('Nav Padding', 'colorway-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '{{WRAPPER}} .ink-scrollnav ul li > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

                $this->add_responsive_control(
                'menu_height', [
            'label' => esc_html__('Menu Height', 'colorway-addons'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 80,
                    'max' => 200,
                ],
            ],
            'size_units' => ['px'],
            'selectors' => [
                '{{WRAPPER}} .ink-scrollnav' => 'height: {{SIZE}}{{UNIT}};',
            ],
                ]
        );
        
        $this->add_responsive_control(
                'nav_menu_height', [
            'label' => esc_html__('Nav Menu Height', 'colorway-addons'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 20,
                    'max' => 150,
                ],
            ],
            'size_units' => ['px'],
            'selectors' => [
                '{{WRAPPER}} ul.ink-navbar-nav' => 'height: {{SIZE}}{{UNIT}};',
            ],
                ]
        );

        $this->add_responsive_control(
                'icon_align', [
            'label' => esc_html__('Icon Position', 'colorway-addons'),
            'type' => Controls_Manager::SELECT,
            'default' => 'right',
            'options' => [
                'left' => esc_html__('Before', 'colorway-addons'),
                'right' => esc_html__('After', 'colorway-addons'),
            ],
            'condition' => [
                'nav_style' => 'default',
            ],
                ]
        );

        $this->add_responsive_control(
                'icon_indent', [
            'label' => esc_html__('Icon Spacing', 'colorway-addons'),
            'type' => Controls_Manager::SLIDER,
            'default' => [
                'size' => 8,
            ],
            'range' => [
                'px' => [
                    'max' => 50,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .ink-scrollnav .ink-button-icon-align-right' => 'margin-left: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .ink-scrollnav .ink-button-icon-align-left' => 'margin-right: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                'nav_style' => 'default',
            ],
                ]
        );
        $this->add_responsive_control(
                'btn_tabs_indent', [
            'label' => esc_html__('Button/ Tabs Spacing', 'colorway-addons'),
            'type' => Controls_Manager::SLIDER,
            'default' => [
                'size' => '100',
            ],
            'range' => [
                'px' => [
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .btn-wrapper-center.btn-wrapper' => 'right: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                'nav_style' => 'default',
            ],
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'section_style_nav', [
            'label' => esc_html__('Default Nav', 'colorway-addons'),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => [
                'nav_style' => 'default',
            ],
                ]
        );

        $this->add_responsive_control(
                'navbar_style', [
            'label' => __('Navbar Style', 'colorway-addons'),
            'type' => Controls_Manager::SELECT,
            'default' => '',
            'options' => [
                '' => __('Select Style', 'colorway-addons'),
                '1' => __('Style 1', 'colorway-addons'),
                '2' => __('Style 2', 'colorway-addons'),
                '3' => __('Style 3', 'colorway-addons'),
            ],
            'prefix_class' => 'ink-navbar-style-',
                ]
        );

        $this->start_controls_tabs('tabs_nav_style');

        $this->start_controls_tab(
                'tab_nav_normal', [
            'label' => esc_html__('Normal', 'colorway-addons'),
                ]
        );

        $this->add_responsive_control(
                'nav_color', [
            'label' => esc_html__('Text Color', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .ink-scrollnav ul li > a' => 'color: {{VALUE}};',
            ],
                ]
        );

        $this->add_responsive_control(
                'nav_container_bg_color', [
            'label' => esc_html__('Background Color', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .ink-scrollnav' => 'background-color: {{VALUE}};',
            ],
                ]
        );
        $this->add_responsive_control(
                'nav_background_color', [
            'label' => esc_html__('Nav Background Color', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .ink-scrollnav ul li > a' => 'background-color: {{VALUE}};',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Border::get_type(), [
            'name' => 'nav_border',
            'label' => esc_html__('Border', 'colorway-addons'),
            'placeholder' => '1px',
            'default' => '1px',
            'selector' => '{{WRAPPER}} .ink-scrollnav ul li > a',
                ]
        );

        $this->add_responsive_control(
                'nav_border_radius', [
            'label' => esc_html__('Border Radius', 'colorway-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .ink-scrollnav ul li > a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Box_Shadow::get_type(), [
            'name' => 'nav_box_shadow',
            'selector' => '{{WRAPPER}} .ink-scrollnav ul li > a',
                ]
        );

        $this->add_responsive_control(
                'navig_margin', [
            'label' => esc_html__('Margin', 'colorway-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '{{WRAPPER}} .ink-navbar-center, .ink-navbar-right, .ink-navbar-left' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'nav_typography',
            'label' => esc_html__('Typography', 'colorway-addons'),
            'scheme' => Scheme_Typography::TYPOGRAPHY_4,
            'selector' => '{{WRAPPER}} .ink-scrollnav ul li > a',
                ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
                'tab_nav_hover', [
            'label' => esc_html__('Hover', 'colorway-addons'),
                ]
        );

        $this->add_responsive_control(
                'navbar_hover_style_color', [
            'label' => esc_html__('Style Color', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .ink-navbar-nav > li:hover > a:before' => 'background-color: {{VALUE}};',
                '{{WRAPPER}} .ink-navbar-nav > li:hover > a:after' => 'background-color: {{VALUE}};',
            ],
            'condition' => [
                'navbar_style!' => '',
            ],
                ]
        );

        $this->add_responsive_control(
                'nav_hover_color', [
            'label' => esc_html__('Text Color', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .ink-scrollnav ul li > a:hover' => 'color: {{VALUE}};',
            ],
                ]
        );

        $this->add_responsive_control(
                'nav_hover_background_color', [
            'label' => esc_html__('Background Color', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .ink-scrollnav ul li > a:hover' => 'background-color: {{VALUE}};',
            ],
                ]
        );

        $this->add_responsive_control(
                'nav_hover_border_color', [
            'label' => esc_html__('Border Color', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'condition' => [
                'nav_border_border!' => '',
            ],
            'selectors' => [
                '{{WRAPPER}} .ink-scrollnav ul li > a:hover' => 'border-color: {{VALUE}};',
            ],
                ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
                'tab_nav_active', [
            'label' => esc_html__('Active', 'colorway-addons'),
                ]
        );

        $this->add_responsive_control(
                'navbar_active_style_color', [
            'label' => esc_html__('Style Color', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .ink-navbar-nav > li.ink-active > a:before' => 'background-color: {{VALUE}};',
                '{{WRAPPER}} .ink-navbar-nav > li.ink-active > a:after' => 'background-color: {{VALUE}};',
            ],
            'condition' => [
                'navbar_style!' => '',
            ],
                ]
        );

        $this->add_responsive_control(
                'nav_active_color', [
            'label' => esc_html__('Text Color', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .ink-scrollnav ul li.ink-active > a' => 'color: {{VALUE}};',
            ],
                ]
        );

        $this->add_responsive_control(
                'nav_active_background_color', [
            'label' => esc_html__('Background Color', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .ink-scrollnav ul li.ink-active > a' => 'background-color: {{VALUE}};',
            ],
                ]
        );

        $this->add_responsive_control(
                'nav_active_border_color', [
            'label' => esc_html__('Border Color', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'condition' => [
                'nav_border_border!' => '',
            ],
            'selectors' => [
                '{{WRAPPER}} .ink-scrollnav ul li.ink-active > a' => 'border-color: {{VALUE}};',
            ],
                ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
                'section_style_dot_nav', [
            'label' => esc_html__('Dot Nav', 'colorway-addons'),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => [
                'nav_style' => 'dot',
            ],
                ]
        );

        $this->start_controls_tabs('tabs_nav_style_dot');

        $this->start_controls_tab(
                'tab_dot_nav_normal', [
            'label' => esc_html__('Normal', 'colorway-addons'),
                ]
        );

        $this->add_responsive_control(
                'dot_nav_background_color', [
            'label' => esc_html__('Background Color', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .ink-scrollnav .ink-dotnav > li > a' => 'background-color: {{VALUE}};',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Border::get_type(), [
            'name' => 'dot_nav_border',
            'label' => esc_html__('Border', 'colorway-addons'),
            'placeholder' => '1px',
            'default' => '1px',
            'selector' => '{{WRAPPER}} .ink-scrollnav .ink-dotnav > li > a',
                ]
        );

        $this->add_responsive_control(
                'dot_nav_border_radius', [
            'label' => esc_html__('Border Radius', 'colorway-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .ink-scrollnav .ink-dotnav > li > a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Box_Shadow::get_type(), [
            'name' => 'dot_nav_box_shadow',
            'selector' => '{{WRAPPER}} .ink-scrollnav .ink-dotnav > li > a',
                ]
        );

        $this->add_responsive_control(
                'dot_nav_padding', [
            'label' => esc_html__('Padding', 'colorway-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '{{WRAPPER}} .ink-scrollnav .ink-dotnav > li > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
                'tab_dot_nav_hover', [
            'label' => esc_html__('Hover', 'colorway-addons'),
                ]
        );

        $this->add_responsive_control(
                'dot_nav_hover_background_color', [
            'label' => esc_html__('Background Color', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .ink-scrollnav .ink-dotnav > li > a:hover' => 'background-color: {{VALUE}};',
            ],
                ]
        );

        $this->add_responsive_control(
                'dot_nav_hover_border_color', [
            'label' => esc_html__('Border Color', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'condition' => [
                'dot_nav_border_border!' => '',
            ],
            'selectors' => [
                '{{WRAPPER}} .ink-scrollnav .ink-dotnav > li > a:hover' => 'border-color: {{VALUE}};',
            ],
                ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
                'tab_dot_nav_active', [
            'label' => esc_html__('Active', 'colorway-addons'),
                ]
        );

        $this->add_responsive_control(
                'dot_nav_active_background_color', [
            'label' => esc_html__('Background Color', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .ink-scrollnav .ink-dotnav > li.ink-active > a' => 'background-color: {{VALUE}};',
            ],
                ]
        );

        $this->add_responsive_control(
                'dot_nav_active_border_color', [
            'label' => esc_html__('Border Color', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'condition' => [
                'dot_nav_border_border!' => '',
            ],
            'selectors' => [
                '{{WRAPPER}} .ink-scrollnav .ink-dotnav > li.ink-active > a' => 'border-color: {{VALUE}};',
            ],
                ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
        $this->start_controls_section(
                'section_content_button', [
            'label' => __('Button', 'colorway-addons'),
                ]
        );

        $this->add_responsive_control(
                'button_display', [
            'label' => __('Show/Hide Button', 'colorway-addons'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => __('on', 'colorway-addons'),
            'label_off' => __('off', 'colorway-addons'),
            'return_value' => 'on',
            'default' => 'on'
                ]
        );

        $this->add_responsive_control(
                'dual_button_size', [
            'label' => __('Button Size', 'colorway-addons'),
            'type' => Controls_Manager::SELECT,
            'default' => 'md',
            'options' => [
                'xs' => __('Extra Small', 'colorway-addons'),
                'sm' => __('Small', 'colorway-addons'),
                'md' => __('Medium', 'colorway-addons'),
                'lg' => __('Large', 'colorway-addons'),
                'xl' => __('Extra Large', 'colorway-addons'),
            ],
                ]
        );

        $this->add_responsive_control(
                'button_width', [
            'label' => __('Button Width', 'colorway-addons'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                '%' => [
                    'max' => 100,
                    'min' => 20,
                ],
                'px' => [
                    'max' => 200,
                    'min' => 80,
                ],
            ],
            'size_units' => ['%', 'px'],
            'default' => [
                'size' => 100,
                'unit' => 'px',
            ],
            'tablet_default' => [
                'size' => 80,
                'unit' => '%',
            ],
            'mobile_default' => [
                'size' => 100,
                'unit' => '%',
            ],
            'selectors' => [
                '{{WRAPPER}} .ink-dual-button' => 'width: {{SIZE}}{{UNIT}};',
            ],
                ]
        );

//        $this->add_responsive_control(
//                'show_middle_text', [
//            'label' => __('Middle Text', 'colorway-addons'),
//            'type' => Controls_Manager::SWITCHER,
//                ]
//        );
//
//        $this->add_responsive_control(
//                'middle_text', [
//            'label' => __('Text', 'colorway-addons'),
//            'type' => Controls_Manager::TEXT,
//            'dynamic' => ['active' => true],
//            'default' => __('or', 'colorway-addons'),
//            'placeholder' => __('or', 'colorway-addons'),
//            'condition' => [
//                'show_middle_text' => 'yes',
//            ],
//                ]
//        );

        $this->add_responsive_control(
                'button_a_text', [
            'label' => __('Text', 'colorway-addons'),
            'type' => Controls_Manager::TEXT,
            'dynamic' => ['active' => true],
            'default' => __('Click Me', 'colorway-addons'),
            'placeholder' => __('Click Me', 'colorway-addons'),
                ]
        );

        $this->add_responsive_control(
                'button_a_link', [
            'label' => __('Link', 'colorway-addons'),
            'type' => Controls_Manager::URL,
            'dynamic' => ['active' => true],
            'placeholder' => __('https://your-link.com', 'colorway-addons'),
            'default' => [
                'url' => '#',
            ],
                ]
        );

        $this->add_responsive_control(
                'button_a_onclick', [
            'label' => esc_html__('OnClick', 'colorway-addons'),
            'type' => Controls_Manager::SWITCHER,
                ]
        );

        $this->add_responsive_control(
                'button_a_onclick_event', [
            'label' => __('OnClick Event', 'colorway-addons'),
            'type' => Controls_Manager::TEXT,
            'placeholder' => 'myFunction()',
            'description' => sprintf(__('For details please look <a href="%s" target="_blank">here</a>'), 'https://www.w3schools.com/jsref/event_onclick.asp'),
            'condition' => [
                'button_a_onclick' => 'yes'
            ]
                ]
        );

        $this->add_responsive_control(
                'button_a_icon', [
            'label' => __('Icon', 'colorway-addons'),
            'type' => Controls_Manager::ICON,
            'label_block' => true,
                ]
        );

        $this->add_responsive_control(
                'button_a_icon_align', [
            'label' => __('Icon Position', 'colorway-addons'),
            'type' => Controls_Manager::SELECT,
            'default' => 'right',
            'options' => [
                'left' => __('Left', 'colorway-addons'),
                'right' => __('Right', 'colorway-addons'),
                'top' => __('Top', 'colorway-addons'),
                'bottom' => __('Bottom', 'colorway-addons'),
            ],
            'condition' => [
                'button_a_icon!' => '',
            ],
                ]
        );

        $this->add_responsive_control(
                'button_a_icon_indent', [
            'label' => __('Icon Spacing', 'colorway-addons'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'max' => 100,
                ],
            ],
            'default' => [
                'size' => 8,
            ],
            'condition' => [
                'button_a_icon!' => '',
            ],
            'selectors' => [
                '{{WRAPPER}} .ink-dual-button-a .ink-button-icon-align-right' => 'margin-left: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .ink-dual-button-a .ink-button-icon-align-left' => 'margin-right: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .ink-dual-button-a .ink-button-icon-align-top' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .ink-dual-button-a .ink-button-icon-align-bottom' => 'margin-top: {{SIZE}}{{UNIT}};',
            ],
                ]
        );
        
        
         $this->start_controls_tabs('tabs_dual_button_style');

        $this->start_controls_tab(
                'tab_dual_button_normal', [
            'label' => __('Normal', 'colorway-addons'),
                ]
        );

        $this->add_responsive_control(
                'button_border_style', [
            'label' => __('Border Style', 'colorway-addons'),
            'type' => Controls_Manager::SELECT,
            'default' => 'none',
            'options' => [
                'none' => __('None', 'colorway-addons'),
                'solid' => __('Solid', 'colorway-addons'),
                'dotted' => __('Dotted', 'colorway-addons'),
                'dashed' => __('Dashed', 'colorway-addons'),
                'groove' => __('Groove', 'colorway-addons'),
            ],
            'selectors' => [
                '{{WRAPPER}} .ink-dual-button a' => 'border-style: {{VALUE}};',
            ],
                ]
        );

                $this->add_responsive_control(
                'button_a_border_color', [
            'label' => __('Border Color', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'default' => '#666',
            'selectors' => [
                '{{WRAPPER}} .ink-dual-button-a' => 'border-color: {{VALUE}};',
            ],
            'condition' => [
                'button_border_style!' => 'none'
            ]
                ]
        );
                
        $this->add_responsive_control(
                'button_border_width', [
            'label' => __('Border Width', 'colorway-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'default' => [
                'top' => 3,
                'right' => 3,
                'bottom' => 3,
                'left' => 3,
            ],
            'selectors' => [
                '{{WRAPPER}} .ink-dual-button a' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'condition' => [
                'button_border_style!' => 'none'
            ]
                ]
        );

        $this->add_responsive_control(
                'dual_button_radius', [
            'label' => __('Border Radius', 'colorway-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .ink-dual-button a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Box_Shadow::get_type(), [
            'name' => 'dual_button_shadow',
            'selector' => '{{WRAPPER}} .ink-dual-button a',
                ]
        );

        $this->add_responsive_control(
                'dual_button_padding', [
            'label' => __('Padding', 'colorway-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '{{WRAPPER}} .ink-dual-button a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );
        $this->add_responsive_control(
                'dual_button_margin', [
            'label' => __('Margin', 'colorway-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'default' => [
                'top' => 18,
                'right' => 0,
                'bottom' => 0,
                'left' => 0,
                'unit' => 'px',
            ],
            'selectors' => [
                '{{WRAPPER}} .ink-dual-button a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'dual_button_typography',
            'scheme' => Scheme_Typography::TYPOGRAPHY_4,
            'selector' => '{{WRAPPER}} .ink-dual-button a',
                ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
                'tab_dual_button_hover', [
            'label' => __('Hover', 'colorway-addons'),
                ]
        );

        $this->add_responsive_control(
                'dual_button_hover_radius', [
            'label' => __('Border Radius', 'colorway-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .ink-dual-button a:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Box_Shadow::get_type(), [
            'name' => 'dual_button_hover_shadow',
            'selector' => '{{WRAPPER}} .ink-dual-button a:hover',
                ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();


        $this->start_controls_section(
                'section_content_style', [
            'label' => __('Button', 'colorway-addons'),
            'tab' => Controls_Manager::TAB_STYLE,
                ]
        );


        $this->add_responsive_control(
                'button_a_effect', [
            'label' => __('Effect', 'colorway-addons'),
            'type' => Controls_Manager::SELECT,
            'default' => 'a',
            'options' => [
                'a' => __('Effect A', 'colorway-addons'),
                'b' => __('Effect B', 'colorway-addons'),
                'c' => __('Effect C', 'colorway-addons'),
                'd' => __('Effect D', 'colorway-addons'),
                'e' => __('Effect E', 'colorway-addons'),
                'f' => __('Effect F', 'colorway-addons'),
                'g' => __('Effect G', 'colorway-addons'),
                'h' => __('Effect H', 'colorway-addons'),
                'i' => __('Effect I', 'colorway-addons'),
            ],
                ]
        );

        $this->start_controls_tabs('tabs_button_a_style');

        $this->start_controls_tab(
                'tab_button_a_normal', [
            'label' => __('Normal', 'colorway-addons'),
                ]
        );

        $this->add_responsive_control(
                'button_a_color', [
            'label' => __('Text Color', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .ink-dual-button-a' => 'color: {{VALUE}};',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Background::get_type(), [
            'name' => 'button_a_background',
            'types' => ['classic', 'gradient'],
            'selector' => '{{WRAPPER}} .ink-dual-button-a, 
		{{WRAPPER}} .ink-dual-button-a.ink-advanced-button-effect-i .ink-advanced-button-content-wrapper:after,
		{{WRAPPER}} .ink-dual-button-a.ink-advanced-button-effect-i .ink-advanced-button-content-wrapper:before',
            //'separator' => 'after',
                ]
        );


        $this->add_group_control(
                Group_Control_Box_Shadow::get_type(), [
            'name' => 'button_a_shadow',
            'selector' => '{{WRAPPER}} .ink-dual-button a.ink-dual-button-a',
                ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
                'tab_button_a_hover', [
            'label' => __('Hover', 'colorway-addons'),
                ]
        );

        $this->add_responsive_control(
                'button_a_hover_color', [
            'label' => __('Text Color', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .ink-dual-button-a:hover' => 'color: {{VALUE}};',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Background::get_type(), [
            'name' => 'button_a_hover_background',
            'types' => ['classic', 'gradient'],
            'selector' => '{{WRAPPER}} .ink-dual-button-a:after, 
		{{WRAPPER}} .ink-dual-button-a:hover,
		{{WRAPPER}} .ink-dual-button-a.ink-advanced-button-effect-i,
		{{WRAPPER}} .ink-dual-button-a.ink-advanced-button-effect-h:after',
            'separator' => 'after',
                ]
        );

        $this->add_responsive_control(
                'button_a_hover_border_color', [
            'label' => __('Border Color', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .ink-dual-button-a:hover' => 'border-color: {{VALUE}};',
            ],
            'condition' => [
                'button_border_style!' => 'none'
            ]
                ]
        );

        $this->add_group_control(
                Group_Control_Box_Shadow::get_type(), [
            'name' => 'button_a_hover_shadow',
            'selector' => '{{WRAPPER}} .ink-dual-button a.ink-dual-button-a:hover',
                ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();



        $this->start_controls_section(
                'section_style_button_a_icon', [
            'label' => __('Button Icon', 'colorway-addons'),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => [
                'button_a_icon!' => '',
            ],
                ]
        );

        $this->start_controls_tabs('tabs_button_a_icon_style');

        $this->start_controls_tab(
                'tab_button_a_icon_normal', [
            'label' => __('Normal', 'colorway-addons'),
                ]
        );

        $this->add_responsive_control(
                'button_a_icon_color', [
            'label' => __('Color', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .ink-dual-button-a .ink-dual-button-a-icon i' => 'color: {{VALUE}};',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Background::get_type(), [
            'name' => 'button_a_icon_background',
            'types' => ['classic', 'gradient'],
            'selector' => '{{WRAPPER}} .ink-dual-button-a .ink-dual-button-a-icon i',
            'separator' => 'after',
                ]
        );

        $this->add_group_control(
                Group_Control_Border::get_type(), [
            'name' => 'button_a_icon_border',
            'placeholder' => '1px',
            'default' => '1px',
            'selector' => '{{WRAPPER}} .ink-dual-button-a .ink-dual-button-a-icon i',
                ]
        );

        $this->add_responsive_control(
                'button_a_icon_padding', [
            'label' => __('Padding', 'colorway-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '{{WRAPPER}} .ink-dual-button-a .ink-dual-button-a-icon i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_responsive_control(
                'button_a_icon_radius', [
            'label' => __('Border Radius', 'colorway-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .ink-dual-button-a .ink-dual-button-a-icon i' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Box_Shadow::get_type(), [
            'name' => 'button_a_icon_shadow',
            'selector' => '{{WRAPPER}} .ink-dual-button-a .ink-dual-button-a-icon:after',
                ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
                'tab_button_a_icon_hover', [
            'label' => __('Hover', 'colorway-addons'),
                ]
        );

        $this->add_responsive_control(
                'button_a_icon_hover_color', [
            'label' => __('Color', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .ink-dual-button-a:hover .ink-dual-button-a-icon' => 'color: {{VALUE}};',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Background::get_type(), [
            'name' => 'button_a_icon_hover_background',
            'types' => ['classic', 'gradient'],
            'selector' => '{{WRAPPER}} .ink-dual-button-a:hover .ink-dual-button-a-icon:after',
            'separator' => 'after',
                ]
        );

        $this->add_responsive_control(
                'button_a_icon_hover_border_color', [
            'label' => __('Border Color', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'condition' => [
                'button_a_icon_border_border!' => '',
            ],
            'selectors' => [
                '{{WRAPPER}} .ink-dual-button-a:hover .ink-dual-button-a-icon:after' => 'border-color: {{VALUE}};',
            ],
                ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();


        $this->start_controls_section(
                'section_title', [
            'label' => __('Tabs', 'colorway-addons'),
                ]
        );

        $this->add_responsive_control(
                'tabs_display', [
            'label' => __('Show/Hide tab', 'colorway-addons'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => __('on', 'colorway-addons'),
            'label_off' => __('off', 'colorway-addons'),
            'return_value' => 'on',
            'default' => 'on'
                ]
        );

        $this->add_responsive_control(
                'tab_layout', [
            'label' => esc_html__('Layout', 'colorway-addons'),
            'type' => Controls_Manager::SELECT,
            'default' => 'default',
            'options' => [
                'default' => esc_html__('Top (Default)', 'colorway-addons'),
                'bottom' => esc_html__('Bottom', 'colorway-addons'),
                'left' => esc_html__('Left', 'colorway-addons'),
                'right' => esc_html__('Right', 'colorway-addons'),
            ],
                ]
        );

        $this->add_control(
                'tabs', [
            'label' => __('Tab Items', 'colorway-addons'),
            'type' => Controls_Manager::REPEATER,
            'default' => [
                [
                    'tab_title' => __('Tab Title', 'colorway-addons'),
                //'tab_content' => __('I am tab #1 content. Click edit button to change this text. One morning, when Gregor Samsa woke from troubled dreams, he found himself transformed in his bed into a horrible vermin.', 'colorway-addons'),
                ],
            ],
            'fields' => [
                [
                    'name' => 'tab_title',
                    'label' => __('Title', 'colorway-addons'),
                    'type' => Controls_Manager::TEXT,
                    'dynamic' => ['active' => true],
                    'default' => __('Tab Title', 'colorway-addons'),
                    'label_block' => true,
                ],
                [
                    'name' => 'tab_sub_title',
                    'label' => __('Sub Title', 'colorway-addons'),
                    'type' => Controls_Manager::TEXT,
                    'dynamic' => ['active' => true],
                    'label_block' => true,
                ],
                [
                    'name' => 'tab_icon',
                    'label' => __('Icon', 'colorway-addons'),
                    'type' => Controls_Manager::ICON,
                    'label_block' => true,
                ],
            ],
            'title_field' => '{{{ tab_title }}}',
                ]
        );

        $this->add_responsive_control(
                'item_spacing', [
            'label' => __('Tab Spacing', 'colorway-addons'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .ink-tabs' => 'margin-right: {{SIZE}}{{UNIT}};',
//                '{{WRAPPER}} .ink-tabs' => 'margin-left: {{SIZE}}{{UNIT}};',
//                '{{WRAPPER}} .ink-tab.ink-tab-left .ink-tabs-item, {{WRAPPER}} .ink-tab.ink-tab-right .ink-tabs-item' => 'padding-top: {{SIZE}}{{UNIT}};',
//                '{{WRAPPER}} .ink-tab.ink-tab-left, {{WRAPPER}} .ink-tab.ink-tab-right' => 'margin-top: -{{SIZE}}{{UNIT}};',
            ],
                ]
        );


        $this->add_responsive_control(
                'content_spacing', [
            'label' => __('Content Spacing', 'colorway-addons'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'default' => [
                'size' => 0,
            ],
            'selectors' => [
                '{{WRAPPER}} .btn-wrapper-center, .btn-wrapper-right, .btn-wrapper-left' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .btn-wrapper-center, .btn-wrapper-right, .btn-wrapper-left' => 'margin-top: {{SIZE}}{{UNIT}};',
//                '{{WRAPPER}} .ink-tabs .ink-tab-left' => 'margin-right: {{SIZE}}{{UNIT}};',
//                '{{WRAPPER}} .ink-tabs .ink-tab-right' => 'margin-left: {{SIZE}}{{UNIT}};',
            ],
                ]
        );

        $this->add_responsive_control(
                'tabs_wrap_padding', [
            'label' => __('Margin', 'colorway-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '{{WRAPPER}} .ink-tabs' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );
        
         $this->add_responsive_control(
                'title_padding', [
            'label' => __('Padding', 'colorway-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '{{WRAPPER}} a.ink-tabs-item-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Border::get_type(), [
            'name' => 'title_border',
            'placeholder' => '1px',
            'default' => '1px',
            'selector' => '{{WRAPPER}} a.ink-tabs-item-title',
                ]
        );

        $this->add_responsive_control(
                'title_radius', [
            'label' => __('Border Radius', 'colorway-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} a.ink-tabs-item-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
            ],
                ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
                'section_content_additional', [
            'label' => __('Additional', 'colorway-addons'),
                ]
        );

        $this->add_responsive_control(
                'active_item', [
            'label' => __('Active Item No', 'colorway-addons'),
            'type' => Controls_Manager::NUMBER,
            'min' => 1,
            'max' => 20,
                ]
        );

        $this->add_responsive_control(
                'tab_transition', [
            'label' => esc_html__('Transition', 'colorway-addons'),
            'type' => Controls_Manager::SELECT,
            'options' => colorway_addons_transition_options(),
            'default' => '',
                ]
        );

        $this->add_responsive_control(
                'duration', [
            'label' => __('Animation Duration', 'colorway-addons'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 1,
                    'max' => 501,
                    'step' => 50,
                ],
            ],
            'default' => [
                'size' => 200,
            ],
                ]
        );

        $this->add_responsive_control(
                'media', [
            'label' => __('Turn On Horizontal mode', 'colorway-addons'),
            'description' => __('It means that when switch to the horizontal tabs mode from vertical mode', 'colorway-addons'),
            'type' => Controls_Manager::CHOOSE,
            'options' => [
                '960' => [
                    'title' => __('On Tablet', 'colorway-addons'),
                    'icon' => 'fa fa-tablet',
                ],
                '768' => [
                    'title' => __('On Mobile', 'colorway-addons'),
                    'icon' => 'fa fa-mobile',
                ],
            ],
            'condition' => [
                'tab_layout' => ['left', 'right']
            ],
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'section_toggle_style_title', [
            'label' => __('Tabs', 'colorway-addons'),
            'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->start_controls_tabs('tabs_title_style');

        $this->start_controls_tab(
                'tab_title_normal', [
            'label' => __('Normal', 'colorway-addons'),
                ]
        );
        ;

        $this->add_group_control(
                Group_Control_Background::get_type(), [
            'name' => 'title_background',
            'types' => ['classic', 'gradient'],
            'selector' => '{{WRAPPER}} .ink-tab .ink-tabs-item-title',
            //'separator' => 'after',
                ]
        );

        $this->add_responsive_control(
                'title_color', [
            'label' => __('Text Color', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .ink-tab .ink-tabs-item-title' => 'color: {{VALUE}};',
            ],
            //'separator' => 'before',
                ]
        );

        $this->add_group_control(
                Group_Control_Box_Shadow::get_type(), [
            'name' => 'title_shadow',
            'selector' => '{{WRAPPER}} a.ink-tabs-item-title',
                ]
        );

       
        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'title_typography',
            'selector' => '{{WRAPPER}} .ink-tab .ink-tabs-item-title',
            'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
                'tab_title_active', [
            'label' => __('Active', 'colorway-addons'),
                ]
        );

        $this->add_responsive_control(
                'active_style_color', [
            'label' => __('Style Color', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .ink-active a.ink-tabs-item-title:after' => 'background-color: {{VALUE}};',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Background::get_type(), [
            'name' => 'active_title_background',
            'types' => ['classic', 'gradient'],
            'selector' => '{{WRAPPER}} .ink-active a.ink-tabs-item-title',
            'separator' => 'after',
                ]
        );

        $this->add_responsive_control(
                'active_title_color', [
            'label' => __('Text Color', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .ink-active a.ink-tabs-item-title' => 'color: {{VALUE}};',
            ],
            'separator' => 'before',
                ]
        );

        $this->add_group_control(
                Group_Control_Box_Shadow::get_type(), [
            'name' => 'active_title_shadow',
            'selector' => '{{WRAPPER}} .ink-active a.ink-tabs-item-title',
                ]
        );

        $this->add_group_control(
                Group_Control_Border::get_type(), [
            'name' => 'active_title_border',
            'placeholder' => '1px',
            'default' => '1px',
            'selector' => '{{WRAPPER}} .ink-active a.ink-tabs-item-title',
                ]
        );

        $this->add_responsive_control(
                'active_title_radius', [
            'label' => __('Border Radius', 'colorway-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .ink-active a.ink-tabs-item-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
            ],
                ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
                'section_style_sub_title', [
            'label' => __('Sub Title', 'colorway-addons'),
            'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->start_controls_tabs('tabs_sub_title_style');

        $this->start_controls_tab(
                'tab_sub_title_normal', [
            'label' => __('Normal', 'colorway-addons'),
                ]
        );


        $this->add_responsive_control(
                'sub_title_color', [
            'label' => __('Text Color', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .ink-tab .ink-tab-sub-title' => 'color: {{VALUE}};',
            ],
                ]
        );

        $this->add_responsive_control(
                'sub_title_spacing', [
            'label' => __('Spacing', 'colorway-addons'),
            'type' => Controls_Manager::SLIDER,
            'selectors' => [
                '{{WRAPPER}} .ink-tab .ink-tab-sub-title' => 'margin-top: {{SIZE}}{{UNIT}};',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'sub_title_typography',
            'selector' => '{{WRAPPER}} .ink-tab .ink-tab-sub-title',
            'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
                'tab_sub_title_active', [
            'label' => __('Active', 'colorway-addons'),
                ]
        );

        $this->add_responsive_control(
                'active_sub_title_color', [
            'label' => __('Text Color', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .ink-active .ink-tab-sub-title' => 'color: {{VALUE}};',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'active_sub_title_typography',
            'selector' => '{{WRAPPER}} .ink-active .ink-tab-sub-title',
            'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
                'section_style_icon', [
            'label' => __('Icon', 'colorway-addons'),
            'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->start_controls_tabs('tabs_icon_style');

        $this->start_controls_tab(
                'tab_icon_normal', [
            'label' => __('Normal', 'colorway-addons'),
                ]
        );

        $this->add_responsive_control(
                'icon_align1', [
            'label' => __('Alignment', 'colorway-addons'),
            'type' => Controls_Manager::CHOOSE,
            'options' => [
                'left' => [
                    'title' => __('Start', 'colorway-addons'),
                    'icon' => 'eicon-h-align-left',
                ],
                'right' => [
                    'title' => __('End', 'colorway-addons'),
                    'icon' => 'eicon-h-align-right',
                ],
            ],
            'default' => is_rtl() ? 'right' : 'left',
                ]
        );

        $this->add_responsive_control(
                'icon_color', [
            'label' => __('Color', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .ink-tabs .ink-tabs-item-title .fa:before' => 'color: {{VALUE}};',
            ],
                ]
        );

        $this->add_responsive_control(
                'icon_space', [
            'label' => __('Spacing', 'colorway-addons'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'default' => [
                'size' => 8,
            ],
            'selectors' => [
                '{{WRAPPER}} .ink-tabs .ink-tabs-item-title .ink-button-icon-align-left' => 'margin-right: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .ink-tabs .ink-tabs-item-title .ink-button-icon-align-right' => 'margin-left: {{SIZE}}{{UNIT}};',
            ],
                ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
                'tab_icon_active', [
            'label' => __('Active', 'colorway-addons'),
                ]
        );

        $this->add_responsive_control(
                'icon_active_color', [
            'label' => __('Color', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .ink-active .ink-tabs-item-title .fa:before' => 'color: {{VALUE}};',
            ],
                ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    public function render_loop_nav_list($list) {

        $settings = $this->get_settings();
        $target = ($list['nav_link']['is_external']) ? '_blank' : '_self';
        $rel = ($list['nav_link']['nofollow']) ? 'rel="nofollow"' : '';
        $tooltip = [];
        $tooltip[] = ( 'dot' == $settings['nav_style'] ) ? ' title="' . esc_html($list["nav_title"]) . '"' : '';
        $tooltip[] = ( 'dot' == $settings['nav_style'] ) ? ' ink-tooltip="pos: ' . esc_attr($settings["tooltip_position"]) . '"' : '';
        ?>
        <li>
            <a href="<?php echo esc_attr($list['nav_link']['url']); ?>" target="<?php echo esc_attr($target); ?>" <?php echo esc_attr($rel); ?> <?php echo implode(" ", $tooltip); ?>><?php echo esc_attr($list['nav_title']); ?>
                <?php if ($list['nav_icon']) : ?>
                    <span class="ink-button-icon-align-<?php echo esc_attr($settings['icon_align']); ?>">
                        <i class="<?php echo esc_attr($list['nav_icon']); ?>"></i>
                    </span>
                <?php endif; ?>
            </a>
        </li>
        <?php
    }

    public function render_text_a($settings) {

        $this->add_render_attribute('content-wrapper-a', 'class', 'ink-advanced-button-content-wrapper');
        $this->add_render_attribute('content-wrapper-a', 'class', ( 'top' == $settings['button_a_icon_align'] ) ? 'ink-flex ink-flex-column' : '' );
        $this->add_render_attribute('content-wrapper-a', 'class', ( 'bottom' == $settings['button_a_icon_align'] ) ? 'ink-flex ink-flex-column-reverse' : '' );
        $this->add_render_attribute('content-wrapper-a', 'data-text', esc_attr($settings['button_a_text']));

        $this->add_render_attribute('button-a-text', 'class', 'ink-advanced-button-text');
        ?>
        <div <?php echo $this->get_render_attribute_string('content-wrapper-a'); ?>>
            <?php if (!empty($settings['button_a_icon'])) : ?>
                <div class="ink-advanced-button-icon ink-dual-button-a-icon ink-button-icon-align-<?php echo esc_attr($settings['button_a_icon_align']); ?>">
                    <i class="<?php echo esc_attr($settings['button_a_icon']); ?>" aria-hidden="true"></i>
                </div>
            <?php endif; ?>
            <div <?php echo $this->get_render_attribute_string('button-a-text'); ?>><?php echo $settings['button_a_text']; ?></div>
        </div>
        <?php
    }

    public function render() {
        
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute('wrapper', 'class', 'ink-dual-button ink-advanced-button-wrapper ink-element');

        if (!empty($settings['button_a_link']['url'])) {
            $this->add_render_attribute('button_a', 'href', $settings['button_a_link']['url']);

            if ($settings['button_a_link']['is_external']) {
                $this->add_render_attribute('button_a', 'target', '_blank');
            }

            if ($settings['button_a_link']['nofollow']) {
                $this->add_render_attribute('button_a', 'rel', 'nofollow');
            }
        }

        if ($settings['button_a_link']['nofollow']) {
            $this->add_render_attribute('button_a', 'rel', 'nofollow');
        }

        if ('yes' === $settings['button_a_onclick']) {
            $this->add_render_attribute('button_a', 'onclick', $settings['onclick_event_a']);
        }

        $this->add_render_attribute('button_a', 'class', 'ink-dual-button-a ink-advanced-button');
        $this->add_render_attribute('button_a', 'class', 'ink-advanced-button-effect-' . esc_attr($settings['button_a_effect']));
        $this->add_render_attribute('button_a', 'class', 'ink-advanced-button-size-' . esc_attr($settings['dual_button_size']));



        $settings = $this->get_settings();
        $fixed_nav_class = [];
        $nav_class = [];
        $fixed_nav_class[] = ( 'yes' == $settings['fixed_nav'] ) ? 'ink-position-' . esc_attr($settings['nav_position']) . ' ink-position-z-index' : '';

        if ('dot' !== $settings['nav_style']) :
            $nav_class[] = ( 'yes' == $settings['vertical_nav'] ) ? 'ink-nav ink-nav-default' : 'ink-navbar-nav';
        else :
            $nav_class[] = ( 'yes' == $settings['vertical_nav'] ) ? 'ink-dotnav ink-dotnav-vertical' : 'ink-dotnav';
        endif;



        $settings = $this->get_settings_for_display();
        $id = $this->get_id();

        $this->add_render_attribute(
                [
                    'tab-settings' => [
                        'class' => [
                            'ink-tab',
                            ( '' !== $settings['tab_layout'] ) ? 'ink-tab-' . $settings['tab_layout'] : '',
                        //('' != $settings['align'] and 'left' != $settings['tab_layout'] and 'right' != $settings['tab_layout']) ? ('justify' != $settings['align']) ? 'ink-flex-' . $settings['align'] : 'ink-child-width-expand' : ''
                        ],
                        'ink-tab' => [
                            wp_json_encode(array_filter([
                                'connect' => '#ink-switcher-' . esc_attr($id),
                                'animation' => ($settings['tab_transition']) ? 'ink-animation-' . $settings['tab_transition'] : '',
                                'duration' => ($settings['duration']) ? $settings['duration']['size'] : '',
                                'media' => ($settings['media']) ? $settings['media'] : ''
                            ]))
                        ]
                    ]
                ]
        );

        $id_int = substr($this->get_id_int(), 0, 3);
        ?>
        <div class="container">
            <div class="row">
            <div class="col-md-12">
        <div class="ink-scrollnav ink-navbar-container ink-navbar-transparent ink-navbar" >
            <div class="ink-navbar-nav ink-navig-wrap ink-menu-wrap-<?php echo esc_attr($settings['alignment']); ?> ">
                <div class="col-md-7">
                <div class="ink-navbar-<?php echo esc_attr($settings['alignment']); ?>">
                    <ul class="<?php echo esc_attr(implode(" ", $nav_class)) ?>" ink-scrollspy-nav="closest: li; scroll: true;">
                        <?php
                        foreach ($settings['navs'] as $key => $nav) :
                            $this->render_loop_nav_list($nav);
                        endforeach;
                        ?>
                    </ul>
                </div>
                </div>
                <div class="col-md-5">
                <div class="btn-wrapper-<?php echo esc_attr($settings['alignment']); ?> btn-wrapper">
                    <div class="col-md-9">
                    <div id="ink-tabs-<?php echo esc_attr($id); ?>" class="ink-tabs ink-tab-nav-<?php echo esc_attr($settings['alignment']); ?>">
                        <?php
                        if ('left' == $settings['tab_layout'] or 'right' == $settings['tab_layout']) {
                            echo '<div class="ink-grid-collapse"  ink-grid>';

                            $this->add_render_attribute(
                                    [
                                        'switcher-width' => [
                                            'class' => [
                                                'ink-switcher-wrapper',
                                                'ink-width-expand@m'
                                            ]
                                        ]
                                    ]
                            );

                            $this->add_render_attribute(
                                    [
                                        'tabs-width' => [
                                            'class' => [
                                                'ink-tab-wrapper',
                                                'ink-width-auto@m',
                                                ( 'right' == $settings['tab_layout'] ) ? ' ink-flex-last@m' : ''
                                            ]
                                        ]
                                    ]
                            );
                        }
                        ?>


                        <div <?php echo ( $this->get_render_attribute_string('tabs-width') ); ?>>
                            <div <?php echo ( $this->get_render_attribute_string('tab-settings') ); ?>>
                                <?php
                                foreach ($settings['tabs'] as $index => $item) :
//						$tab_count   = $index + 1;
//						$this->add_render_attribute(
//							[
//								'tabs-item' => [
//									'class' => [
//										'ink-tabs-item',
//										$item['tab_title'] ? '' : 'ink-has-no-title',
//										($tab_count === $settings['active_item']) ? 'ink-active' : ''
//									]
//								]
//							], '', '', true
//						);
                                    ?>
                                    <div <?php echo ( $this->get_render_attribute_string('tabs-item') ); ?>>
                                        <a class="ink-tabs-item-title" href="#">
                                            <div class="ink-tab-text-wrapper ink-flex-column">

                                                <div class="ink-tab-title-icon-wrapper">
                                                    <?php if ('' != $item['tab_icon'] and 'left' == $settings['icon_align1']) : ?>
                                                        <span class="ink-button-icon-align-<?php echo esc_html($settings['icon_align1']); ?>">
                                                            <i class="<?php echo esc_attr($item['tab_icon']); ?>"></i>
                                                        </span>
                                                    <?php endif; ?>

                                                    <?php if ($item['tab_title']) : ?>
                                                        <span class="ink-tab-text"><?php echo $item['tab_title']; ?></span>
                                                    <?php endif; ?>

                                                    <?php if ('' != $item['tab_icon'] and 'right' == $settings['icon_align1']) : ?>
                                                        <span class="ink-button-icon-align-<?php echo esc_html($settings['icon_align1']); ?>">
                                                            <i class="<?php echo esc_attr($item['tab_icon']); ?>"></i>
                                                        </span>
                                                    <?php endif; ?>
                                                </div>

                                                <?php if ($item['tab_sub_title'] and $item['tab_title']) : ?>
                                                    <span class="ink-tab-sub-title ink-text-small"><?php echo $item['tab_sub_title']; ?></span>
                                                <?php endif; ?>

                                            </div>
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>



                        <?php
                        if ('left' == $settings['tab_layout'] or 'right' == $settings['tab_layout']) {
                            echo "</div>";
                        }
                        ?>
                    </div>
                    </div>
                    

                    <div class="col-md-3">
                    <div class="ink-element-align-wrapper ink-btn-<?php echo esc_attr($settings['alignment']); ?>">
                        <div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
                            <a <?php echo $this->get_render_attribute_string('button_a'); ?>>
                                <?php $this->render_text_a($settings); ?>
                            </a>

                            <?php //if ('yes' === $settings['show_middle_text']) : ?>
<!--                                <span><?php //echo esc_attr($settings['middle_text']); ?></span>-->
                            <?php //endif; ?>

                        </div>
                    </div>
                    </div>
                    
                    
                    
                </div>
                </div>
            </div>
        </div>
        </div>
        </div>
        </div>
        

        <?php
        $settings = $this->get_settings_for_display();
        if ('on' === $settings['stickynav_display']) {
            echo '<style> .ink-scrollnav {
                            display: block;}</style>';
        } else {
            echo '<style> .ink-sticky-fixed .ink-scrollnav{
                             display: block;}
                          .ink-scrollnav {
                             display: none;}    
                 </style>';
        }

        if ('on' === $settings['tabs_display']) {
            echo '<style> .ink-tabs {
                            display: block;}</style>';
        } else {
            echo '<style> .ink-tabs {
                             display: none;}    
                 </style>';
        }
        if ('on' === $settings['button_display']) {
            echo '<style> .ink-element-align-wrapper {
                            display: block;}</style>';
        } else {
            echo '<style> .ink-element-align-wrapper {
                             display: none;}  

                 </style>';
        }
    }

}
