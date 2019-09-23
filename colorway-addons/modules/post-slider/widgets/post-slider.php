<?php
namespace CwAddons\Modules\PostSlider\Widgets;

use Elementor\Group_Control_Image_Size;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;

use CwAddons\Modules\QueryControl\Controls\Group_Control_Posts;
use CwAddons\Modules\QueryControl\Module;

use CwAddons\Modules\PostSlider\Skins;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Class Post Slider
 */
class Post_Slider extends Widget_Base {
	public $_query = null;

	public function get_name() {
		return 'ink-post-slider';
	}

	public function get_title() {
		return __( 'Post Slider', 'colorway-addons' );
	}

	public function get_icon() {
		return 'ink-widget-icon fas fa-digital-tachograph';
	}

	public function get_categories() {
		return [ 'colorway-addons' ];
	}

	public function get_script_depends() {
		return [ 'imagesloaded' ];
	}

	public function on_import( $element ) {
		if ( ! get_post_type_object( $element['settings']['posts_post_type'] ) ) {
			$element['settings']['posts_post_type'] = 'post';
		}

		return $element;
	}

	public function on_export( $element ) {
		$element = Group_Control_Posts::on_export_remove_setting_from_element( $element, 'posts' );
		return $element;
	}

	public function get_query() {
		return $this->_query;
	}

	public function _register_skins() {
		$this->add_skin( new Skins\Skin_Vast( $this ) );
		$this->add_skin( new Skins\Skin_Hazel( $this ) );
	}

	public function _register_controls() {

		$this->start_controls_section(
			'section_content_layout',
			[
				'label' => __( 'Layout', 'colorway-addons' ),
			]
		);

		$this->add_control(
			'show_tag',
			[
				'label'   => __( 'Show Tag', 'colorway-addons' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_title',
			[
				'label'   => __( 'Show Title', 'colorway-addons' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'title_tag',
			[
				'label'     => __( 'Title HTML Tag', 'colorway-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => colorway_addons_title_tags(),
				'default'   => 'h1',
				'condition' => [
					'show_title' => 'yes',
				],
			]
		);


		$this->add_control(
			'show_text',
			[
				'label'   => __( 'Show Excerpt', 'colorway-addons' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'excerpt_length',
			[
				'label'     => __( 'Excerpt Length', 'colorway-addons' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 35,
				'condition' => [
					'show_text' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_button',
			[
				'label' => __( 'Read More Button', 'colorway-addons' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'show_meta',
			[
				'label'   => __( 'Meta', 'colorway-addons' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_pagination_thumb',
			[
				'label'     => __( 'Pagination Thumb', 'colorway-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => [
					'_skin' => '',
				],
			]
		);

		$this->add_control(
			'slider_size_ratio',
			[
				'label'       => esc_html__( 'Size Ratio', 'colorway-addons' ),
				'type'        => Controls_Manager::IMAGE_DIMENSIONS,
				'description' => 'Slider ratio to widht and height, such as 16:9',
				'condition'   => [
					'_skin!' => 'ink-vast',
				],
			]
		);

		$this->add_control(
			'slider_min_height',
			[
				'label'     => esc_html__( 'Slider Minimum Height', 'colorway-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'condition' => [
					'_skin!' => 'ink-vast',
				],
				'range' => [
					'px' => [
						'min' => 50,
						'max' => 1024,
					],
				],
			]
		);

		$this->add_control(
			'slider_max_height',
			[
				'label'     => esc_html__( 'Slider Max Height', 'colorway-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'condition' => [
					'_skin!' => 'ink-vast',
				],
				'range' => [
					'px' => [
						'min' => 50,
						'max' => 1024,
					],
				],
			]
		);

		$this->add_responsive_control(
			'slider_container_width',
			[
				'label' => esc_html__( 'Container Width', 'colorway-addons' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 50,
						'max' => 1500,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ink-post-slider .ink-post-slider-content-wrap' => 'max-width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ink-post-slider .ink-post-slider-content'      => 'max-width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ink-post-slider .ink-post-slider-pagination'   => 'max-width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'_skin' => '',
				],
			]
		);

		$this->add_responsive_control(
			'content_width',
			[
				'label' => esc_html__( 'Content Width', 'colorway-addons' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 300,
						'max' => 1500,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ink-post-slider .ink-post-slider-content' => 'max-width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'_skin' => '',
				],
			]
		);

		$this->add_control(
			'content_align',
			[
				'label'   => esc_html__( 'Content Alignment', 'colorway-addons' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left'    => [
						'title' => esc_html__( 'Left', 'colorway-addons' ),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'colorway-addons' ),
						'icon'  => 'fa fa-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'colorway-addons' ),
						'icon'  => 'fa fa-align-right',
					],
				],
				'description'  => 'Use align to match position',
				'default'      => 'left',
				'prefix_class' => 'elementor-align-',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_button',
			[
				'label'     => esc_html__( 'Button', 'colorway-addons' ),
				'condition' => [
					'show_button' => 'yes',
				],
			]
		);

		$this->add_control(
			'button_text',
			[
				'label'       => esc_html__( 'Button Text', 'colorway-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Read More', 'colorway-addons' ),
				'placeholder' => esc_html__( 'Read More', 'colorway-addons' ),
			]
		);

		$this->add_control(
			'icon',
			[
				'label'       => esc_html__( 'Icon', 'colorway-addons' ),
				'type'        => Controls_Manager::ICON,
				'label_block' => true,
			]
		);

		$this->add_control(
			'icon_align',
			[
				'label'   => esc_html__( 'Icon Position', 'colorway-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'right',
				'options' => [
					'left'  => esc_html__( 'Before', 'colorway-addons' ),
					'right' => esc_html__( 'After', 'colorway-addons' ),
				],
				'condition' => [
					'icon!' => '',
				],
			]
		);

		$this->add_control(
			'icon_indent',
			[
				'label'   => esc_html__( 'Icon Spacing', 'colorway-addons' ),
				'type'    => Controls_Manager::SLIDER,
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
					'{{WRAPPER}} .ink-post-slider .ink-button-icon-align-right' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ink-post-slider .ink-button-icon-align-left' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_query',
			[
				'label' => __( 'Query', 'colorway-addons' ),
			]
		);

		$this->add_group_control(
			Group_Control_Posts::get_type(),
			[
				'name'  => 'posts',
				'label' => __( 'Posts', 'colorway-addons' ),
			]
		);

		$this->add_control(
			'advanced',
			[
				'label' => __( 'Advanced', 'colorway-addons' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'orderby',
			[
				'label'   => __( 'Order By', 'colorway-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'post_date',
				'options' => [
					'post_date'  => __( 'Date', 'colorway-addons' ),
					'post_title' => __( 'Title', 'colorway-addons' ),
					'menu_order' => __( 'Menu Order', 'colorway-addons' ),
					'rand'       => __( 'Random', 'colorway-addons' ),
				],
			]
		);

		$this->add_control(
			'order',
			[
				'label'   => __( 'Order', 'colorway-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'desc',
				'options' => [
					'asc'  => __( 'ASC', 'colorway-addons' ),
					'desc' => __( 'DESC', 'colorway-addons' ),
				],
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'section_post_slider_animation',
			[
				'label' => esc_html__( 'Animation', 'colorway-addons' ),
				//'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label' => esc_html__( 'Autoplay', 'colorway-addons' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'autoplay_interval',
			[
				'label'     => esc_html__( 'Autoplay Interval', 'colorway-addons' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 7000,
				'condition' => [
					'autoplay' => 'yes',
				],
			]
		);

		$this->add_control(
			'pause_on_hover',
			[
				'label' => esc_html__( 'Pause on Hover', 'colorway-addons' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'speed',
			[
				'label'     => esc_html__( 'Animation Speed', 'colorway-addons' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 500,
			]
		);

		$this->add_control(
			'slider_animations',
			[
				'label'     => esc_html__( 'Slider Animations', 'colorway-addons' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'fade',
				'options'   => [
					'slide' => esc_html__( 'Slide', 'colorway-addons' ),
					'fade'  => esc_html__( 'Fade', 'colorway-addons' ),
					'scale' => esc_html__( 'Scale', 'colorway-addons' ),
					'push'  => esc_html__( 'Push', 'colorway-addons' ),
					'pull'  => esc_html__( 'Pull', 'colorway-addons' ),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_slider',
			[
				'label' => esc_html__( 'Slider', 'colorway-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'overlay',
			[
				'label'   => esc_html__( 'Overlay', 'colorway-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'background',
				'options' => [
					'none'       => esc_html__( 'None', 'colorway-addons' ),
					'background' => esc_html__( 'Background', 'colorway-addons' ),
					'blend'      => esc_html__( 'Blend', 'colorway-addons' ),
				],
			]
		);

		$this->add_control(
			'overlay_color',
			[
				'label'     => esc_html__( 'Overlay Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#333333',
				'condition' => [
					'overlay' => ['background', 'blend']
				],
				'selectors' => [
					'{{WRAPPER}} .ink-post-slider .ink-overlay-default' => 'background-color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'overlay_opacity',
			[
				'label'   => esc_html__( 'Overlay Opacity', 'colorway-addons' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0.4,
				],
				'range' => [
					'px' => [
						'max' => 1,
						'min' => 0.1,
						'step' => 0.01,
					],
				],
				'condition' => [
					'overlay' => ['background', 'blend']
				],
				'selectors' => [
					'{{WRAPPER}} .ink-post-slider .ink-overlay-default' => 'opacity: {{SIZE}};'
				]
			]
		);

		$this->add_control(
			'blend_type',
			[
				'label'     => esc_html__( 'Blend Type', 'colorway-addons' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'multiply',
				'options'   => colorway_addons_blend_options(),
				'condition' => [
					'overlay' => 'blend',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_tag',
			[
				'label'     => esc_html__( 'Tag', 'colorway-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_tag' => [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'tag_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ink-post-slider .ink-post-slider-tag-wrap span' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'tag_color',
			[
				'label'     => esc_html__( 'Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ink-post-slider .ink-post-slider-tag-wrap span a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'tag_border',
				'label'    => __( 'Border', 'colorway-addons' ),
				'selector' => '{{WRAPPER}} .ink-post-slider .ink-post-slider-tag-wrap span',
			]
		);

		$this->add_control(
			'tag_border_radius',
			[
				'label' => __( 'Border Radius', 'colorway-addons' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ink-post-slider .ink-post-slider-tag-wrap span' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'tag_typography',
				'label'    => esc_html__( 'Typography', 'colorway-addons' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .ink-post-slider .ink-post-slider-tag-wrap span',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_title',
			[
				'label'     => esc_html__( 'Title', 'colorway-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_title' => [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ink-post-slider .ink-post-slider-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'label'    => esc_html__( 'Typography', 'colorway-addons' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .ink-post-slider .ink-post-slider-title',
			]
		);

		$this->add_responsive_control(
			'title_spacing',
			[
				'label' => esc_html__( 'Spacing', 'colorway-addons' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ink-post-slider .ink-post-slider-title' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_text',
			[
				'label' => esc_html__( 'Text', 'colorway-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'text_color',
			[
				'label'     => esc_html__( 'Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ink-post-slider .ink-post-slider-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'text_typography',
				'label'    => esc_html__( 'Typography', 'colorway-addons' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .ink-post-slider .ink-post-slider-text',
			]
		);

		$this->add_responsive_control(
			'text_spacing',
			[
				'label' => esc_html__( 'Spacing', 'colorway-addons' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ink-post-slider .ink-post-slider-text' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_meta',
			[
				'label' => esc_html__( 'Meta', 'colorway-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'meta_color',
			[
				'label'     => esc_html__( 'Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ink-post-slider .ink-post-slider-meta' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'meta_typography',
				'label'    => esc_html__( 'Typography', 'colorway-addons' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .ink-post-slider .ink-post-slider-meta',
			]
		);

		$this->add_responsive_control(
			'meta_spacing',
			[
				'label' => esc_html__( 'Spacing', 'colorway-addons' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ink-post-slider .ink-post-slider-meta' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_button',
			[
				'label'     => esc_html__( 'Button', 'colorway-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_button' => 'yes',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label' => esc_html__( 'Normal', 'colorway-addons' ),
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ink-post-slider .ink-post-slider-button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'background_color',
			[
				'label'     => esc_html__( 'Background Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ink-post-slider .ink-post-slider-button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'button_border',
				'label'       => esc_html__( 'Border', 'colorway-addons' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .ink-post-slider .ink-post-slider-button',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'button_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'colorway-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ink-post-slider .ink-post-slider-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'button_padding',
			[
				'label'      => esc_html__( 'Padding', 'colorway-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ink-post-slider .ink-post-slider-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'button_spacing',
			[
				'label' => esc_html__( 'Spacing', 'colorway-addons' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ink-post-slider .ink-post-slider-button-wrap' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_typography',
				'label'    => esc_html__( 'Typography', 'colorway-addons' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .ink-post-slider .ink-post-slider-button',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label' => esc_html__( 'Hover', 'colorway-addons' ),
			]
		);

		$this->add_control(
			'hover_color',
			[
				'label'     => esc_html__( 'Text Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ink-post-slider .ink-post-slider-button:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ink-post-slider .ink-post-slider-button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'button_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .ink-post-slider .ink-post-slider-button:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_animation',
			[
				'label' => esc_html__( 'Animation', 'colorway-addons' ),
				'type'  => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_pagination',
			[
				'label'     => esc_html__( 'Pagination', 'colorway-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'_skin' => '',
				],
			]
		);

		$this->add_control(
			'pagination_text_color',
			[
				'label'     => esc_html__( 'Pagination Text Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ink-post-slider .ink-post-slider-pagination h6' => 'color: {{VALUE}}',
					'{{WRAPPER}} .ink-post-slider .ink-post-slider-pagination span' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'thumb_background_color',
			[
				'label'     => esc_html__( 'Thumb Background Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ink-post-slider .ink-post-slider-thumb-wrap' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'show_pagination_thumb' => 'yes',
				],
			]
		);

		$this->add_control(
			'thumb_opacity',
			[
				'label' => esc_html__( 'Thumb Opacity', 'colorway-addons' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 1,
						'min' => 0.1,
						'step' => 0.01,
					],
				],
				'condition' => [
					'show_pagination_thumb' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .ink-post-slider .ink-post-slider-thumb-wrap img' => 'opacity: {{SIZE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'thumb_border',
				'label'     => __( 'Border', 'colorway-addons' ),
				'selector'  => '{{WRAPPER}} .ink-post-slider .ink-post-slider-thumb-wrap',
				'condition' => [
					'show_pagination_thumb' => 'yes',
				],
			]
		);

		$this->add_control(
			'thumb_border_radius',
			[
				'label' => __( 'Thumb Border Radius', 'colorway-addons' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'condition' => [
					'show_pagination_thumb' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .ink-post-slider .ink-post-slider-thumb-wrap' => 'border-radius: {{SIZE}}{{UNIT}}; overflow: hidden;',
				],
			]
		);

		$this->add_control(
			'pagination_border_color',
			[
				'label'     => esc_html__( 'Upper Border Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ink-post-slider .ink-post-slider-pagination .ink-thumbnav' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'pagination_active_border_color',
			[
				'label'     => esc_html__( 'Active Border Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ink-post-slider .ink-post-slider-pagination .ink-active .ink-post-slider-pagination-item' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'pagination_title_typography',
				'label'    => esc_html__( 'Title Typography', 'colorway-addons' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .ink-post-slider .ink-post-slider-pagination .ink-thumbnav .ink-post-slider-pagination-item h6',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'pagination_date_typography',
				'label'    => esc_html__( 'Date Typography', 'colorway-addons' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .ink-post-slider .ink-post-slider-pagination .ink-thumbnav .ink-post-slider-pagination-item .ink-post-slider-date',
			]
		);

		$this->end_controls_section();

	}

	public function get_taxonomies() {
		$taxonomies = get_taxonomies( [ 'show_in_nav_menus' => true ], 'objects' );

		$options = [ '' => '' ];

		foreach ( $taxonomies as $taxonomy ) {
			$options[ $taxonomy->name ] = $taxonomy->label;
		}

		return $options;
	}

	public function query_posts() {
		$query_args = Module::get_query_args( 'posts', $this->get_settings() );

		$query_args['posts_per_page'] = 4;

		$this->_query = new \WP_Query( $query_args );
	}

	public function render() {
		$this->query_posts();

		$wp_query = $this->get_query();

		if ( ! $wp_query->found_posts ) {
			return;
		}

		add_filter( 'excerpt_more', [ $this, 'filter_excerpt_more' ], 35 );
		add_filter( 'excerpt_length', [ $this, 'filter_excerpt_length' ], 35 );

		$this->render_header();

		while ( $wp_query->have_posts() ) {
			$wp_query->the_post();

			$this->render_post();
		}

		$this->render_footer();

		remove_filter( 'excerpt_length', [ $this, 'filter_excerpt_length' ], 35 );
		remove_filter( 'excerpt_more', [ $this, 'filter_excerpt_more' ], 35 );

		wp_reset_postdata();
	}

	public function filter_excerpt_length() {
		return $this->get_settings( 'excerpt_length' );
	}

	public function filter_excerpt_more( $more ) {
		return '';
	}

	public function render_title() {
		if ( ! $this->get_settings( 'show_title' ) ) {
			return;
		}

		$tag = $this->get_settings( 'title_tag' );
		$classes = ['ink-post-slider-title', 'ink-margin-remove-bottom'];
		?>
		<div class="ink-post-slider-title-wrap">
			<a href="<?php echo esc_url(get_permalink()); ?>">
				<<?php echo $tag ?> class="<?php echo implode(" ", $classes); ?>" ink-slideshow-parallax="x: 200,-200">
					<?php the_title() ?>
				</<?php echo $tag ?>>
			</a>
		</div>
		<?php
	}

	public function render_excerpt() {
		if ( ! $this->get_settings( 'show_text' ) ) {
			return;
		}
		?>
		<div class="ink-post-slider-text ink-visible@m" ink-slideshow-parallax="x: 500,-500">
			<?php the_excerpt(); ?>
		</div>
		<?php
	}

	public function render_read_more_button() {
		if ( ! $this->get_settings( 'show_button' ) ) {
			return;
		}
		$settings  = $this->get_settings();
		$animation = ($settings['button_hover_animation']) ? ' elementor-animation-'.$settings['button_hover_animation'] : '';
		?>
		<div class="ink-post-slider-button-wrap" ink-slideshow-parallax="y: 200,-200">
			<a href="<?php echo esc_url(get_permalink()); ?>" class="ink-post-slider-button ink-display-inline-block<?php echo esc_attr($animation); ?>">
				<?php echo esc_attr($this->get_settings( 'button_text' )); ?>

				<?php if ($settings['icon']) : ?>
					<span class="ink-button-icon-align-<?php echo esc_attr($settings['icon_align']); ?>">
						<i class="<?php echo esc_attr($settings['icon']); ?>"></i>
					</span>
				<?php endif; ?>
			</a>
		</div>
		<?php
	}

	public function render_header() {
		$settings        = $this->get_settings();
		$id              = $this->get_id();
		$slides_settings = [];
		$ratio           = ($settings['slider_size_ratio']['width'] && $settings['slider_size_ratio']['height']) ? $settings['slider_size_ratio']['width'].":".$settings['slider_size_ratio']['height'] : '';

		$slider_settings['ink-slideshow'] = json_encode(array_filter([
			'animation'         => $settings['slider_animations'],
			'min-height'        => $settings['slider_min_height']['size'],
			'max-height'        => $settings['slider_max_height']['size'],
			'ratio'             => $ratio,
			'autoplay'          => $settings['autoplay'],
			'autoplay-interval' => $settings['autoplay_interval'],
			'pause-on-hover'    => $settings['pause_on_hover'],
	    ]));
	    
		?>
		<div id="ink-post-slider-<?php echo $id;?>" class="ink-post-slider ink-post-slider-skin-default" <?php echo \colorway_addons_helper::attrs($slider_settings); ?>>
			<div class="ink-slideshow-items">
		<?php
	}

	public function render_footer() {
		$settings = $this->get_settings();
		$id       = $this->get_id();
		?>
			</div>
			<?php $this->render_loop_pagination(); ?>
		</div>
		
		<?php
	}

	public function render_loop_item() {
		$settings         = $this->get_settings();
		$classes          = [ 'ink-background-cover', 'ink-post-slider-item' ];
		$classes[]        = ($this->get_settings('item_color')) ? 'ink-'.$this->get_settings('item_color') : '';
		
		$slider_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );

		?>

		<div <?php post_class( $classes ); ?> style="background-image: url(<?php echo esc_url($slider_thumbnail[0]); ?>);">
			<div class="ink-post-slider-content-wrap ink-position-center ink-position-z-index">
				<div class="ink-post-slider-content">

	                <?php if ($settings['show_tag']) : ?>
	                	<div class="ink-post-slider-tag-wrap" ink-slideshow-parallax="y: -200,200">
	                		<?php
							$tags_list = get_the_tag_list( '<span class="ink-background-primary">', '</span> <span class="ink-background-primary">', '</span>');
		                		if ($tags_list) :
		                    		echo  wp_kses_post($tags_list);
		                		endif; ?>
	                	</div>
	            	<?php endif;

					$this->render_title();
					$this->render_excerpt();

					?>

					<?php if ($settings['show_meta']) : ?>
						<div class="ink-post-slider-meta ink-flex-inline ink-flex-middile" ink-slideshow-parallax="x: 250,-250">
							<div class="ink-post-slider-author ink-border-circle ink-overflow-hidden ink-visible@m"><?php echo get_avatar( get_the_author_meta( 'ID' ) , 28 ); ?></div>
							<span><?php echo esc_attr(get_the_author()); ?></span>
							<span><?php esc_html_e('On', 'colorway-addons'); ?> <?php echo esc_attr(get_the_date('M d, Y')); ?></span>
						</div>
					<?php endif; ?>
					
					<?php $this->render_read_more_button(); ?>

				</div>
			</div>

			<?php if( 'none' !== $settings['overlay'] ) :
				$blend_type = ( 'blend' == $settings['overlay']) ? ' ink-blend-'.$settings['blend_type'] : ''; ?>
				<div class="ink-overlay-default ink-position-cover<?php echo esc_attr($blend_type); ?>"></div>
	        <?php endif; ?>

		</div>

		<?php
	}

	public function render_loop_pagination() {
		$this->query_posts();

		$wp_query = $this->get_query();

		if ( ! $wp_query->found_posts ) {
			return;
		}

		$settings = $this->get_settings();
		$id       = $this->get_id();
		$classes  = ['ink-post-slider'];
		$ps_count = 0;

		?>
		<div id="<?php echo $id; ?>_nav"  class="ink-post-slider-pagination ink-position-bottom-center">
		     <ul class="ink-thumbnav ink-grid ink-grid-small ink-child-width-auto ink-child-width-1-4@m ink-flex-center" ink-grid> 

		<?php		
		      
		while ( $wp_query->have_posts() ) {
			$wp_query->the_post();
			?>
			<li ink-slideshow-item="<?php echo esc_attr($ps_count); ?>" class="">
				<div class="ink-post-slider-pagination-item">
					<a href="#">
						<div class="ink-flex ink-flex-middle ink-text-left">
							<?php if ( 'yes' == $settings['show_pagination_thumb']) :
								$slider_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id(), 'thumbnail' ); ?>
								<div class="ink-width-auto ink-post-slider-thumb-wrap">
									<img src="<?php echo esc_url($slider_thumbnail[0]); ?>" alt="">
								</div>
		        			<?php endif; ?>
							<div class="ink-margin-small-left ink-visible@m">
								<h6 class="ink-margin-remove-bottom"><?php echo esc_attr(get_the_title()); ?></h6>
								<span class="ink-post-slider-date"><?php echo esc_attr(get_the_date('M d, Y')); ?><span>
							</div>
						</div>
					</a>
				</div>
			</li>

			<?php
			$ps_count++;
		} ?>
		    
	        </ul>
		</div>
		<?php
	}

	public function render_post() {
		$this->render_loop_item();
	}
}
