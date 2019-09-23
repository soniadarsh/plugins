<?php

namespace CwAddons\Modules\ColumnSlider\Widgets;

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
 * Class Panel Slider
 */

class Column_Slider extends Widget_Base {

    /**
     * @var \WP_Query
     */
    private $_query = null;
    protected $_has_template_content = false;

    public function get_name() {
        return 'ink-column-slider';
    }

    public function get_title() {
        return esc_html__('Column Slider', 'colorway-addons');
    }

    public function get_icon() {
        return 'ink-widget-icon fas fa-chalkboard';
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
                'tabs', [
            'label' => esc_html__('Slider Items', 'colorway-addons'),
            'type' => Controls_Manager::REPEATER,
            'default' => [
                [
                    'tab_title' => esc_html__('Slider 1', 'colorway-addons'),
                    'tab_content' => esc_html__('Get ready to edit, customize and style this design driven slider to complete the look of your homepage!', 'colorway-addons'),
                ],
                [
                    'tab_title' => esc_html__('Slider 2', 'colorway-addons'),
                    'tab_content' => esc_html__('Get ready to edit, customize and style this design driven slider to complete the look of your homepage!', 'colorway-addons'),
                ],
                [
                    'tab_title' => esc_html__('Slider 3', 'colorway-addons'),
                    'tab_content' => esc_html__('Get ready to edit, customize and style this design driven slider to complete the look of your homepage!', 'colorway-addons'),
                ],
                [
                    'tab_title' => esc_html__('Slider 4', 'colorway-addons'),
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
                'columns', [
            'label' => esc_html__('Columns', 'colorway-addons'),
            'type' => Controls_Manager::SELECT,
            'default' => '3',
            'tablet_default' => '2',
            'mobile_default' => '1',
            'options' => [
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
                '6' => '6',
            ],
            'frontend_available' => true,
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
                'button', [
            'label' => esc_html__('Show Button', 'colorway-addons'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'description' => 'It will work when link field no null.',
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
            'default' => '',
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'section_content_button', [
            'label' => esc_html__('Button', 'colorway-addons'),
            'condition' => [
                'button' => 'yes',
            ],
                ]
        );

        $this->add_control(
                'button_text', [
            'label' => esc_html__('Text', 'colorway-addons'),
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
                '{{WRAPPER}} .ink-column-slider .ink-button-icon-align-right' => 'margin-left: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .ink-column-slider .ink-button-icon-align-left' => 'margin-right: {{SIZE}}{{UNIT}};',
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
            'frontend_available' => true,
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
            'selectors' => [
                '{{WRAPPER}} .ink-panel-slide-item' => 'background-color: {{VALUE}};',
                '{{WRAPPER}} .ink-panel-slide-item .ink-overlay-gradient' => 'background: linear-gradient(to bottom, rgba(255, 255, 255, 0) 40%, {{VALUE}} 100%);',
            ],
                ]
        );

        $this->add_control(
                'slider_opacity', [
            'label' => esc_html__('Opacity', 'colorway-addons'),
            'type' => Controls_Manager::NUMBER,
            'min' => 0,
            'max' => 1,
            'step' => 0.1,
            'selectors' => [
                '{{WRAPPER}} .ink-column-slider .ink-panel-slide-item .ink-panel-slide-thumb img' => 'opacity: {{VALUE}};',
            ],
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'section_style_button', [
            'label' => esc_html__('Button', 'colorway-addons'),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => [
                'button' => 'yes',
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
                '{{WRAPPER}} .ink-panel-slide-item .ink-panel-slide-link' => 'color: {{VALUE}};',
            ],
                ]
        );

        $this->add_control(
                'background_color', [
            'label' => esc_html__('Background Color', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .ink-panel-slide-item .ink-panel-slide-link' => 'background-color: {{VALUE}};',
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
                '{{WRAPPER}} .ink-panel-slide-item .ink-panel-slide-link:hover' => 'color: {{VALUE}};',
            ],
                ]
        );

        $this->add_control(
                'button_background_hover_color', [
            'label' => esc_html__('Background Color', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .ink-panel-slide-item .ink-panel-slide-link:hover' => 'background-color: {{VALUE}};',
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
                '{{WRAPPER}} .ink-panel-slide-item .ink-panel-slide-link:hover' => 'border-color: {{VALUE}};',
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
            'selector' => '{{WRAPPER}} .ink-panel-slide-item .ink-panel-slide-link',
            'separator' => 'before',
                ]
        );

        $this->add_control(
                'border_radius', [
            'label' => esc_html__('Border Radius', 'colorway-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .ink-panel-slide-item .ink-panel-slide-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Box_Shadow::get_type(), [
            'name' => 'button_box_shadow',
            'selector' => '{{WRAPPER}} .ink-panel-slide-item .ink-panel-slide-link',
                ]
        );

        $this->add_control(
                'button_padding', [
            'label' => esc_html__('Padding', 'colorway-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '{{WRAPPER}} .ink-panel-slide-item .ink-panel-slide-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'separator' => 'before',
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'typography',
            'label' => esc_html__('Typography', 'colorway-addons'),
            'scheme' => Scheme_Typography::TYPOGRAPHY_4,
            'selector' => '{{WRAPPER}} .ink-panel-slide-item .ink-panel-slide-link',
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'section_style_title', [
            'label' => esc_html__('Title', 'colorway-addons'),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => [
                'show_title' => 'yes',
            ],
                ]
        );

        $this->add_control(
                'title_color', [
            'label' => esc_html__('Color', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .ink-panel-slide-item .ink-panel-slide-title' => 'color: {{VALUE}};',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'title_typography',
            'label' => esc_html__('Typography', 'colorway-addons'),
            'scheme' => Scheme_Typography::TYPOGRAPHY_4,
            'selector' => '{{WRAPPER}} .ink-panel-slide-item .ink-panel-slide-title',
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
            'label' => esc_html__('Color', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .ink-panel-slide-item .ink-panel-slide-text' => 'color: {{VALUE}};',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'text_typography',
            'label' => esc_html__('Typography', 'colorway-addons'),
            'scheme' => Scheme_Typography::TYPOGRAPHY_4,
            'selector' => '{{WRAPPER}} .ink-panel-slide-item .ink-panel-slide-text',
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'section_style_navigation', [
            'label' => esc_html__('Navigation', 'colorway-addons'),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => [
                'navigation' => ['arrows', 'dots', 'both'],
            ],
                ]
        );

        $this->add_control(
                'heading_style_arrows', [
            'label' => esc_html__('Arrows', 'colorway-addons'),
            'type' => Controls_Manager::HEADING,
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
                'arrow_icon', [
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
                '{{WRAPPER}} .ink-column-slider .swiper-button-prev1 i.fa, .ink-column-slider .swiper-button-next1 i.fa' => 'color: {{VALUE}};',
            ],
                ]
        );

        $this->add_control(
                'arrow_bg_color', [
            'label' => esc_html__('Arrow Background Color', 'colorway-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .ink-column-slider .swiper-button-prev1, .ink-column-slider .swiper-button-next1' => 'background-color: {{VALUE}};',
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
                '{{WRAPPER}} .ink-column-slider .swiper-button-next1' => 'right: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .ink-column-slider .swiper-button-prev1' => 'left: {{SIZE}}{{UNIT}};',
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
                '{{WRAPPER}} .ink-column-slider .swiper-button-next1 i.fa, .ink-column-slider .swiper-button-prev1 i.fa' => 'font-size: {{SIZE}}{{UNIT}}',
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
                '{{WRAPPER}} .ink-column-slider .swiper-button-next1, .ink-column-slider .swiper-button-prev1' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}',
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
                '{{WRAPPER}} .ink-column-slider .swiper-button-next1, .ink-column-slider .swiper-button-prev1' => 'border-color: {{VALUE}};',
            ],
                ]
        );

        $this->add_control(
                'btn_bg_border', [
            'label' => esc_html__('Button Border', 'colorway-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .ink-column-slider .swiper-button-next1, .ink-column-slider .swiper-button-prev1' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_control(
                'btn_bg_radius', [
            'label' => esc_html__('Border Radius', 'colorway-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .ink-column-slider .swiper-button-next1, .ink-column-slider .swiper-button-prev1' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

                $this->add_responsive_control(
                'arrows_padding', [
            'label' => esc_html__('Padding', 'colorway-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'selectors' => [
                '{{WRAPPER}} .ink-column-slider .swiper-button-prev1 i.fa' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                '{{WRAPPER}} .ink-column-slider .swiper-button-next1 i.fa' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'condition' => [
                'navigation!' => ['none', 'thumbnavs', 'dots'],
            ],
                ]
        );
        
        $this->add_control(
                'heading_style_dots', [
            'label' => esc_html__('Dots', 'colorway-addons'),
            'type' => Controls_Manager::HEADING,
            'condition' => [
                'navigation' => ['dots', 'both'],
            ],
                ]
        );

        $this->add_control(
                'dots_position', [
            'label' => esc_html__('Dots Position', 'colorway-addons'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => -80,
                    'max' => 80,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .ink-column-slider .swiper-pagination-bullets' => 'bottom: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                'navigation' => ['dots', 'both'],
            ],
                ]
        );

        $this->add_control(
                'dots_size', [
            'label' => esc_html__('Dots Size', 'colorway-addons'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 5,
                    'max' => 10,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .ink-column-slider .swiper-pagination-bullet' => 'height: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                'navigation' => ['dots', 'both'],
            ],
                ]
        );

        $this->end_controls_section();
    }

    protected function render_loop_header() {
        ?>
        <div class="ink-column-slider">
            <div class="swiper-container">
        <?php
    }

    protected function render_loop_footer() {

        $settings = $this->get_settings_for_display();
        ?>
            </div>

        <?php if ('none' !== $settings['navigation']) : ?>
            <?php if ('arrows' !== $settings['navigation']) : ?>
                    <div class="swiper-pagination"></div>
            <?php endif; ?>

            <?php
            if ('dots' !== $settings['navigation']) :
//                $nav_style = ($settings['arrows_style'] == 'light') ? 'swiper-button-white' : 'swiper-button-black';
                ?>

                <?php
                if ($settings['arrow_icon']) :
                    $input = $settings['arrow_icon'];
                    $result_rt = explode('-', $input);
                    ?>
                        <div class="swiper-button-next1 <?php //echo esc_attr($nav_style); ?>"><a class="ink-swiper-next"><i class="<?php echo "fa fa-" . esc_attr($result_rt[1]) . "-right"; ?>"></a></i></div>
                <?php endif; ?>


                <?php
                if ($settings['arrow_icon']) :
                    $input = $settings['arrow_icon'];
                    $result_lt = explode('-', $input);
                    ?>
                        <div class="swiper-button-prev1 <?php //echo esc_attr($nav_style); ?>"><a class="ink-swiper-prev"><i class="<?php echo "fa fa-" . esc_attr($result_lt[1]) . "-left"; ?>"></a></i></div>
                <?php endif; ?>
            <?php endif; ?>
        <?php endif; ?>

        </div>

        <script>
            jQuery(document).ready(function ($) {
                "use strict";
                var swiper = new Swiper('.elementor-element-<?php echo esc_attr($this->get_id()); ?> .swiper-container', {
                    slidesPerView: <?php echo esc_attr($settings['columns']); ?>,
                    spaceBetween: 1,
        //      slidesPerGroup: 3,
                    loop: <?php echo ($settings['infinite'] == 'yes') ? 'true' : 'false'; ?>,
                    speed: <?php echo esc_attr($settings['speed']); ?>,
                    autoplay: <?php echo ($settings['autoplay'] == 'yes') ? '{ "delay": ' . $settings['autoplay_speed'] . ' }' : 'false'; ?>,
                    loopFillGroupWithBlank: true,

                    pagination: {
                        el: '.elementor-element-<?php echo esc_attr($this->get_id()); ?> .swiper-pagination',
                        clickable: true,
                    },
                    navigation: {
                        nextEl: '.elementor-element-<?php echo esc_attr($this->get_id()); ?> .swiper-button-next1',
                        prevEl: '.elementor-element-<?php echo esc_attr($this->get_id()); ?> .swiper-button-prev1',
                    },
                    breakpoints: {
                        1024: {
                            "slidesPerView": <?php echo esc_attr($settings['columns']); ?>,
                        },
                        768: {
                            "slidesPerView": <?php echo esc_attr($settings['columns_tablet']); ?>,
                        },
                        640: {
                            "slidesPerView": <?php echo esc_attr($settings['columns_mobile']); ?>,
                        }
                    }
                });


            });
        </script>

            <?php
        }

        public function render() {
            $settings = $this->get_settings_for_display();
            $url = $target = $link_title = '';
            $classes = ['ink-panel-slide-item', 'swiper-slide', 'ink-transition-toggle'];
            $animation = ($settings['button_hover_animation']) ? ' elementor-animation-' . $settings['button_hover_animation'] : '';
            $this->render_loop_header();
            $counter = 1;
            ?>
        <div class="swiper-wrapper">
        <?php foreach ($settings['tabs'] as $item) : ?>
            <?php
            $image_src = wp_get_attachment_image_src($item['tab_image']['id'], 'full');
            $image = ($image_src) ? $image_src[0] : INKCA_ASSETS_URL . '/images/column-slider.jpg';
            ?>
                <div class="<?php echo implode(" ", $classes); ?>">
                    <div class="ink-panel-slide-thumb">
                        <img src="<?php echo $image; ?>" alt="<?php echo esc_attr($item['tab_title']); ?>">
                    </div>
                    <div class="ink-panel-slide-desc ink-position-bottom-left ink-position-z-index">
            <?php if (!empty($item['tab_link']['url']) and ( 'yes' == $settings['button'])) : ?>
                            <a href="<?php echo esc_url($item['tab_link']['url']); ?>" target="<?php echo esc_attr($item['tab_link']['is_external']); ?>" class="ink-panel-slide-link ink-link-reset ink-transition-slide-bottom<?php echo esc_attr($animation); ?>"><?php echo esc_html($settings['button_text']); ?>
                <?php if ($settings['icon']) : ?>
                                    <span class="ink-button-icon-align-<?php echo esc_attr($settings['icon_align']); ?>">
                                        <i class="<?php echo esc_attr($settings['icon']); ?>"></i>
                                    </span>
                <?php endif; ?>
                            </a>
            <?php endif; ?>

            <?php if ('yes' == $settings['show_title']) : ?>
                            <h3 class="ink-panel-slide-title ink-transition-slide-bottom"><?php echo esc_html($item['tab_title']); ?></h3>
            <?php endif; ?>

            <?php if ('' !== $item['tab_content']) : ?>
                            <div class="ink-panel-slide-text ink-transition-slide-bottom"><?php echo $this->parse_text_editor($item['tab_content']); ?></div>
            <?php endif; ?>
                    </div>
                    <div class="ink-transition-fade ink-position-cover ink-overlay ink-overlay-gradient"></div>
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
