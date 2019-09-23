<?php

namespace CwAddons\Modules\AdvancedSlider\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Utils;
use Elementor\Group_Control_Background;
use CwAddons\Modules\QueryControl\Controls\Group_Control_Posts;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class AdvancedSlider extends Widget_Base {

    private $_query = null;
    protected $_has_template_content = false;

    public function get_name() {
        return 'ink-slideshow';
    }

    public function get_title() {
        return esc_html__('Advanced Slider', 'colorway-addons');
    }

    public function get_icon() {
        return 'ink-widget-icon fas fa-pallet';
    }

    public function get_categories() {
        return ['colorway-addons'];
    }

    public function get_script_depends() {
        return ['imagesloaded', 'ink-uikit-icons'];
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

    public function get_query() {
        return $this->_query;
    }

    protected function _register_controls() {
        $this->register_query_section_controls();
    }

    private function register_query_section_controls() {

        $this->start_controls_section(
                'section_content_sliders', [
            'label' => esc_html__('Sliders', 'colorway-addons'),
                ]
        );

        $this->add_control(
                'slides', [
            'label' => esc_html__('Slider Items', 'colorway-addons'),
            'type' => Controls_Manager::REPEATER,
            'default' => [
                [
                    'title' => esc_html__('Slider No. 1', 'colorway-addons'),
                    'button_link' => ['url' => '#'],
                ],
                [
                    'title' => esc_html__('Slider No. 2', 'colorway-addons'),
                    'button_link' => ['url' => '#'],
                ],
                [
                    'title' => esc_html__('Slider No. 3', 'colorway-addons'),
                    'button_link' => ['url' => '#'],
                ],
                [
                    'title' => esc_html__('Slider No. 4', 'colorway-addons'),
                    'button_link' => ['url' => '#'],
                ],
            ],
            'fields' => [
                [
                    'name' => 'pre_title',
                    'label' => esc_html__('Pre Title', 'colorway-addons'),
                    'type' => Controls_Manager::TEXT,
                    'dynamic' => ['active' => true],
                    'default' => esc_html__('Slider Pre Title', 'colorway-addons'),
                    'label_block' => true,
                ],
                [
                    'name' => 'title',
                    'label' => esc_html__('Title', 'colorway-addons'),
                    'type' => Controls_Manager::TEXT,
                    'dynamic' => ['active' => true],
                    'default' => esc_html__('Slider Title', 'colorway-addons'),
                    'label_block' => true,
                ],
                [
                    'name' => 'post_title',
                    'label' => esc_html__('Post Title', 'colorway-addons'),
                    'type' => Controls_Manager::TEXT,
                    'dynamic' => ['active' => true],
                    'label_block' => true,
                ],
                [
                    'name' => 'background',
                    'label' => esc_html__('Background', 'colorway-addons'),
                    'type' => Controls_Manager::CHOOSE,
                    'default' => 'color',
                    'options' => [
                        'color' => [
                            'title' => esc_html__('Color', 'colorway-addons'),
                            'icon' => 'fa fa-paint-brush',
                        ],
                        'image' => [
                            'title' => esc_html__('Image', 'colorway-addons'),
                            'icon' => 'fa fa-picture-o',
                        ],
                        'video' => [
                            'title' => esc_html__('Video', 'colorway-addons'),
                            'icon' => 'fa fa-play-circle',
                        ],
                        'youtube' => [
                            'title' => esc_html__('Youtube', 'colorway-addons'),
                            'icon' => 'fa fa-youtube',
                        ],
                    ],
                ],
                [
                    'name' => 'color',
                    'label' => esc_html__('Color', 'colorway-addons'),
                    'type' => Controls_Manager::COLOR,
                    'default' => '#293d4f',
                    'condition' => [
                        'background' => 'color'
                    ],
                    'selectors' => [
                        '{{WRAPPER}} {{CURRENT_ITEM}}' => 'background-color: {{VALUE}}',
                    ],
                ],
                [
                    'name' => 'image',
                    'label' => esc_html__('Image', 'colorway-addons'),
                    'type' => Controls_Manager::MEDIA,
                    'dynamic' => ['active' => true],
                    'default' => [
                        'url' => Utils::get_placeholder_image_src(),
                    ],
                    'condition' => [
                        'background' => 'image'
                    ],
                ],
                [
                    'name' => 'video_link',
                    'label' => esc_html__('Video Link', 'colorway-addons'),
                    'type' => Controls_Manager::TEXT,
                    'condition' => [
                        'background' => 'video'
                    ],
                    'default' => '//www.quirksmode.org/html5/videos/big_buck_bunny.mp4',
                ],
                [
                    'name' => 'youtube_link',
                    'label' => esc_html__('Youtube Link', 'colorway-addons'),
                    'type' => Controls_Manager::TEXT,
                    'condition' => [
                        'background' => 'youtube'
                    ],
                    'default' => 'https://youtu.be/YE7VzlLtp-4',
                ],
                [
                    'name' => 'button_link',
                    'label' => esc_html__('Button Link', 'colorway-addons'),
                    'type' => Controls_Manager::URL,
                    'dynamic' => ['active' => true],
                    'separator' => 'before',
                    'placeholder' => 'https://inkthemes.com',
                ],
                [
                    'name' => 'text',
                    'label' => esc_html__('Text', 'colorway-addons'),
                    'type' => Controls_Manager::TEXTAREA,
                    'dynamic' => ['active' => true],
                    'default' => esc_html__('Get ready to edit, customize and style this design driven slider to complete the look of your homepage!', 'colorway-addons'),
                    'show_label' => false,
                ],
            ],
            'title_field' => '{{{ title }}}',
                ]
        );
        
//        		$this->add_group_control(
//			Group_Control_Background::get_type(),
//			[
//				'name'      => 'signup_btn_icon_background',
//				'types'     => [ 'classic', 'gradient' ],
//				'selector'  => '{{WRAPPER}} li.ink-slideshow-item.ink-active.ink-transition-active',
//				'separator' => 'after',
//			]
//		);

        $this->end_controls_section();

        $this->start_controls_section(
                'section_content_layout', [
            'label' => esc_html__('Layout', 'colorway-addons'),
                ]
        );

        $this->add_control(
                'content_position', [
            'label' => esc_html__('Content Position', 'colorway-addons'),
            'type' => Controls_Manager::SELECT,
            'default' => 'center',
            'options' => colorway_addons_position(),
                ]
        );

        $this->add_responsive_control(
                'content_align', [
            'label' => esc_html__('Content Alignment', 'colorway-addons'),
            'type' => Controls_Manager::CHOOSE,
            'default' => 'center',
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
                ]
        );

        $this->add_control(
                'show_pre_title', [
            'label' => esc_html__('Show Pre Title', 'colorway-addons'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
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
                'title_tag', [
            'label' => esc_html__('Title HTML Tag', 'colorway-addons'),
            'type' => Controls_Manager::SELECT,
            'options' => colorway_addons_title_tags(),
            'default' => 'h1',
            'condition' => [
                'show_title' => 'yes',
            ],
                ]
        );

        $this->add_control(
                'show_post_title', [
            'label' => esc_html__('Show Post Title', 'colorway-addons'),
            'type' => Controls_Manager::SWITCHER,
                ]
        );

        $this->add_control(
                'show_text', [
            'label' => esc_html__('Show Text', 'colorway-addons'),
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
                'slider_size_ratio', [
            'label' => esc_html__('Size Ratio', 'colorway-addons'),
            'type' => Controls_Manager::IMAGE_DIMENSIONS,
            'description' => 'Slider ratio to widht and height, such as 16:9',
                ]
        );

        $this->add_control(
                'slider_min_height', [
            'label' => esc_html__('Minimum Height', 'colorway-addons'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 50,
                    'max' => 1024,
                ],
            ],
                ]
        );

        $this->add_control(
                'slideshow_fullscreen', [
            'label' => esc_html__('Slideshow Fullscreen', 'colorway-addons'),
            'type' => Controls_Manager::SWITCHER,
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
                '{{WRAPPER}} .ink-slideshow .ink-slideshow-button-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .ink-slideshow .ink-slideshow-button-icon-left' => 'margin-right: {{SIZE}}{{UNIT}};',
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

        $this->add_responsive_control(
                'content_width', [
            'label' => esc_html__('Content Width', 'colorway-addons'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 50,
                    'max' => 1500,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .ink-slideshow .ink-slideshow-content-wrapper' => 'max-width: {{SIZE}}{{UNIT}};',
            ],
                ]
        );

        $this->add_control(
                'overlay', [
            'label' => esc_html__('Overlay', 'colorway-addons'),
            'type' => Controls_Manager::SELECT,
            'default' => 'none',
            'options' => [
                'none' => esc_html__('None', 'colorway-addons'),
                'background' => esc_html__('Background', 'colorway-addons'),
                'blend' => esc_html__('Blend', 'colorway-addons'),
            ],
                ]
        );

//        $this->add_control(
//                'overlay_color', [
//            'label' => esc_html__('Overlay Color', 'colorway-addons'),
//            'type' => Controls_Manager::COLOR,
//            'condition' => [
//                'overlay' => ['background', 'blend']
//            ],
//            'selectors' => [
//                '{{WRAPPER}} .ink-slideshow .ink-overlay-default' => 'background-color: {{VALUE}};'
//            ]
//                ]
//        );
        
                		$this->add_group_control(
                Group_Control_Background::get_type(), [
            'name' => 'overlay_color',
            'label' => esc_html__('Overlay Color', 'colorway-addons'),
            'types' => ['gradient'],
            'selector' => '{{WRAPPER}} .ink-slideshow .ink-overlay-default',
            'separator' => 'after',
            'condition' => [
                'overlay' => ['background', 'blend']
            ],
                ]
        );

        $this->add_control(
                'blend_type', [
            'label' => esc_html__('Blend Type', 'colorway-addons'),
            'type' => Controls_Manager::SELECT,
            'default' => 'multiply',
            'options' => colorway_addons_blend_options(),
            'condition' => [
                'overlay' => 'blend',
            ],
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'section_style_pre_title', [
            'label' => esc_html__('Pre Title', 'colorway-addons'),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => [
                'show_pre_title' => ['yes'],
            ],
                ]
        );

        $this->add_control(
                'pre_title_color', [
            'label' => esc_html__('Color', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .ink-slideshow .ink-slideshow-items .ink-slideshow-pre-title' => 'color: {{VALUE}};',
            ],
                ]
        );

        $this->add_control(
                'pre_title_background', [
            'label' => esc_html__('Background', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .ink-slideshow .ink-slideshow-items .ink-slideshow-pre-title' => 'background-color: {{VALUE}};',
            ],
                ]
        );

        $this->add_responsive_control(
                'pre_title_padding', [
            'label' => esc_html__('Padding', 'colorway-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '{{WRAPPER}} .ink-slideshow .ink-slideshow-items .ink-slideshow-pre-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_responsive_control(
                'pre_title_radius', [
            'label' => esc_html__('Radius', 'colorway-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '{{WRAPPER}} .ink-slideshow .ink-slideshow-items .ink-slideshow-pre-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'pre_title_typography',
            'label' => esc_html__('Typography', 'colorway-addons'),
            'scheme' => Scheme_Typography::TYPOGRAPHY_4,
            'selector' => '{{WRAPPER}} .ink-slideshow .ink-slideshow-items .ink-slideshow-pre-title',
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
                '{{WRAPPER}} .ink-slideshow .ink-slideshow-items .ink-slideshow-title' => 'color: {{VALUE}};',
            ],
                ]
        );

        $this->add_control(
                'title_background', [
            'label' => esc_html__('Background', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .ink-slideshow .ink-slideshow-items .ink-slideshow-title' => 'background-color: {{VALUE}};',
            ],
                ]
        );

        $this->add_responsive_control(
                'title_padding', [
            'label' => esc_html__('Padding', 'colorway-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '{{WRAPPER}} .ink-slideshow .ink-slideshow-items .ink-slideshow-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_responsive_control(
                'title_radius', [
            'label' => esc_html__('Radius', 'colorway-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '{{WRAPPER}} .ink-slideshow .ink-slideshow-items .ink-slideshow-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'title_typography',
            'label' => esc_html__('Typography', 'colorway-addons'),
            'scheme' => Scheme_Typography::TYPOGRAPHY_4,
            'selector' => '{{WRAPPER}} .ink-slideshow .ink-slideshow-items .ink-slideshow-title',
                ]
        );

        $this->add_responsive_control(
                'title_space', [
            'label' => esc_html__('Top Space', 'colorway-addons'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .ink-slideshow .ink-slideshow-items .ink-slideshow-title' => 'margin-top: {{SIZE}}{{UNIT}};',
            ],
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'section_style_post_title', [
            'label' => esc_html__('Post Title', 'colorway-addons'),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => [
                'show_post_title' => 'yes',
            ],
                ]
        );

        $this->add_control(
                'post_title_color', [
            'label' => esc_html__('Color', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .ink-slideshow .ink-slideshow-items .ink-slideshow-post-title' => 'color: {{VALUE}};',
            ],
                ]
        );

        $this->add_control(
                'post_title_background', [
            'label' => esc_html__('Background', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .ink-slideshow .ink-slideshow-items .ink-slideshow-post-title' => 'background-color: {{VALUE}};',
            ],
                ]
        );

        $this->add_responsive_control(
                'post_title_padding', [
            'label' => esc_html__('Padding', 'colorway-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '{{WRAPPER}} .ink-slideshow .ink-slideshow-items .ink-slideshow-post-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_responsive_control(
                'post_title_radius', [
            'label' => esc_html__('Radius', 'colorway-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '{{WRAPPER}} .ink-slideshow .ink-slideshow-items .ink-slideshow-post-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'post_title_typography',
            'label' => esc_html__('Typography', 'colorway-addons'),
            'scheme' => Scheme_Typography::TYPOGRAPHY_4,
            'selector' => '{{WRAPPER}} .ink-slideshow .ink-slideshow-items .ink-slideshow-post-title',
                ]
        );

        $this->add_responsive_control(
                'post_title_space', [
            'label' => esc_html__('Top Space', 'colorway-addons'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .ink-slideshow .ink-slideshow-items .ink-slideshow-post-title' => 'margin-top: {{SIZE}}{{UNIT}};',
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
                '{{WRAPPER}} .ink-slideshow .ink-slideshow-items .ink-slideshow-text' => 'color: {{VALUE}};',
            ],
                ]
        );

        $this->add_control(
                'text_background', [
            'label' => esc_html__('Background', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .ink-slideshow .ink-slideshow-items .ink-slideshow-text' => 'background-color: {{VALUE}};',
            ],
                ]
        );

        $this->add_responsive_control(
                'text_padding', [
            'label' => esc_html__('Padding', 'colorway-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '{{WRAPPER}} .ink-slideshow .ink-slideshow-items .ink-slideshow-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'text_typography',
            'label' => esc_html__('Text Typography', 'colorway-addons'),
            'scheme' => Scheme_Typography::TYPOGRAPHY_4,
            'selector' => '{{WRAPPER}} .ink-slideshow .ink-slideshow-items .ink-slideshow-text',
                ]
        );

        $this->add_responsive_control(
                'text_space', [
            'label' => esc_html__('Top Space', 'colorway-addons'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .ink-slideshow .ink-slideshow-items .ink-slideshow-text' => 'margin-top: {{SIZE}}{{UNIT}};',
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
                'button_normal', [
            'label' => esc_html__('Normal', 'colorway-addons'),
                ]
        );

        $this->add_control(
                'button_text_color', [
            'label' => esc_html__('Text Color', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .ink-slideshow .ink-slideshow-items .ink-slideshow-button' => 'color: {{VALUE}};',
            ],
                ]
        );

        $this->add_control(
                'background_color', [
            'label' => esc_html__('Background Color', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .ink-slideshow .ink-slideshow-items .ink-slideshow-button' => 'background-color: {{VALUE}};',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Box_Shadow::get_type(), [
            'name' => 'button_box_shadow',
            'selector' => '{{WRAPPER}} .ink-slideshow .ink-slideshow-items .ink-slideshow-button',
                ]
        );

        $this->add_group_control(
                Group_Control_Border::get_type(), [
            'name' => 'border',
            'label' => esc_html__('Border', 'colorway-addons'),
            'placeholder' => '1px',
            'default' => '1px',
            'selector' => '{{WRAPPER}} .ink-slideshow .ink-slideshow-items .ink-slideshow-button',
            'separator' => 'before',
                ]
        );

        $this->add_control(
                'border_radius', [
            'label' => esc_html__('Border Radius', 'colorway-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .ink-slideshow .ink-slideshow-items .ink-slideshow-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_responsive_control(
                'button_padding', [
            'label' => esc_html__('Padding', 'colorway-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '{{WRAPPER}} .ink-slideshow .ink-slideshow-items .ink-slideshow-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'separator' => 'before',
                ]
        );
        
        $this->add_responsive_control(
                'button_margin', [
            'label' => esc_html__('Button Margin', 'colorway-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '{{WRAPPER}} a.ink-slideshow-button.ink-display-inline-block' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'separator' => 'before',
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'typography',
            'label' => esc_html__('Typography', 'colorway-addons'),
            'scheme' => Scheme_Typography::TYPOGRAPHY_4,
            'selector' => '{{WRAPPER}} .ink-slideshow .ink-slideshow-items .ink-slideshow-button',
                ]
        );

        $this->add_responsive_control(
                'button_top_space', [
            'label' => esc_html__('Top Space', 'colorway-addons'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .ink-slideshow .ink-slideshow-items .ink-slideshow-button' => 'margin-top: {{SIZE}}{{UNIT}};',
            ],
                ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
                'button_hover', [
            'label' => esc_html__('Hover', 'colorway-addons'),
                ]
        );

        $this->add_control(
                'hover_color', [
            'label' => esc_html__('Text Color', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .ink-slideshow .ink-slideshow-items .ink-slideshow-button:hover' => 'color: {{VALUE}};',
            ],
                ]
        );

        $this->add_control(
                'button_background_hover_color', [
            'label' => esc_html__('Background Color', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .ink-slideshow .ink-slideshow-items .ink-slideshow-button:hover' => 'background-color: {{VALUE}};',
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
                '{{WRAPPER}} .ink-slideshow .ink-slideshow-items .ink-slideshow-button:hover' => 'border-color: {{VALUE}};',
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

        $this->end_controls_section();

        $this->start_controls_section(
                'section_style_navigation', [
            'label' => __('Navigation', 'colorway-addons'),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => [
                'navigation' => ['arrows', 'dots', 'both', 'arrows-thumbnavs', 'thumbnavs'],
            ],
                ]
        );

        $this->add_control(
                'heading_arrows', [
            'label' => esc_html__('Arrows', 'colorway-addons'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'after',
            'condition' => [
                'navigation!' => ['none', 'thumbnavs', 'dots'],
            ],
                ]
        );

        $this->add_control(
                'navigation', [
            'label' => esc_html__('Navigation', 'colorway-addons'),
            'type' => Controls_Manager::SELECT,
            'default' => 'arrows',
            'options' => [
                'both' => esc_html__('Arrows and Dots', 'colorway-addons'),
                'arrows-thumbnavs' => esc_html__('Arrows and Thumbnavs', 'colorway-addons'),
                'arrows' => esc_html__('Arrows', 'colorway-addons'),
                'dots' => esc_html__('Dots', 'colorway-addons'),
                'thumbnavs' => esc_html__('Thumbnavs', 'colorway-addons'),
                'none' => esc_html__('None', 'colorway-addons'),
            ],
                ]
        );

        $this->add_control(
                'both_position', [
            'label' => __('Arrows and Dots Position', 'colorway-addons'),
            'type' => Controls_Manager::SELECT,
            'default' => 'center',
            'options' => colorway_addons_navigation_position(),
            'condition' => [
                'navigation' => 'both',
            ],
                ]
        );

        $this->add_control(
                'arrows_position', [
            'label' => __('Arrows Position', 'colorway-addons'),
            'type' => Controls_Manager::SELECT,
            'default' => 'center',
            'options' => colorway_addons_navigation_position(),
            'condition' => [
//                'navigation' => ['arrows', 'arrows-thumbnavs'],
                'navigation!' => ['dots', 'thumbnavs', 'none', 'both'],
            ],
                ]
        );

        $this->add_control(
                'dots_position', [
            'label' => __('Dots Position', 'colorway-addons'),
            'type' => Controls_Manager::SELECT,
            'default' => 'bottom-center',
            'options' => colorway_addons_pagination_position(),
            'condition' => [
                'navigation' => 'dots',
            ],
                ]
        );

        $this->add_control(
                'thumbnavs_position', [
            'label' => esc_html__('Thumbnavs Position', 'colorway-addons'),
            'type' => Controls_Manager::SELECT,
            'default' => 'bottom-center',
            'options' => colorway_addons_thumbnavs_position(),
            'condition' => [
                'navigation!' => ['arrows', 'dots', 'both', 'none'],
            ],
                ]
        );

        $this->add_control(
                'thumbnavs_outside', [
            'label' => esc_html__('Thumbnavs Outside', 'colorway-addons'),
            'type' => Controls_Manager::SWITCHER,
            'conditions' => [
                'terms' => [
                    [
                        'name' => 'navigation',
                        'operator' => 'in',
                        'value' => ['thumbnavs', 'arrows-thumbnavs'],
                    ],
                    [
                        'name' => 'thumbnavs_position',
                        'operator' => 'in',
                        'value' => ['center-left', 'center-right'],
                    ],
                ],
            ],
                ]
        );

        $this->add_responsive_control(
                'thumbnavs_width', [
            'label' => esc_html__('Thumbnavs Width', 'colorway-addons'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 20,
                    'max' => 200,
                ],
            ],
            'default' => [
                'size' => 110,
            ],
            'selectors' => [
                '{{WRAPPER}} .ink-slideshow-thumbnav a' => 'width: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                //'navigation' => ['thumbnavs', 'arrows-thumbnavs']
                'navigation!' => ['both', 'dots', 'none', 'arrows']
            ],
                ]
        );

        $this->add_responsive_control(
                'thumbnavs_height', [
            'label' => esc_html__('Thumbnavs Height', 'colorway-addons'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 20,
                    'max' => 200,
                ],
            ],
            'default' => [
                'size' => 80,
            ],
            'selectors' => [
                '{{WRAPPER}} .ink-slideshow-thumbnav a' => 'height: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
//                'navigation' => ['thumbnavs', 'arrows-thumbnavs']
                'navigation!' => ['both', 'dots', 'none', 'arrows']
            ],
                ]
        );

        $this->add_control(
                'arrow_icon', [
            'label' => __('Arrow Icons', 'colorway-addons'),
            'type' => \Elementor\Controls_Manager::ICON,
            'include' => [
                'fas fa-angle-right',
                'fas fa-caret-right',
                'fas fa-arrow-right',
//                'fas fa-angle-double-right'
            ],
            'default' => 'fas fa-caret-right',
                ]
        );

        $this->add_control(
                'arrow_color', [
            'label' => esc_html__('Arrow Color', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .ink-slideshow .ink-navigation-prev i.fa, .ink-slideshow .ink-navigation-next i.fa' => 'color: {{VALUE}};',
            ],
            'default' => '#fff',
                ]
        );

        $this->add_control(
                'arrows_hover_color', [
            'label' => __('Arrow Hover Color', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .ink-slideshow .ink-navigation-prev :hover i.fa, {{WRAPPER}} .ink-slideshow .ink-navigation-next:hover i.fa' => 'color: {{VALUE}}',
            ],
            'condition' => [
                'navigation!' => ['none', 'thumbnavs', 'dots'],
            ],
                ]
        );

        $this->add_control(
                'arrow_bg_color', [
            'label' => esc_html__('Arrow Background Color', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .ink-slideshow .ink-navigation-prev, .ink-slideshow .ink-navigation-next' => 'background-color: {{VALUE}};',
            ],
                ]
        );

        $this->add_control(
                'arrows_hover_background', [
            'label' => __('Arrow Hover Background Color', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .ink-slideshow .ink-navigation-prev:hover, .ink-slideshow .ink-navigation-next:hover' => 'background-color: {{VALUE}}',
            ],
            'condition' => [
                'navigation!' => ['none', 'thumbnavs', 'dots'],
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
                '{{WRAPPER}} .ink-slideshow .ink-navigation-next i.fa, .ink-slideshow .ink-navigation-prev i.fa' => 'font-size: {{SIZE}}{{UNIT}}',
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
                    'min' => 40,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .ink-slideshow .ink-slidenav-next, .ink-slideshow .ink-slidenav-previous' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}',
            ],
            'condition' => [
                'navigation' => ['arrows', 'both'],
            ],
                ]
        );


        $this->add_control(
                'btn_border_color', [
            'label' => esc_html__('Arrow Background Border Color', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
//            'default' => 'fff',
            'selectors' => [
                '{{WRAPPER}} .ink-slideshow .ink-navigation-next, .ink-slideshow .ink-navigation-prev' => 'border-color: {{VALUE}};',
            ],
                ]
        );

        $this->add_control(
                'btn_bg_border', [
            'label' => esc_html__('Arrow Background Border', 'colorway-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .ink-slideshow .ink-navigation-next, .ink-slideshow .ink-navigation-prev' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_control(
                'btn_bg_radius', [
            'label' => esc_html__('Border Radius', 'colorway-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .ink-slideshow .ink-navigation-next, .ink-slideshow .ink-navigation-prev' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_responsive_control(
                'arrows_padding', [
            'label' => esc_html__('Padding', 'colorway-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'selectors' => [
                '{{WRAPPER}} .ink-slideshow .ink-navigation-prev i.fa' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                '{{WRAPPER}} .ink-slideshow .ink-navigation-next i.fa' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'condition' => [
                'navigation!' => ['none', 'thumbnavs', 'dots'],
            ],
                ]
        );

        $this->add_control(
                'arrows_space', [
            'label' => __('Space', 'colorway-addons'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .ink-slideshow .ink-navigation-prev' => 'margin-right: {{SIZE}}px;',
                '{{WRAPPER}} .ink-slideshow .ink-navigation-next' => 'margin-left: {{SIZE}}px;',
            ],
            'conditions' => [
                'terms' => [
                    [
                        'name' => 'navigation',
                        'value' => 'both',
                    ],
                    [
                        'name' => 'both_position',
                        'operator' => '!=',
                        'value' => 'center',
                    ],
                ],
            ],
                ]
        );

        $this->add_control(
                'heading_dots', [
            'label' => esc_html__('Dots', 'colorway-addons'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'after',
            'condition' => [
                'navigation!' => ['arrows', 'arrows-thumbnavs', 'thumbnavs', 'none'],
            ],
                ]
        );

        $this->add_control(
                'dots_size', [
            'label' => __('Size', 'colorway-addons'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 5,
                    'max' => 20,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .ink-slideshow .ink-dotnav li a' => 'height: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                'navigation!' => ['arrows', 'arrows-thumbnavs', 'thumbnavs', 'none'],
            ],
                ]
        );

        $this->add_control(
                'dots_color', [
            'label' => __('Color', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .ink-slideshow .ink-dotnav li a' => 'background-color: {{VALUE}}',
            ],
            'condition' => [
                'navigation!' => ['arrows', 'arrows-thumbnavs', 'thumbnavs', 'none'],
            ],
                ]
        );

        $this->add_control(
                'active_dot_color', [
            'label' => __('Active Color', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .ink-slideshow .ink-dotnav li.ink-active a' => 'background-color: {{VALUE}}',
            ],
            'condition' => [
                'navigation!' => ['arrows', 'arrows-thumbnavs', 'thumbnavs', 'none'],
            ],
                ]
        );

        $this->add_control(
                'heading_thumbnavs', [
            'label' => esc_html__('Thumbnavs', 'colorway-addons'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'after',
            'condition' => [
                'navigation!' => ['arrows', 'dots', 'both', 'none'],
            ],
                ]
        );

        $this->start_controls_tabs('tabs_thumbnavs_style');

        $this->start_controls_tab(
                'tab_thumbnavs_normal', [
            'label' => esc_html__('Normal', 'colorway-addons'),
            'condition' => [
                'navigation!' => ['arrows', 'dots', 'both', 'none'],
            ],
                ]
        );

        $this->add_control(
                'thumbnavs_background', [
            'label' => esc_html__('Background', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .ink-slideshow-thumbnav a' => 'background-color: {{VALUE}};',
            ],
            'condition' => [
                'navigation!' => ['arrows', 'dots', 'both', 'none'],
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Box_Shadow::get_type(), [
            'name' => 'thumbnavs_shadow',
            'selector' => '{{WRAPPER}} .ink-slideshow-thumbnav a',
            'condition' => [
                'navigation!' => ['arrows', 'dots', 'both', 'none'],
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Border::get_type(), [
            'name' => 'thumbnavs_border',
            'label' => esc_html__('Border', 'colorway-addons'),
            'placeholder' => '1px',
            'default' => '1px',
            'selector' => '{{WRAPPER}} .ink-slideshow-thumbnav a',
            'condition' => [
                'navigation!' => ['arrows', 'dots', 'both', 'none'],
            ],
                ]
        );

        $this->add_control(
                'thumbnavs_radius', [
            'label' => esc_html__('Border Radius', 'colorway-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .ink-slideshow-thumbnav a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
            ],
            'condition' => [
                'navigation!' => ['arrows', 'dots', 'both', 'none'],
            ],
                ]
        );

        $this->add_control(
                'thumbnavs_spacing', [
            'label' => esc_html__('Space Between', 'colorway-addons'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .ink-thumbnav:not(.ink-thumbnav-vertical) > *' => 'padding-left: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .ink-thumbnav:not(.ink-thumbnav-vertical)' => 'margin-left: -{{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .ink-thumbnav-vertical > *' => 'padding-top: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .ink-thumbnav-vertical' => 'margin-top: -{{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                'navigation!' => ['arrows', 'dots', 'both', 'none'],
            ],
                ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
                'tab_thumbnavs_hover', [
            'label' => esc_html__('Hover', 'colorway-addons'),
            'condition' => [
                'navigation!' => ['arrows', 'dots', 'both', 'none'],
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Box_Shadow::get_type(), [
            'name' => 'thumbnavs_hover_shadow',
            'selector' => '{{WRAPPER}} .ink-slideshow-thumbnav a:hover',
            'condition' => [
                'navigation!' => ['arrows', 'dots', 'both', 'none'],
            ],
                ]
        );

        $this->add_control(
                'thumbnavs_hover_border_color', [
            'label' => esc_html__('Border Color', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'condition' => [
                'thumbnavs_border_border!' => '',
            ],
            'selectors' => [
                '{{WRAPPER}} .ink-slideshow-thumbnav a:hover' => 'border-color: {{VALUE}};',
            ],
            'condition' => [
                'navigation!' => ['arrows', 'dots', 'both', 'none'],
            ],
                ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
                'heading_position', [
            'label' => esc_html__('Position', 'colorway-addons'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'after',
            'condition' => [
                'navigation!' => 'none',
            ],
                ]
        );

        $this->add_control(
                'arrows_ncx_position', [
            'label' => __('Arrows Horizontal Offset', 'colorway-addons'),
            'type' => Controls_Manager::SLIDER,
            'default' => [
                'size' => 0,
            ],
            'range' => [
                'px' => [
                    'min' => -200,
                    'max' => 200,
                ],
            ],
            'conditions' => [
                'terms' => [
                    [
                        'name' => 'navigation',
                        'operator' => 'in',
                        'value' => ['arrows', 'arrows-thumbnavs'],
                    ],
                    [
                        'name' => 'arrows_position',
                        'operator' => '!=',
                        'value' => 'center',
                    ],
                ],
            ],
                ]
        );

        $this->add_control(
                'arrows_ncy_position', [
            'label' => __('Arrows Vertical Offset', 'colorway-addons'),
            'type' => Controls_Manager::SLIDER,
            'default' => [
                'size' => 40,
            ],
            'range' => [
                'px' => [
                    'min' => -200,
                    'max' => 200,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .ink-slideshow .ink-arrows-container' => 'transform: translate({{arrows_ncx_position.size}}px, {{SIZE}}px);',
            ],
            'conditions' => [
                'terms' => [
                    [
                        'name' => 'navigation',
                        'operator' => 'in',
                        'value' => ['arrows', 'arrows-thumbnavs'],
                    ],
                    [
                        'name' => 'arrows_position',
                        'operator' => '!=',
                        'value' => 'center',
                    ],
                ],
            ],
                ]
        );

        $this->add_control(
                'arrows_acx_position', [
            'label' => __('Arrows Horizontal Offset', 'colorway-addons'),
            'type' => Controls_Manager::SLIDER,
            'default' => [
                'size' => 20,
            ],
            'range' => [
                'px' => [
                    'min' => -200,
                    'max' => 200,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .ink-slideshow .ink-navigation-prev' => 'left: {{SIZE}}px;',
                '{{WRAPPER}} .ink-slideshow .ink-navigation-next' => 'right: {{SIZE}}px;',
            ],
            'conditions' => [
                'terms' => [
                    [
                        'name' => 'navigation',
                        'operator' => 'in',
                        'value' => ['arrows', 'arrows-thumbnavs'],
                    ],
                    [
                        'name' => 'arrows_position',
                        'value' => 'center',
                    ],
                ],
            ],
                ]
        );

        $this->add_control(
                'dots_nnx_position', [
            'label' => __('Horizontal Offset', 'colorway-addons'),
            'type' => Controls_Manager::SLIDER,
            'default' => [
                'size' => 0,
            ],
            'range' => [
                'px' => [
                    'min' => -200,
                    'max' => 200,
                ],
            ],
            'conditions' => [
                'terms' => [
                    [
                        'name' => 'navigation',
                        'value' => 'dots',
                    ],
                    [
                        'name' => 'dots_position',
                        'operator' => '!=',
                        'value' => '',
                    ],
                ],
            ],
                ]
        );

        $this->add_control(
                'dots_nny_position', [
            'label' => __('Vertical Offset', 'colorway-addons'),
            'type' => Controls_Manager::SLIDER,
            'default' => [
                'size' => 30,
            ],
            'range' => [
                'px' => [
                    'min' => -200,
                    'max' => 200,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .ink-slideshow .ink-dots-container' => 'transform: translate({{dots_nnx_position.size}}px, {{SIZE}}px);',
            ],
            'conditions' => [
                'terms' => [
                    [
                        'name' => 'navigation',
                        'value' => 'dots',
                    ],
                    [
                        'name' => 'dots_position',
                        'operator' => '!=',
                        'value' => '',
                    ],
                ],
            ],
                ]
        );

        $this->add_control(
                'thumbnavs_x_position', [
            'label' => __('Thumbnavs Horizontal Offset', 'colorway-addons'),
            'type' => Controls_Manager::SLIDER,
            'default' => [
                'size' => 15,
            ],
            'range' => [
                'px' => [
                    'min' => -200,
                    'max' => 200,
                ],
            ],
            'condition' => [
                'navigation!' => ['arrows', 'dots', 'both', 'none'],
            ],
                ]
        );

        $this->add_control(
                'thumbnavs_y_position', [
            'label' => __('Thumbnavs Vertical Offset', 'colorway-addons'),
            'type' => Controls_Manager::SLIDER,
            'default' => [
                'size' => 15,
            ],
            'range' => [
                'px' => [
                    'min' => -200,
                    'max' => 200,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .ink-slideshow .ink-thumbnav-wrapper .ink-thumbnav' => 'transform: translate({{thumbnavs_x_position.size}}px, {{SIZE}}px);',
            ],
            'condition' => [
                'navigation!' => ['arrows', 'dots', 'both', 'none'],
            ],
                ]
        );

        $this->add_control(
                'both_ncx_position', [
            'label' => __('Horizontal Offset', 'colorway-addons'),
            'type' => Controls_Manager::SLIDER,
            'default' => [
                'size' => 0,
            ],
            'range' => [
                'px' => [
                    'min' => -200,
                    'max' => 200,
                ],
            ],
            'conditions' => [
                'terms' => [
                    [
                        'name' => 'navigation',
                        'value' => 'both',
                    ],
                    [
                        'name' => 'both_position',
                        'operator' => '!=',
                        'value' => 'center',
                    ],
                ],
            ],
                ]
        );

        $this->add_control(
                'both_ncy_position', [
            'label' => __('Vertical Offset', 'colorway-addons'),
            'type' => Controls_Manager::SLIDER,
            'default' => [
                'size' => 40,
            ],
            'range' => [
                'px' => [
                    'min' => -200,
                    'max' => 200,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .ink-slideshow .ink-arrows-dots-container' => 'transform: translate({{both_ncx_position.size}}px, {{SIZE}}px);',
            ],
            'conditions' => [
                'terms' => [
                    [
                        'name' => 'navigation',
                        'value' => 'both',
                    ],
                    [
                        'name' => 'both_position',
                        'operator' => '!=',
                        'value' => 'center',
                    ],
                ],
            ],
                ]
        );

        $this->add_control(
                'both_cx_position', [
            'label' => __('Arrows Offset', 'colorway-addons'),
            'type' => Controls_Manager::SLIDER,
            'default' => [
                'size' => 20,
            ],
            'range' => [
                'px' => [
                    'min' => -200,
                    'max' => 200,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .ink-slideshow .ink-navigation-prev' => 'left: {{SIZE}}px;',
                '{{WRAPPER}} .ink-slideshow .ink-navigation-next' => 'right: {{SIZE}}px;',
            ],
            'conditions' => [
                'terms' => [
                    [
                        'name' => 'navigation',
                        'value' => 'both',
                    ],
                    [
                        'name' => 'both_position',
                        'value' => 'center',
                    ],
                ],
            ],
                ]
        );

        $this->add_control(
                'both_cy_position', [
            'label' => __('Dots Offset', 'colorway-addons'),
            'type' => Controls_Manager::SLIDER,
            'default' => [
                'size' => -40,
            ],
            'range' => [
                'px' => [
                    'min' => -200,
                    'max' => 200,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .ink-slideshow .ink-dots-container' => 'transform: translateY({{SIZE}}px);',
            ],
            'conditions' => [
                'terms' => [
                    [
                        'name' => 'navigation',
                        'value' => 'both',
                    ],
                    [
                        'name' => 'both_position',
                        'value' => 'center',
                    ],
                ],
            ],
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'section_style_animation', [
            'label' => esc_html__('Animation', 'colorway-addons'),
            'tab' => Controls_Manager::TAB_STYLE,
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
                'autoplay_interval', [
            'label' => esc_html__('Autoplay Interval', 'colorway-addons'),
            'type' => Controls_Manager::NUMBER,
            'default' => 7000,
            'condition' => [
                'autoplay' => 'yes',
            ],
                ]
        );

        $this->add_control(
                'pause_on_hover', [
            'label' => esc_html__('Pause on Hover', 'colorway-addons'),
            'type' => Controls_Manager::SWITCHER,
                ]
        );

        $this->add_control(
                'slider_animations', [
            'label' => esc_html__('Slider Animations', 'colorway-addons'),
            'type' => Controls_Manager::SELECT,
            'separator' => 'before',
            'default' => 'slide',
            'options' => [
                'slide' => esc_html__('Slide', 'colorway-addons'),
                'fade' => esc_html__('Fade', 'colorway-addons'),
                'scale' => esc_html__('Scale', 'colorway-addons'),
                'push' => esc_html__('Push', 'colorway-addons'),
                'pull' => esc_html__('Pull', 'colorway-addons'),
            ],
                ]
        );

        $this->add_control(
                'kenburns_animation', [
            'label' => esc_html__('Kenburns Animation', 'colorway-addons'),
            'separator' => 'before',
            'type' => Controls_Manager::SWITCHER,
                ]
        );

        $this->add_control(
                'parallax_pre_title', [
            'label' => esc_html__('Parallax Pre Title', 'colorway-addons'),
            'type' => Controls_Manager::SWITCHER,
            'separator' => 'before',
            'condition' => [
                'show_pre_title' => 'yes',
            ],
                ]
        );

        $this->add_control(
                'parallax_pre_title_x_start', [
            'label' => esc_html__('X Start Value', 'colorway-addons'),
            'type' => Controls_Manager::SLIDER,
            'default' => [
                'size' => 200,
            ],
            'range' => [
                'px' => [
                    'min' => -500,
                    'max' => 500,
                ],
            ],
            'condition' => [
                'parallax_pre_title' => 'yes',
            ],
                ]
        );

        $this->add_control(
                'parallax_pre_title_x_end', [
            'label' => esc_html__('X End Value', 'colorway-addons'),
            'type' => Controls_Manager::SLIDER,
            'default' => [
                'size' => -200,
            ],
            'range' => [
                'px' => [
                    'min' => -500,
                    'max' => 500,
                ],
            ],
            'condition' => [
                'parallax_pre_title' => 'yes',
            ],
                ]
        );

        $this->add_control(
                'parallax_pre_title_y_start', [
            'label' => esc_html__('Y Start Value', 'colorway-addons'),
            'type' => Controls_Manager::SLIDER,
            'default' => [
                'size' => 0,
            ],
            'range' => [
                'px' => [
                    'min' => -500,
                    'max' => 500,
                ],
            ],
            'condition' => [
                'parallax_pre_title' => 'yes',
            ],
                ]
        );

        $this->add_control(
                'parallax_pre_title_y_end', [
            'label' => esc_html__('Y End Value', 'colorway-addons'),
            'type' => Controls_Manager::SLIDER,
            'default' => [
                'size' => 0,
            ],
            'range' => [
                'px' => [
                    'min' => -500,
                    'max' => 500,
                ],
            ],
            'condition' => [
                'parallax_pre_title' => 'yes',
            ],
                ]
        );

        $this->add_control(
                'parallax_title', [
            'label' => esc_html__('Parallax Title', 'colorway-addons'),
            'type' => Controls_Manager::SWITCHER,
            'separator' => 'before',
            'condition' => [
                'show_title' => 'yes',
            ],
                ]
        );

        $this->add_control(
                'parallax_title_x_start', [
            'label' => esc_html__('X Start Value', 'colorway-addons'),
            'type' => Controls_Manager::SLIDER,
            'default' => [
                'size' => 300,
            ],
            'range' => [
                'px' => [
                    'min' => -500,
                    'max' => 500,
                ],
            ],
            'condition' => [
                'parallax_title' => 'yes',
            ],
                ]
        );

        $this->add_control(
                'parallax_title_x_end', [
            'label' => esc_html__('X End Value', 'colorway-addons'),
            'type' => Controls_Manager::SLIDER,
            'default' => [
                'size' => -300,
            ],
            'range' => [
                'px' => [
                    'min' => -500,
                    'max' => 500,
                ],
            ],
            'condition' => [
                'parallax_title' => 'yes',
            ],
                ]
        );

        $this->add_control(
                'parallax_title_y_start', [
            'label' => esc_html__('Y Start Value', 'colorway-addons'),
            'type' => Controls_Manager::SLIDER,
            'default' => [
                'size' => 0,
            ],
            'range' => [
                'px' => [
                    'min' => -500,
                    'max' => 500,
                ],
            ],
            'condition' => [
                'parallax_title' => 'yes',
            ],
                ]
        );

        $this->add_control(
                'parallax_title_y_end', [
            'label' => esc_html__('Y End Value', 'colorway-addons'),
            'type' => Controls_Manager::SLIDER,
            'default' => [
                'size' => 0,
            ],
            'range' => [
                'px' => [
                    'min' => -500,
                    'max' => 500,
                ],
            ],
            'condition' => [
                'parallax_title' => 'yes',
            ],
                ]
        );

        $this->add_control(
                'parallax_post_title', [
            'label' => esc_html__('Parallax Post Title', 'colorway-addons'),
            'type' => Controls_Manager::SWITCHER,
            'separator' => 'before',
            'condition' => [
                'show_post_title' => 'yes',
            ],
                ]
        );

        $this->add_control(
                'parallax_post_title_x_start', [
            'label' => esc_html__('X Start Value', 'colorway-addons'),
            'type' => Controls_Manager::SLIDER,
            'default' => [
                'size' => 350,
            ],
            'range' => [
                'px' => [
                    'min' => -500,
                    'max' => 500,
                ],
            ],
            'condition' => [
                'parallax_post_title' => 'yes',
            ],
                ]
        );

        $this->add_control(
                'parallax_post_title_x_end', [
            'label' => esc_html__('X End Value', 'colorway-addons'),
            'type' => Controls_Manager::SLIDER,
            'default' => [
                'size' => -350,
            ],
            'range' => [
                'px' => [
                    'min' => -500,
                    'max' => 500,
                ],
            ],
            'condition' => [
                'parallax_post_title' => 'yes',
            ],
                ]
        );

        $this->add_control(
                'parallax_post_title_y_start', [
            'label' => esc_html__('Y Start Value', 'colorway-addons'),
            'type' => Controls_Manager::SLIDER,
            'default' => [
                'size' => 0,
            ],
            'range' => [
                'px' => [
                    'min' => -500,
                    'max' => 500,
                ],
            ],
            'condition' => [
                'parallax_post_title' => 'yes',
            ],
                ]
        );

        $this->add_control(
                'parallax_post_title_y_end', [
            'label' => esc_html__('Y End Value', 'colorway-addons'),
            'type' => Controls_Manager::SLIDER,
            'default' => [
                'size' => 0,
            ],
            'range' => [
                'px' => [
                    'min' => -500,
                    'max' => 500,
                ],
            ],
            'condition' => [
                'parallax_post_title' => 'yes',
            ],
                ]
        );

        $this->add_control(
                'parallax_text', [
            'label' => esc_html__('Parallax Text', 'colorway-addons'),
            'type' => Controls_Manager::SWITCHER,
            'separator' => 'before',
            'condition' => [
                'show_text' => 'yes',
            ],
                ]
        );

        $this->add_control(
                'parallax_text_x_start', [
            'label' => esc_html__('X Start Value', 'colorway-addons'),
            'type' => Controls_Manager::SLIDER,
            'default' => [
                'size' => 500,
            ],
            'range' => [
                'px' => [
                    'min' => -500,
                    'max' => 500,
                ],
            ],
            'condition' => [
                'parallax_text' => 'yes',
            ],
                ]
        );

        $this->add_control(
                'parallax_text_x_end', [
            'label' => esc_html__('X End Value', 'colorway-addons'),
            'type' => Controls_Manager::SLIDER,
            'default' => [
                'size' => -500,
            ],
            'range' => [
                'px' => [
                    'min' => -500,
                    'max' => 500,
                ],
            ],
            'condition' => [
                'parallax_text' => 'yes',
            ],
                ]
        );

        $this->add_control(
                'parallax_text_y_start', [
            'label' => esc_html__('Y Start Value', 'colorway-addons'),
            'type' => Controls_Manager::SLIDER,
            'default' => [
                'size' => 0,
            ],
            'range' => [
                'px' => [
                    'min' => -500,
                    'max' => 500,
                ],
            ],
            'condition' => [
                'parallax_text' => 'yes',
            ],
                ]
        );

        $this->add_control(
                'parallax_text_y_end', [
            'label' => esc_html__('Y End Value', 'colorway-addons'),
            'type' => Controls_Manager::SLIDER,
            'default' => [
                'size' => 0,
            ],
            'range' => [
                'px' => [
                    'min' => -500,
                    'max' => 500,
                ],
            ],
            'condition' => [
                'parallax_text' => 'yes',
            ],
                ]
        );

        $this->add_control(
                'parallax_button', [
            'label' => esc_html__('Parallax Button', 'colorway-addons'),
            'type' => Controls_Manager::SWITCHER,
            'separator' => 'before',
            'condition' => [
                'show_text' => 'yes',
            ],
                ]
        );

        $this->add_control(
                'parallax_button_x_start', [
            'label' => esc_html__('X Start Value', 'colorway-addons'),
            'type' => Controls_Manager::SLIDER,
            'default' => [
                'size' => -150,
            ],
            'range' => [
                'px' => [
                    'min' => -500,
                    'max' => 500,
                ],
            ],
            'condition' => [
                'parallax_button' => 'yes',
            ],
                ]
        );

        $this->add_control(
                'parallax_button_x_end', [
            'label' => esc_html__('X End Value', 'colorway-addons'),
            'type' => Controls_Manager::SLIDER,
            'default' => [
                'size' => 150,
            ],
            'range' => [
                'px' => [
                    'min' => -500,
                    'max' => 500,
                ],
            ],
            'condition' => [
                'parallax_button' => 'yes',
            ],
                ]
        );

        $this->add_control(
                'parallax_button_y_start', [
            'label' => esc_html__('Y Start Value', 'colorway-addons'),
            'type' => Controls_Manager::SLIDER,
            'default' => [
                'size' => 0,
            ],
            'range' => [
                'px' => [
                    'min' => -500,
                    'max' => 500,
                ],
            ],
            'condition' => [
                'parallax_button' => 'yes',
            ],
                ]
        );

        $this->add_control(
                'parallax_button_y_end', [
            'label' => esc_html__('Y End Value', 'colorway-addons'),
            'type' => Controls_Manager::SLIDER,
            'default' => [
                'size' => 0,
            ],
            'range' => [
                'px' => [
                    'min' => -500,
                    'max' => 500,
                ],
            ],
            'condition' => [
                'parallax_button' => 'yes',
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
                '{{WRAPPER}} .ink-slideshow .ink-ep-scroll-to-section a' => 'color: {{VALUE}};',
            ],
                ]
        );

        $this->add_control(
                'scroll_to_top_background', [
            'label' => esc_html__('Background', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .ink-slideshow .ink-ep-scroll-to-section a' => 'background-color: {{VALUE}};',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Box_Shadow::get_type(), [
            'name' => 'scroll_to_top_shadow',
            'selector' => '{{WRAPPER}} .ink-slideshow .ink-ep-scroll-to-section a',
                ]
        );

        $this->add_group_control(
                Group_Control_Border::get_type(), [
            'name' => 'scroll_to_top_border',
            'label' => esc_html__('Border', 'colorway-addons'),
            'placeholder' => '1px',
            'default' => '1px',
            'selector' => '{{WRAPPER}} .ink-slideshow .ink-ep-scroll-to-section a',
            'separator' => 'before',
                ]
        );

        $this->add_control(
                'scroll_to_top_radius', [
            'label' => esc_html__('Border Radius', 'colorway-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .ink-slideshow .ink-ep-scroll-to-section a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_responsive_control(
                'scroll_to_top_padding', [
            'label' => esc_html__('Padding', 'colorway-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '{{WRAPPER}} .ink-slideshow .ink-ep-scroll-to-section a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                '{{WRAPPER}} .ink-slideshow .ink-ep-scroll-to-section a' => 'font-size: {{SIZE}}px;',
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
                '{{WRAPPER}} .ink-slideshow .ink-ep-scroll-to-section' => 'margin-bottom: {{SIZE}}px;',
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
                '{{WRAPPER}} .ink-slideshow .ink-ep-scroll-to-section a:hover' => 'color: {{VALUE}};',
            ],
                ]
        );

        $this->add_control(
                'scroll_to_top_hover_background', [
            'label' => esc_html__('Background', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .ink-slideshow .ink-ep-scroll-to-section a:hover' => 'background-color: {{VALUE}};',
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
                '{{WRAPPER}} .ink-slideshow .ink-ep-scroll-to-section a:hover' => 'border-color: {{VALUE}};',
            ],
                ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function render_header() {
        $settings = $this->get_settings_for_display();
        $slides_settings = [];

        $ratio = ($settings['slider_size_ratio']['width'] && $settings['slider_size_ratio']['height']) ? $settings['slider_size_ratio']['width'] . ":" . $settings['slider_size_ratio']['height'] : '';

        $slider_settings['ink-slideshow'] = json_encode(array_filter([
            'animation' => $settings['slider_animations'],
            'ratio' => $ratio,
            'min-height' => $settings['slider_min_height']['size'],
            'autoplay' => $settings['autoplay'],
            'autoplay-interval' => $settings['autoplay_interval'],
            'pause-on-hover' => ('yes' === $settings['pause_on_hover']) ? 'true' : 'false',
        ]));


        if ('both' == $settings['navigation']) {
            $slider_settings['class'][] = 'ink-arrows-dots-align-' . $settings['both_position'];
        } elseif ('arrows' == $settings['navigation'] or 'arrows-thumbnavs' == $settings['navigation']) {
            $slider_settings['class'][] = 'ink-arrows-align-' . $settings['arrows_position'];
        } elseif ('dots' == $settings['navigation']) {
            $slider_settings['class'][] = 'ink-dots-align-' . $settings['dots_position'];
        }

        $slideshow_fullscreen = ( $settings['slideshow_fullscreen'] ) ? ' ink-height-viewport="offset-top: true"' : '';
        ?>
        <div <?php echo \colorway_addons_helper::attrs($slider_settings); ?>>
            <div class="ink-position-relative ink-visible-toggle">

                <?php if ($settings['scroll_to_section'] && $settings['section_id']): ?>
                    <div class="ink-ep-scroll-to-section ink-position-bottom-center">
                        <a href="<?php echo esc_url($settings['section_id']); ?>">
                            <span class="ink-ep-scroll-to-section-icon">
                                <i class="<?php echo esc_attr($settings['scroll_to_section_icon']); ?>"></i>
                            </span>
                        </a>
                    </div>
                <?php endif; ?>

                <ul class="ink-slideshow-items"<?php echo $slideshow_fullscreen; ?>>
                    <?php
                }

                protected function render_footer() {
                    $settings = $this->get_settings_for_display();
                    ?>
                </ul>
                <?php if ('both' == $settings['navigation']) : ?>
                    <?php $this->render_both_navigation(); ?>

                    <?php if ('center' === $settings['both_position']) : ?>
                        <?php $this->render_dotnavs(); ?>
                    <?php endif; ?>
                <?php elseif ('arrows-thumbnavs' == $settings['navigation']) : ?>
                    <?php $this->render_navigation(); ?>
                    <?php $this->render_thumbnavs(); ?>
                <?php elseif ('arrows' == $settings['navigation']) : ?>			
                    <?php $this->render_navigation(); ?>
                <?php elseif ('dots' == $settings['navigation']) : ?>			
                    <?php $this->render_dotnavs(); ?>
                <?php elseif ('thumbnavs' == $settings['navigation']) : ?>			
                    <?php $this->render_thumbnavs(); ?>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }

    protected function render_navigation() {
        $settings = $this->get_settings();
        ?>
        <div class="ink-position-z-index ink-visible@m ink-position-<?php echo esc_attr($settings['arrows_position']); ?>">
            <div class="ink-arrows-container ink-slidenav-container">
                <?php
                if ($settings['arrow_icon']) :
                    $input = $settings['arrow_icon'];
                    $result_lt = explode('-', $input);
                    ?>
                    <div class="ink-navigation-prev ink-slidenav-previous ink-slidenav ink-icon" ink-slideshow-item="previous">
                        <a href="" class="ink-swiper-prev"><i class="<?php echo "fa fa-" . esc_attr($result_lt[1]) . "-left"; ?>"></i>
                        </a>
                    </div>
                <?php endif; ?>

                <?php
                if ($settings['arrow_icon']) :
                    $input = $settings['arrow_icon'];
                    $result_rt = explode('-', $input);
                    ?>
                    <div class="ink-navigation-next ink-slidenav-next ink-slidenav ink-icon" ink-slideshow-item="next">
                        <a href="" class="ink-swiper-next"><i class="<?php echo "fa fa-" . esc_attr($result_rt[1]) . "-right"; ?>"></i>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }

    protected function render_dotnavs() {
        $settings = $this->get_settings();
        ?>
        <div class="ink-position-z-index ink-visible@m ink-position-<?php echo esc_attr($settings['dots_position']); ?>">
            <div class="ink-dotnav-wrapper ink-dots-container">
                <ul class="ink-dotnav ink-flex-center">

                    <?php
                    $ink_counter = 0;

                    foreach ($settings['slides'] as $slide) :
                        echo '<li class="ink-slideshow-dotnav ink-active" ink-slideshow-item="' . $ink_counter . '"><a href="#"></a></li>';
                        $ink_counter++;
                    endforeach;
                    ?>

                </ul>
            </div>
        </div>
        <?php
    }

    protected function render_thumbnavs() {
        $settings = $this->get_settings();

        $thumbnavs_outside = '';
        $vertical_thumbnav = '';

        if ('center-left' == $settings['thumbnavs_position'] || 'center-right' == $settings['thumbnavs_position']) {
            if ('yes' == $settings['thumbnavs_outside']) {
                $thumbnavs_outside = '-out';
            }
            $vertical_thumbnav = ' ink-thumbnav-vertical';
        }
        ?>
        <div class="ink-thumbnav-wrapper ink-position-<?php echo esc_attr($settings['thumbnavs_position'] . $thumbnavs_outside); ?> ink-position-small">
            <ul class="ink-thumbnav<?php echo esc_attr($vertical_thumbnav); ?>">

                <?php
                $ink_counter = 0;

                foreach ($settings['slides'] as $slide) :

                    $slideshow_thumbnav = $this->render_thumbnavs_thumb($slide, 'thumbnail');
                    echo '<li class="ink-slideshow-thumbnav ink-active" ink-slideshow-item="' . $ink_counter . '"><a class="ink-overflow-hidden ink-background-cover" href="#" style="background-image: url(' . esc_url($slideshow_thumbnav) . ')"></a></li>';
                    $ink_counter++;

                endforeach;
                ?>
            </ul>
        </div>

        <?php
    }

    protected function render_both_navigation() {
        $settings = $this->get_settings();
        ?>

        <div class="ink-position-z-index ink-position-<?php echo esc_attr($settings['both_position']); ?>">
            <div class="ink-arrows-dots-container ink-slidenav-container ">

                <div class="ink-flex ink-flex-middle">


                    <?php
                    if ($settings['arrow_icon']) :
                        $input = $settings['arrow_icon'];
                        $result_lt = explode('-', $input);
                        ?>
                        <div class="ink-navigation-prev ink-slidenav-previous ink-slidenav ink-icon" ink-slideshow-item="previous"><a href="" class="ink-swiper-next"><i class="<?php echo "fa fa-" . esc_attr($result_lt[1]) . "-left"; ?>"></a></i></div>
                    <?php endif; ?>

                    <?php if ('center' !== $settings['both_position']) : ?>
                        <div class="ink-dotnav-wrapper ink-dots-container">
                            <ul class="ink-dotnav">
                                <?php
                                $ink_counter = 0;

                                foreach ($settings['slides'] as $slide) :
                                    echo '<li class="ink-slideshow-dotnav ink-active" ink-slideshow-item="' . $ink_counter . '"><a href="#"></a></li>';
                                    $ink_counter++;
                                endforeach;
                                ?>
                            </ul>
                        </div>
                    <?php endif; ?>


                    <?php
                    if ($settings['arrow_icon']) :
                        $input = $settings['arrow_icon'];
                        $result_rt = explode('-', $input);
                        ?>
                        <div class="ink-navigation-next ink-slidenav-next ink-slidenav ink-icon" ink-slideshow-item="next"><a href="" class="ink-swiper-next"><i class="<?php echo "fa fa-" . esc_attr($result_rt[1]) . "-right"; ?>"></i></a></div>
                    <?php endif; ?>

                </div>
            </div>
        </div>

        <?php
    }

    protected function render_thumbnavs_thumb($image, $size) {
        $image_url = wp_get_attachment_image_src($image['image']['id'], $size);

        $image_url = ( '' != $image_url ) ? $image_url[0] : $image['image']['url'];

        return $image_url;
    }

    protected function render_item_image($image) {
        $image_src = wp_get_attachment_image_src($image['image']['id'], 'full');

        if ($image_src) :
            echo '<img src="' . esc_url($image_src[0]) . '" alt="" ink-cover>';
        endif;

        return 0;
    }

    protected function render_item_video($link) {
        $video_src = $link['video_link'];
        ?>
        <video autoplay loop muted playslinline ink-cover>
            <source src="<?php echo $video_src; ?>" type="video/mp4">
        </video>
        <?php
    }

    protected function render_item_youtube($link) {

        $id = (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $link['youtube_link'], $match) ) ? $match[1] : false;
        $url = '//www.youtube.com/embed/' . $id . '?autoplay=1&amp;controls=0&amp;showinfo=0&amp;rel=0&amp;loop=1&amp;modestbranding=1&amp;wmode=transparent&amp;playsinline=1';
        ?>
        <iframe src="<?php echo esc_url($url); ?>" frameborder="0" allowfullscreen ink-cover></iframe>
        <?php
    }

    protected function render_item_content($content) {
        $settings = $this->get_settings_for_display();
        $animation = ($settings['button_hover_animation']) ? ' elementor-animation-' . $settings['button_hover_animation'] : '';

        $parallax_pre_title = [];
        $parallax_title = [];
        $parallax_post_title = [];
        $parallax_text = [];
        $parallax_button = [];

        if ('yes' == $settings['parallax_pre_title']) {
            $parallax_pre_title['ink-slideshow-parallax'] = json_encode(array_filter([
                'x' => $settings['parallax_pre_title_x_start']['size'] . ', ' . $settings['parallax_pre_title_x_end']['size'],
                'y' => $settings['parallax_pre_title_y_start']['size'] . ', ' . $settings['parallax_pre_title_y_end']['size'],
            ]));
        }

        if ('yes' == $settings['parallax_title']) {
            $parallax_title['ink-slideshow-parallax'] = json_encode(array_filter([
                'x' => $settings['parallax_title_x_start']['size'] . ', ' . $settings['parallax_title_x_end']['size'],
                'y' => $settings['parallax_title_y_start']['size'] . ', ' . $settings['parallax_title_y_end']['size'],
            ]));
        }

        if ('yes' == $settings['parallax_post_title']) {
            $parallax_post_title['ink-slideshow-parallax'] = json_encode(array_filter([
                'x' => $settings['parallax_post_title_x_start']['size'] . ', ' . $settings['parallax_post_title_x_end']['size'],
                'y' => $settings['parallax_post_title_y_start']['size'] . ', ' . $settings['parallax_post_title_y_end']['size'],
            ]));
        }

        if ('yes' == $settings['parallax_text']) {
            $parallax_text['ink-slideshow-parallax'] = json_encode(array_filter([
                'x' => $settings['parallax_text_x_start']['size'] . ', ' . $settings['parallax_text_x_end']['size'],
                'y' => $settings['parallax_text_y_start']['size'] . ', ' . $settings['parallax_text_y_end']['size'],
            ]));
        }

        if ('yes' == $settings['parallax_button']) {
            $parallax_button['ink-slideshow-parallax'] = json_encode(array_filter([
                'x' => $settings['parallax_button_x_start']['size'] . ', ' . $settings['parallax_button_x_end']['size'],
                'y' => $settings['parallax_button_y_start']['size'] . ', ' . $settings['parallax_button_y_end']['size'],
            ]));
        }
        ?>
        <div class="ink-slideshow-content-wrapper ink-position-z-index ink-position-<?php echo $settings['content_position']; ?> ink-position-large ink-text-<?php echo $settings['content_align']; ?>">
            <?php if ($content['pre_title'] && ( 'yes' == $settings['show_pre_title'] )) : ?>
                <div><h4 class="ink-slideshow-pre-title ink-display-inline-block" <?php echo \colorway_addons_helper::attrs($parallax_pre_title); ?>><?php echo esc_attr($content['pre_title']); ?></h4></div>
            <?php endif; ?>

            <?php if ($content['title'] && ( 'yes' == $settings['show_title'] )) : ?>
                <div><<?php echo esc_attr($settings['title_tag']); ?> class="ink-slideshow-title ink-display-inline-block" <?php echo \colorway_addons_helper::attrs($parallax_title); ?>><?php echo wp_kses_post($content['title']); ?></<?php echo esc_attr($settings['title_tag']); ?>></div>
            <?php endif; ?>

            <?php if ($content['post_title'] && ( 'yes' == $settings['show_post_title'] )) : ?>
                <div><h4 class="ink-slideshow-post-title ink-display-inline-block" <?php echo \colorway_addons_helper::attrs($parallax_post_title); ?>><?php echo esc_attr($content['post_title']); ?></h4></div>
            <?php endif; ?>

            <?php if ($content['text'] && ( 'yes' == $settings['show_text'] )): ?>
                <div class="ink-slideshow-text" <?php echo \colorway_addons_helper::attrs($parallax_text); ?>><?php echo wp_kses_post($content['text']); ?></div>
            <?php endif; ?>

            <?php if ((!empty($content['button_link']['url'])) && ( 'yes' == $settings['show_button'] ) && ($settings['button_text'])): ?>
                <div><a href="<?php echo esc_url($content['button_link']['url']); ?>" target="<?php echo ($content['button_link']['is_external']) ? '_blank' : '_self'; ?>" class="ink-slideshow-button ink-display-inline-block<?php echo $animation; ?>" rel="<?php echo ($content['button_link']['nofollow']) ? 'nofollow' : 'noreferrer'; ?>" <?php echo \colorway_addons_helper::attrs($parallax_button); ?>><?php echo esc_attr($settings['button_text']); ?>

                        <?php if ($settings['icon']) : ?>
                            <span class="ink-button-icon-align-<?php echo esc_attr($settings['icon_align']); ?> ink-slideshow-button-icon-<?php echo esc_attr($settings['icon_align']); ?>">
                                <i class="<?php echo esc_attr($settings['icon']); ?>"></i>
                            </span>
                        <?php endif; ?>

                    </a></div>
            <?php endif; ?>
        </div>

        <?php
    }

    public function render() {
        $settings = $this->get_settings_for_display();

        $this->render_header();

        foreach ($settings['slides'] as $slide) :
            ?>

            <li class="ink-slideshow-item elementor-repeater-item-<?php echo $slide['_id']; ?>">
                <?php if ('yes' == $settings['kenburns_animation']) : ?>
                    <div class="ink-position-cover ink-animation-kenburns ink-animation-reverse ink-transform-origin-center-left">
                    <?php endif; ?>

                    <?php if (( $slide['background'] == 'image' ) && $slide['image']) : ?>
                        <?php $this->render_item_image($slide); ?>
                    <?php elseif (( $slide['background'] == 'video' ) && $slide['video_link']) : ?>
                        <?php $this->render_item_video($slide); ?>
                    <?php elseif (( $slide['background'] == 'youtube' ) && $slide['youtube_link']) : ?>
                        <?php $this->render_item_youtube($slide); ?>
                    <?php endif; ?>

                    <?php if ('yes' == $settings['kenburns_animation']) : ?>
                    </div>
                <?php endif; ?>

                <?php
                if ('none' !== $settings['overlay']) :
                    $blend_type = ( 'blend' == $settings['overlay']) ? ' ink-blend-' . $settings['blend_type'] : '';
                    ?>
                    <div class="ink-overlay-default ink-position-cover<?php echo esc_attr($blend_type); ?>"></div>
                <?php endif; ?>

                <?php $this->render_item_content($slide); ?>
            </li>

            <?php
        endforeach;

        $this->render_footer();
    }

}
