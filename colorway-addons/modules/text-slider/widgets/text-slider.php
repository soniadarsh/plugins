<?php

namespace CwAddons\Modules\TextSlider\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use CwAddons\Modules\QueryControl\Controls\Group_Control_Posts;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * Class Slider
 */

class TextSlider extends Widget_Base {

    /**
     * @var \WP_Query
     */
    private $_query = null;
    protected $_has_template_content = false;

    public function get_name() {
        return 'ink-slider';
    }

    public function get_title() {
        return esc_html__('Text Slider', 'colorway-addons');
    }

    public function get_icon() {
        return 'ink-widget-icon fas fa-ticket-alt';
    }

    public function get_categories() {
        return ['colorway-addons'];
    }

    public function get_script_depends() {
        return ['imagesloaded'];
    }

    public function on_import($element) {
        if (!get_post_type_object($element['settings']['posts_post_type'])) {
            $element['settings']['posts_post_type'] = 'services';
        }

        return $element;
    }

    public function on_export($element) {
        $element = Group_Control_Posts::on_export_remove_setting_from_element($element, 'posts');
        return $element;
    }

    protected function _register_controls() {
        $this->start_controls_section(
                'section_content_sliders', [
            'label' => esc_html__('Sliders', 'colorway-addons'),
                ]
        );

        $this->add_control(
                'tabs', [
            'label' => esc_html__('Slider Items', 'colorway-addons'),
            'type' => Controls_Manager::REPEATER,
            'default' => [
                [
                    'tab_title' => esc_html__('Slider No. 1', 'colorway-addons'),
                    'tab_content' => esc_html__('Get ready to edit, customize and style this design driven slider to complete the look of your homepage!', 'colorway-addons'),
                ],
                [
                    'tab_title' => esc_html__('Slider No. 2', 'colorway-addons'),
                    'tab_content' => esc_html__('Get ready to edit, customize and style this design driven slider to complete the look of your homepage!', 'colorway-addons'),
                ],
                [
                    'tab_title' => esc_html__('Slider No. 3', 'colorway-addons'),
                    'tab_content' => esc_html__('Get ready to edit, customize and style this design driven slider to complete the look of your homepage!', 'colorway-addons'),
                ],
                [
                    'tab_title' => esc_html__('Slider No. 4', 'colorway-addons'),
                    'tab_content' => esc_html__('Get ready to edit, customize and style this design driven slider to complete the look of your homepage!', 'colorway-addons'),
                ],
            ],
            'fields' => [
                [
                    'name' => 'tab_title',
                    'label' => esc_html__('Title', 'colorway-addons'),
                    'type' => Controls_Manager::TEXT,
                    'dynamic' => ['active' => true],
                    'default' => esc_html__('Slide Title', 'colorway-addons'),
                    'label_block' => true,
                ],
                [
                    'name' => 'tab_image',
                    'label' => esc_html__('Image', 'colorway-addons'),
                    'type' => Controls_Manager::MEDIA,
                    'dynamic' => ['active' => true],
                ],
                [
                    'name' => 'tab_content',
                    'label' => esc_html__('Content', 'colorway-addons'),
                    'type' => Controls_Manager::WYSIWYG,
                    'dynamic' => ['active' => true],
                    'default' => esc_html__('Slide Content', 'colorway-addons'),
                    'show_label' => false,
                ],
                [
                    'name' => 'tab_link',
                    'label' => esc_html__('Link', 'colorway-addons'),
                    'type' => Controls_Manager::URL,
                    'dynamic' => ['active' => true],
                    'placeholder' => 'http://your-link.com',
                    'default' => [
                        'url' => '#',
                    ],
                ],
            ],
            'title_field' => '{{{ tab_title }}}',
                ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
                'section_content_layout', [
            'label' => esc_html__('Layout', 'colorway-addons'),
                ]
        );

        $this->add_responsive_control(
                'height', [
            'label' => esc_html__('Height', 'colorway-addons'),
            'type' => Controls_Manager::SLIDER,
            'default' => [
                'size' => 600,
            ],
            'range' => [
                'px' => [
                    'min' => 50,
                    'max' => 1024,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .ink-slider .ink-slide-item' => 'height: {{SIZE}}{{UNIT}};',
            ],
                ]
        );

        $this->add_control(
                'origin', [
            'label' => esc_html__('Origin', 'colorway-addons'),
            'type' => Controls_Manager::SELECT,
            'default' => 'center',
            'options' => colorway_addons_position(),
                ]
        );

        $this->add_responsive_control(
                'align', [
            'label' => esc_html__('Alignment', 'colorway-addons'),
            'type' => Controls_Manager::CHOOSE,
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
                'justify' => [
                    'title' => esc_html__('Justified', 'colorway-addons'),
                    'icon' => 'fa fa-align-justify',
                ],
            ],
            'prefix_class' => 'elementor%s-align-',
            'description' => 'Use align to match position',
            'default' => 'center',
                ]
        );

        $this->add_control(
                'show_title', [
            'label' => esc_html__('Show Title', 'colorway-addons'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
                ]
        );


        $this->add_control(
                'show_button', [
            'label' => esc_html__('Show Button', 'colorway-addons'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
                ]
        );

        $this->add_control(
                'scroll_to_section', [
            'label' => esc_html__('Scroll to Section', 'colorway-addons'),
            'type' => Controls_Manager::SWITCHER,
                ]
        );

        $this->add_control(
                'section_id', [
            'label' => esc_html__('Section ID', 'colorway-addons'),
            'type' => Controls_Manager::TEXT,
            'placeholder' => 'Section ID Here',
            'description' => 'Enter section ID of this page, ex: #my-section',
            'label_block' => true,
            'condition' => [
                'scroll_to_section' => 'yes',
            ],
                ]
        );

        $this->add_control(
                'scroll_to_section_icon', [
            'label' => esc_html__('Scroll to Section Icon', 'colorway-addons'),
            'type' => Controls_Manager::ICON,
            'label_block' => true,
            'default' => 'fa fa-angle-double-down',
            'condition' => [
                'scroll_to_section' => 'yes',
            ],
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'section_content_slider_settings', [
            'label' => esc_html__('Slider Settings', 'colorway-addons'),
                ]
        );


        $this->add_control(
                'hide_arrows', [
            'label' => esc_html__('Hide arrows on mobile devices?', 'colorway-addons'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'condition' => [
                'navigation' => ['arrows', 'both'],
            ],
                ]
        );

        $this->add_control(
                'transition', [
            'label' => esc_html__('Transition', 'colorway-addons'),
            'type' => Controls_Manager::SELECT,
            'default' => 'slide',
            'options' => [
                'slide' => esc_html__('Slide', 'colorway-addons'),
                'fade' => esc_html__('Fade', 'colorway-addons'),
                'cube' => esc_html__('Cube', 'colorway-addons'),
                'coverflow' => esc_html__('Coverflow', 'colorway-addons'),
                'flip' => esc_html__('Flip', 'colorway-addons'),
            ],
                ]
        );

        $this->add_control(
                'effect', [
            'label' => esc_html__('Text Effect', 'colorway-addons'),
            'type' => Controls_Manager::SELECT,
            'default' => 'slide',
            'options' => [
                'left' => esc_html__('Slide Right to Left', 'colorway-addons'),
                'bottom' => esc_html__('Slider Bottom to Top', 'colorway-addons'),
            ],
                ]
        );

        $this->add_control(
                'autoplay', [
            'label' => esc_html__('Autoplay', 'colorway-addons'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
                ]
        );

        $this->add_control(
                'autoplay_speed', [
            'label' => esc_html__('Autoplay Speed', 'colorway-addons'),
            'type' => Controls_Manager::NUMBER,
            'default' => 5000,
            'condition' => [
                'autoplay' => 'yes',
            ],
                ]
        );

        $this->add_control(
                'infinite', [
            'label' => esc_html__('Infinite Loop', 'colorway-addons'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
                ]
        );

        $this->add_control(
                'speed', [
            'label' => esc_html__('Animation Speed', 'colorway-addons'),
            'type' => Controls_Manager::NUMBER,
            'default' => 500,
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'section_content_button', [
            'label' => esc_html__('Button', 'colorway-addons'),
            'condition' => [
                'show_button' => 'yes',
            ],
                ]
        );

        $this->add_control(
                'button_text', [
            'label' => esc_html__('Button Text', 'colorway-addons'),
            'type' => Controls_Manager::TEXT,
            'default' => esc_html__('Read More', 'colorway-addons'),
            'placeholder' => esc_html__('Read More', 'colorway-addons'),
                ]
        );

        $this->add_control(
                'icon', [
            'label' => esc_html__('Icon', 'colorway-addons'),
            'type' => Controls_Manager::ICON,
            'label_block' => true,
                ]
        );

        $this->add_control(
                'icon_align', [
            'label' => esc_html__('Icon Position', 'colorway-addons'),
            'type' => Controls_Manager::SELECT,
            'default' => 'right',
            'options' => [
                'left' => esc_html__('Before', 'colorway-addons'),
                'right' => esc_html__('After', 'colorway-addons'),
            ],
            'condition' => [
                'icon!' => '',
            ],
                ]
        );

        $this->add_control(
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
            'condition' => [
                'icon!' => '',
            ],
            'selectors' => [
                '{{WRAPPER}} .ink-slider .ink-button-icon-align-right' => 'margin-left: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .ink-slider .ink-button-icon-align-left' => 'margin-right: {{SIZE}}{{UNIT}};',
            ],
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'section_style_slider', [
            'label' => esc_html__('Slider', 'colorway-addons'),
            'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_control(
                'slider_background_color', [
            'label' => esc_html__('Background Color', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'default' => '#293d4f',
            'selectors' => [
                '{{WRAPPER}} .ink-slider .ink-slide-item' => 'background-color: {{VALUE}};',
            ],
                ]
        );

        $this->add_responsive_control(
                'content_padding', [
            'label' => esc_html__('Padding', 'colorway-addons'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 200,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .ink-slider .ink-slide-item .ink-slide-desc' => 'margin: {{SIZE}}{{UNIT}};',
            ],
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'section_style_title', [
            'label' => esc_html__('Title', 'colorway-addons'),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => [
                'show_title' => ['yes'],
            ],
                ]
        );

        $this->add_control(
                'title_color', [
            'label' => esc_html__('Color', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .ink-slider .ink-slide-item .ink-slide-title' => 'color: {{VALUE}};',
            ],
                ]
        );

        $this->add_control(
                'title_background', [
            'label' => esc_html__('Background', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .ink-slider .ink-slide-item .ink-slide-title' => 'background-color: {{VALUE}};',
            ],
                ]
        );

        $this->add_control(
                'title_padding', [
            'label' => esc_html__('Padding', 'colorway-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '{{WRAPPER}} .ink-slider .ink-slide-item .ink-slide-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'title_typography',
            'label' => esc_html__('Typography', 'colorway-addons'),
            'scheme' => Scheme_Typography::TYPOGRAPHY_4,
            'selector' => '{{WRAPPER}} .ink-slider .ink-slide-item .ink-slide-title',
                ]
        );

        $this->add_responsive_control(
                'title_space', [
            'label' => esc_html__('Space', 'colorway-addons'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .ink-slider .ink-slide-item .ink-slide-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'section_style_text', [
            'label' => esc_html__('Text', 'colorway-addons'),
            'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_control(
                'text_color', [
            'label' => esc_html__('Text Color', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .ink-slider .ink-slide-item .ink-slide-text' => 'color: {{VALUE}};',
            ],
                ]
        );

        $this->add_control(
                'text_background', [
            'label' => esc_html__('Background', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .ink-slider .ink-slide-item .ink-slide-text' => 'background-color: {{VALUE}};',
            ],
                ]
        );

        $this->add_control(
                'text_padding', [
            'label' => esc_html__('Padding', 'colorway-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '{{WRAPPER}} .ink-slider .ink-slide-item .ink-slide-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'text_typography',
            'label' => esc_html__('Text Typography', 'colorway-addons'),
            'scheme' => Scheme_Typography::TYPOGRAPHY_4,
            'selector' => '{{WRAPPER}} .ink-slider .ink-slide-item .ink-slide-text',
                ]
        );

        $this->add_responsive_control(
                'text_space', [
            'label' => esc_html__('Text Space', 'colorway-addons'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .ink-slider .ink-slide-item .ink-slide-text' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'section_style_button', [
            'label' => esc_html__('Button', 'colorway-addons'),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => [
                'show_button' => 'yes',
            ],
                ]
        );

        $this->start_controls_tabs('tabs_button_style');

        $this->start_controls_tab(
                'tab_button_normal', [
            'label' => esc_html__('Normal', 'colorway-addons'),
                ]
        );

        $this->add_control(
                'button_text_color', [
            'label' => esc_html__('Text Color', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .ink-slider .ink-slide-item .ink-slide-link' => 'color: {{VALUE}};',
            ],
                ]
        );

        $this->add_control(
                'background_color', [
            'label' => esc_html__('Background Color', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .ink-slider .ink-slide-item .ink-slide-link' => 'background-color: {{VALUE}};',
            ],
                ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
                'tab_button_hover', [
            'label' => esc_html__('Hover', 'colorway-addons'),
                ]
        );

        $this->add_control(
                'hover_color', [
            'label' => esc_html__('Text Color', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .ink-slider .ink-slide-item .ink-slide-link:hover' => 'color: {{VALUE}};',
            ],
                ]
        );

        $this->add_control(
                'button_background_hover_color', [
            'label' => esc_html__('Background Color', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .ink-slider .ink-slide-item .ink-slide-link:hover' => 'background-color: {{VALUE}};',
            ],
                ]
        );

        $this->add_control(
                'button_hover_border_color', [
            'label' => esc_html__('Border Color', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'condition' => [
                'border_border!' => '',
            ],
            'selectors' => [
                '{{WRAPPER}} .ink-slider .ink-slide-item .ink-slide-link:hover' => 'border-color: {{VALUE}};',
            ],
                ]
        );

        $this->add_control(
                'button_hover_animation', [
            'label' => esc_html__('Animation', 'colorway-addons'),
            'type' => Controls_Manager::HOVER_ANIMATION,
                ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
                Group_Control_Border::get_type(), [
            'name' => 'border',
            'label' => esc_html__('Border', 'colorway-addons'),
            'placeholder' => '1px',
            'default' => '1px',
            'selector' => '{{WRAPPER}} .ink-slider .ink-slide-item .ink-slide-link',
            'separator' => 'before',
                ]
        );

        $this->add_control(
                'border_radius', [
            'label' => esc_html__('Border Radius', 'colorway-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .ink-slider .ink-slide-item .ink-slide-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Box_Shadow::get_type(), [
            'name' => 'button_box_shadow',
            'selector' => '{{WRAPPER}} .ink-slider .ink-slide-item .ink-slide-link',
                ]
        );

        $this->add_control(
                'button_padding', [
            'label' => esc_html__('Padding', 'colorway-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '{{WRAPPER}} .ink-slider .ink-slide-item .ink-slide-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'separator' => 'before',
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'typography',
            'label' => esc_html__('Typography', 'colorway-addons'),
            'scheme' => Scheme_Typography::TYPOGRAPHY_4,
            'selector' => '{{WRAPPER}} .ink-slider .ink-slide-item .ink-slide-link',
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'section_style_navigation', [
            'label' => __('Navigation', 'colorway-addons'),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => [
                'navigation' => ['arrows', 'dots', 'both'],
            ],
                ]
        );

        $this->add_control(
                'heading_style_arrows', [
            'label' => __('Arrows', 'colorway-addons'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
            'condition' => [
                'navigation' => ['arrows', 'both'],
            ],
                ]
        );

        $this->add_control(
                'navigation', [
            'label' => esc_html__('Navigation', 'colorway-addons'),
            'type' => Controls_Manager::SELECT,
            'default' => 'both',
            'options' => [
                'both' => esc_html__('Arrows and Dots', 'colorway-addons'),
                'arrows' => esc_html__('Arrows', 'colorway-addons'),
                'dots' => esc_html__('Dots', 'colorway-addons'),
                'none' => esc_html__('None', 'colorway-addons'),
            ],
            'frontend_available' => true,
                ]
        );


        $this->add_control(
                'next_arrow_icon', [
            'label' => __('Arrow Icons', 'colorway-addons'),
            'type' => \Elementor\Controls_Manager::ICON,
            'include' => [
                'fas fa-angle-right',
                'fas fa-caret-right',
            ],
            'default' => 'fas fa-caret-right',
                ]
        );

        $this->add_control(
                'arrow_color', [
            'label' => esc_html__('Arrow Color', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .ink-slider .swiper-button-prev1 i.fa, .ink-slider .swiper-button-next1 i.fa' => 'color: {{VALUE}};',
            ],
            'default' => '#fff',
                ]
        );

        $this->add_control(
                'arrow_bg_color', [
            'label' => esc_html__('Arrow Background Color', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .ink-slider .swiper-button-prev1, .ink-slider .swiper-button-next1' => 'background-color: {{VALUE}};',
            ],
                ]
        );

        $this->add_control(
                'arrows_position', [
            'label' => __('Arrows Position', 'colorway-addons'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => -100,
                    'max' => 100,
                ],
            ],
            'default' => [
                'size' => 10,
            ],
            'selectors' => [
                '{{WRAPPER}} .ink-slider .swiper-button-next1' => 'right: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .ink-slider .swiper-button-prev1' => 'left: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                'navigation' => ['arrows', 'both'],
            ],
                ]
        );
        $this->add_control(
                'arrows_size', [
            'label' => __('Arrows Size', 'colorway-addons'),
            'type' => Controls_Manager::SLIDER,
            'default' => [
                'size' => 35,
            ],
            'range' => [
                'px' => [
                    'min' => 25,
                    'max' => 80,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .ink-slider .swiper-button-next1 i.fa, .ink-slider .swiper-button-prev1 i.fa' => 'font-size: {{SIZE}}{{UNIT}}',
            ],
            'condition' => [
                'navigation' => ['arrows', 'both'],
            ],
                ]
        );
        
        $this->add_control(
                'arrows_bg_size', [
            'label' => __('Arrows Background Size', 'colorway-addons'),
            'type' => Controls_Manager::SLIDER,
            'default' => [
                'size' => 35,
            ],
            'range' => [
                'px' => [
                    'min' => 25,
                    'max' => 80,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .ink-slider .swiper-button-next1, .ink-slider .swiper-button-prev1' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}',
            ],
            'condition' => [
                'navigation' => ['arrows', 'both'],
            ],
                ]
        );

        $this->add_control(
                'btn_border_color', [
            'label' => esc_html__('Arrow background Border Color', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'default' => 'fff',
            'selectors' => [
                '{{WRAPPER}} .ink-slider .swiper-button-next1, .ink-slider .swiper-button-prev1' => 'border-color: {{VALUE}};',
            ],
                ]
        );

        $this->add_control(
                'btn_bg_border', [
            'label' => esc_html__('Arrow background Border', 'colorway-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .ink-slider .swiper-button-next1, .ink-slider .swiper-button-prev1' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_control(
                'btn_bg_radius', [
            'label' => esc_html__('Border Radius', 'colorway-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .ink-slider .swiper-button-next1, .ink-slider .swiper-button-prev1' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_responsive_control(
                'arrows_padding', [
            'label' => esc_html__('Padding', 'colorway-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'selectors' => [
                '{{WRAPPER}} .ink-slider .swiper-button-prev1 i.fa' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                '{{WRAPPER}} .ink-slider .swiper-button-next1 i.fa' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'condition' => [
                'navigation!' => ['none', 'thumbnavs', 'dots'],
            ],
                ]
        );
        
        $this->add_control(
                'heading_style_dots', [
            'label' => __('Dots', 'colorway-addons'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
            'condition' => [
                'navigation' => ['dots', 'both'],
            ],
                ]
        );

        $this->add_control(
                'dots_color', [
            'label' => __('Dots Color', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'selectors' => [
                '{{WRAPPER}} .ink-slider .swiper-pagination-bullet' => 'background-color: {{VALUE}}',
            ],
            'condition' => [
                'navigation' => ['dots', 'both'],
            ],
                ]
        );

        $this->add_control(
                'active_dot_color', [
            'label' => __('Active Dot Color', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'selectors' => [
                '{{WRAPPER}} .ink-slider .swiper-pagination-bullet-active' => 'background-color: {{VALUE}}',
            ],
            'condition' => [
                'navigation' => ['dots', 'both'],
            ],
                ]
        );

        $this->add_control(
                'dots_position', [
            'label' => __('Dots Position', 'colorway-addons'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => -80,
                    'max' => 80,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .ink-slider .swiper-pagination-bullets' => 'bottom: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                'navigation' => ['dots', 'both'],
            ],
                ]
        );

        $this->add_control(
                'dots_size', [
            'label' => __('Dots Size', 'colorway-addons'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 5,
                    'max' => 10,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .ink-slider .swiper-pagination-bullet' => 'height: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                'navigation' => ['dots', 'both'],
            ],
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'section_style_scroll_to_top', [
            'label' => esc_html__('Scroll to Top', 'colorway-addons'),
            'tab' => Controls_Manager::TAB_STYLE,
            'conditions' => [
                'terms' => [
                    [
                        'name' => 'scroll_to_section',
                        'value' => 'yes',
                    ],
                    [
                        'name' => 'section_id',
                        'operator' => '!=',
                        'value' => '',
                    ],
                ],
            ],
                ]
        );

        $this->start_controls_tabs('tabs_scroll_to_top_style');

        $this->start_controls_tab(
                'scroll_to_top_normal', [
            'label' => esc_html__('Normal', 'colorway-addons'),
                ]
        );

        $this->add_control(
                'scroll_to_top_color', [
            'label' => esc_html__('Color', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .ink-slider .ink-ep-scroll-to-section a' => 'color: {{VALUE}};',
            ],
                ]
        );

        $this->add_control(
                'scroll_to_top_background', [
            'label' => esc_html__('Background', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .ink-slider .ink-ep-scroll-to-section a' => 'background-color: {{VALUE}};',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Box_Shadow::get_type(), [
            'name' => 'scroll_to_top_shadow',
            'selector' => '{{WRAPPER}} .ink-slider .ink-ep-scroll-to-section a',
                ]
        );

        $this->add_group_control(
                Group_Control_Border::get_type(), [
            'name' => 'scroll_to_top_border',
            'label' => esc_html__('Border', 'colorway-addons'),
            'placeholder' => '1px',
            'default' => '1px',
            'selector' => '{{WRAPPER}} .ink-slider .ink-ep-scroll-to-section a',
            'separator' => 'before',
                ]
        );

        $this->add_control(
                'scroll_to_top_radius', [
            'label' => esc_html__('Border Radius', 'colorway-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .ink-slider .ink-ep-scroll-to-section a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_responsive_control(
                'scroll_to_top_padding', [
            'label' => esc_html__('Padding', 'colorway-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '{{WRAPPER}} .ink-slider .ink-ep-scroll-to-section a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_responsive_control(
                'scroll_to_top_icon_size', [
            'label' => esc_html__('Icon Size', 'colorway-addons'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 10,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .ink-slider .ink-ep-scroll-to-section a' => 'font-size: {{SIZE}}px;',
            ],
                ]
        );

        $this->add_responsive_control(
                'scroll_to_top_bottom_space', [
            'label' => esc_html__('Bottom Space', 'colorway-addons'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 300,
                    'step' => 5,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .ink-slider .ink-ep-scroll-to-section' => 'margin-bottom: {{SIZE}}px;',
            ],
                ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
                'scroll_to_top_hover', [
            'label' => esc_html__('Hover', 'colorway-addons'),
                ]
        );

        $this->add_control(
                'scroll_to_top_hover_color', [
            'label' => esc_html__('Color', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .ink-slider .ink-ep-scroll-to-section a:hover' => 'color: {{VALUE}};',
            ],
                ]
        );

        $this->add_control(
                'scroll_to_top_hover_background', [
            'label' => esc_html__('Background', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .ink-slider .ink-ep-scroll-to-section a:hover' => 'background-color: {{VALUE}};',
            ],
                ]
        );

        $this->add_control(
                'scroll_to_top_hover_border_color', [
            'label' => esc_html__('Border Color', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'condition' => [
                'scroll_to_top_border_border!' => '',
            ],
            'selectors' => [
                '{{WRAPPER}} .ink-slider .ink-ep-scroll-to-section a:hover' => 'border-color: {{VALUE}};',
            ],
                ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function render_loop_header() {
        $settings = $this->get_settings();
        $id = 'ink-slider-' . $this->get_id();

        $this->add_render_attribute('slider', 'id', $id);
        $this->add_render_attribute('slider', 'class', 'ink-slider');
        ?>
        <div <?php echo $this->get_render_attribute_string('slider'); ?>>
            <div class="swiper-container">
                <?php if ($settings['scroll_to_section'] && $settings['section_id']): ?>
                    <div class="ink-ep-scroll-to-section ink-position-bottom-center">
                        <a href="<?php echo esc_url($settings['section_id']); ?>">
                            <span class="ink-ep-scroll-to-section-icon">
                                <i class="<?php echo esc_attr($settings['scroll_to_section_icon']); ?>"></i>
                            </span>
                        </a>
                    </div>
                <?php endif; ?>
                <?php
            }

            protected function render_loop_footer() {
                $settings = $this->get_settings_for_display();
                $id = 'ink-slider-' . $this->get_id();
                $hide_arrows = ( 'yes' == $settings['hide_arrows'] ) ? ' ink-visible@m' : '';
                ?>
            </div>

            <?php if ('none' !== $settings['navigation']) : ?>
                <?php if ('arrows' !== $settings['navigation']) : ?>
                    <div class="swiper-pagination"></div>
                <?php endif; ?>

                <?php
                if ('dots' !== $settings['navigation']) :
//                    $nav_style = ($settings['arrows_style'] == 'light') ? 'swiper-button-white' : 'swiper-button-black';
                    ?>
                    <?php
                    if ($settings['next_arrow_icon']) :
                        $input = $settings['next_arrow_icon'];
                        $result_rt = explode('-', $input);
                        ?>
                        <div class="swiper-button-next1 ink-navigation-next <?php echo esc_attr($nav_style . $hide_arrows); ?>"><a class="ink-swiper-next"><i class="<?php echo "fa fa-" . esc_attr($result_rt[1]) . "-right"; ?>"></a></i></div>
                    <?php endif; ?>
                    <?php
                    if ($settings['next_arrow_icon']) :
                        $input = $settings['next_arrow_icon'];
                        $result_lt = explode('-', $input);
                        ?>
                        <div class="swiper-button-prev1 ink-navigation-prev <?php echo esc_attr($nav_style . $hide_arrows); ?>"><a class="ink-swiper-next"><i class="<?php echo "fa fa-" . esc_attr($result_lt[1]) . "-left"; ?>"></a></i></div>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endif; ?>

        </div>

        <script>
            jQuery(document).ready(function ($) {
                "use strict";
                var swiper = new Swiper("#<?php echo esc_attr($id); ?> .swiper-container", {
                    navigation: {
                        nextEl: "#<?php echo esc_attr($id); ?> .ink-navigation-next",
                        prevEl: "#<?php echo esc_attr($id); ?> .ink-navigation-prev",
                    },
                    pagination: {
                        el: "#<?php echo esc_attr($id); ?> .swiper-pagination",
                        type: 'bullets',
                        clickable: true,
                    },
                    "autoplay": <?php echo ($settings['autoplay'] == 'yes') ? '{ "delay": ' . $settings['autoplay_speed'] . ' }' : 'false'; ?>,
                    "loop": <?php echo ($settings['infinite'] == 'yes') ? 'true' : 'false'; ?>,
                    "speed": <?php echo esc_attr($settings['speed']); ?>,
                    "slidesPerView": 1,
                    "spaceBetween": 0,
                    "effect": "<?php echo esc_attr($settings['transition']); ?>",
                });
            });
        </script>

        <?php
    }

    public function render() {
        $settings = $this->get_settings_for_display();
        $url = $target = $link_title = '';
        $classes = ['ink-slide-item', 'swiper-slide'];
        $classes[] = 'ink-slide-effect-' . $settings['effect'];

        $animation = ($settings['button_hover_animation']) ? ' elementor-animation-' . $settings['button_hover_animation'] : '';


        $this->render_loop_header();
        ?>
        <div class="swiper-wrapper">
            <?php $counter = 1; ?>
            <?php foreach ($settings['tabs'] as $item) : ?>

                <?php
                $image_src = wp_get_attachment_image_src($item['tab_image']['id'], 'full');
                $image = ($image_src) ? $image_src[0] : '';
                ?>

                <div class="<?php echo implode(" ", $classes); ?>" style="background-image: url('<?php echo $image; ?>');">

                    <div class="ink-slide-desc ink-position-large ink-position-<?php echo ($settings['origin']); ?> ink-position-z-index">

                        <?php if (( '' !== $item['tab_title'] ) && ( 'yes' == $settings['show_title'] )) : ?>
                            <h2 class="ink-slide-title ink-clearfix"><?php echo wp_kses_post($item['tab_title']); ?></h2>
                        <?php endif; ?>

                        <?php if ('' !== $item['tab_content']) : ?>
                            <div class="ink-slide-text"><?php echo $this->parse_text_editor($item['tab_content']); ?></div>
                        <?php endif; ?>

                        <?php if ((!empty($item['tab_link']['url'])) && ( 'yes' == $settings['show_button'] )): ?>
                            <div class="ink-slide-link-wrapper">
                                <a href="<?php echo esc_url($item['tab_link']['url']); ?>" target="<?php echo esc_attr($item['tab_link']['is_external']); ?>" class="ink-slide-link<?php echo esc_attr($animation); ?>"><?php echo esc_html($settings['button_text']); ?>

                                    <?php if ($settings['icon']) : ?>
                                        <span class="ink-button-icon-align-<?php echo esc_attr($settings['icon_align']); ?>">
                                            <i class="<?php echo esc_attr($settings['icon']); ?>"></i>
                                        </span>
                                    <?php endif; ?>
                                </a>
                            </div>
                        <?php endif; ?>

                    </div>

                </div>
                <?php
                $counter++;
            endforeach;
            ?>
        </div>
        <?php
        $this->render_loop_footer();
    }

}
