<?php

namespace CwAddons\Modules\WpMenuBar\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Background;
use CwAddons\Modules\WpMenuBar\ca_menu_walker;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class WpMenuBar extends Widget_Base {

	public function get_name() {
		return 'ink-wp-menu-bar';
	}

	public function get_title() {
		return esc_html__( 'WP Menu Bar', 'colorway-addons' );
	}

	public function get_icon() {
		return 'ink-widget-icon fas fa-ellipsis-h';
	}

	public function get_categories() {
		return [ 'colorway-addons' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_navbar_content',
			[
				'label' => esc_html__( 'Navbar', 'colorway-addons' ),
			]
		);

		$this->add_control(
			'navbar',
			[
				'label'   => esc_html__( 'Select Menu', 'colorway-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => colorway_addons_get_menu(),
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label'   => esc_html__( 'Alignment', 'colorway-addons' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title' => esc_html__( 'Left', 'colorway-addons' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'colorway-addons' ),
						'icon'  => 'eicon-h-align-center',
					],
					'flex-end'  => [
						'title' => esc_html__( 'Right', 'colorway-addons' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ink-navbar-container' => 'justify-content: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'menu_offset',
			[
				'label' => esc_html__( 'Offset', 'colorway-addons' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => -150,
						'max' => 150,
					],
				],
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .ink-navbar-nav' => 'transform: translateX({{SIZE}}{{UNIT}});',
				],
			]
		);

		$this->add_responsive_control(
			'text_padding',
			[
				'label'      => esc_html__( 'Padding', 'colorway-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ink-navbar-nav > li > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'menu_height',
			[
				'label' => esc_html__( 'Menu Height', 'colorway-addons' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 20,
						'max' => 150,
					],
				],
				'size_units' => [ 'px'],
				'selectors'  => [
					'{{WRAPPER}} .ink-navbar-nav > li > a' => 'min-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'menu_parent_arrow',
			[
				'label'        => __( 'Parent Indicator', 'colorway-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'prefix_class' => 'ink-navbar-parent-indicator-',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'dropdown_content',
			[
				'label' => esc_html__( 'Dropdown', 'colorway-addons' ),
			]
		);

		$this->add_responsive_control(
			'dropdown_align',
			[
				'label'     => esc_html__( 'Dropdown Alignment', 'colorway-addons' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => esc_html__( 'Left', 'colorway-addons' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'colorway-addons' ),
						'icon'  => 'eicon-h-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'colorway-addons' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
			]
		);

		$this->add_responsive_control(
			'dropdown_link_align',
			[
				'label'   => esc_html__( 'Item Alignment', 'colorway-addons' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
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
				'selectors' => [
					'{{WRAPPER}} .ink-navbar-dropdown-nav > li > a' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'dropdown_padding',
			[
				'label'      => esc_html__( 'Dropdown Padding', 'colorway-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ink-navbar-dropdown' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'dropdown_width',
			[
				'label' => esc_html__( 'Dropdown Width', 'colorway-addons' ),
				'type'  => Controls_Manager::SLIDER,
                            'size_units' => [ '%'],
//				'range' => [
//					'px' => [
//						'min' => 150,
//						'max' => 350,
//					],
//				],
				
				'selectors'  => [
					'{{WRAPPER}} .ink-navbar-dropdown' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'dropdown_additional',
			[
				'label' => esc_html__( 'Additional', 'colorway-addons' ),
			]
		);

		$this->add_control(
			'dropdown_delay_show',
			[
				'label' => esc_html__( 'Delay Show', 'colorway-addons' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 2000,
					],
				],
			]
		);

		$this->add_control(
			'dropdown_delay_hide',
			[
				'label' => esc_html__( 'Delay Hide', 'colorway-addons' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 2000,
					],
				],
				'default' => ['size' => 800],
			]
		);

		$this->add_control(
			'dropdown_duration',
			[
				'label' => esc_html__( 'Dropdown Duration', 'colorway-addons' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 2000,
					],
				],
				'default' => ['size' => 200],
			]
		);

		$this->add_control(
			'dropdown_offset',
			[
				'label' => esc_html__( 'Dropdown Offset', 'colorway-addons' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_menu_style',
			[
				'label' => esc_html__( 'Navbar', 'colorway-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'navbar_style',
			[
				'label'   => __( 'Navbar Style', 'colorway-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					''  => __( 'Select Style', 'colorway-addons' ),
					'1' => __( 'Style 1', 'colorway-addons' ),
					'2' => __( 'Style 2', 'colorway-addons' ),
					'3' => __( 'Style 3', 'colorway-addons' ),
				],
				'prefix_class' => 'ink-navbar-style-',
			]
		);

		$this->start_controls_tabs( 'menu_link_styles' );

		$this->start_controls_tab( 'menu_link_normal', [ 'label' => esc_html__( 'Normal', 'colorway-addons' ) ] );

		$this->add_control(
			'menu_link_color',
			[
				'label'     => esc_html__( 'Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ink-navbar-nav > li > a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'menu_link_background',
			[
				'label'     => esc_html__( 'Background', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ink-navbar-nav > li > a' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'menu_spacing',
			[
				'label' => esc_html__( 'Gap', 'colorway-addons' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 25,
					],
				],
				'size_units' => [ 'px'],
				'selectors'  => [
					'{{WRAPPER}} .ink-navbar-nav' => 'margin-left: -{{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ink-navbar-nav > li' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'menu_border',
				'label'    => esc_html__( 'Border', 'colorway-addons' ),
				'default'  => '1px',
				'selector' => '{{WRAPPER}} .ink-navbar-nav > li > a',
			]
		);

		$this->add_control(
			'menu_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'colorway-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ink-navbar-nav > li > a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'menu_typography_normal',
				'label'    => esc_html__( 'Typography', 'colorway-addons' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .ink-navbar-nav > li > a',
			]
		);

		$this->add_control(
			'menu_parent_arrow_color',
			[
				'label'     => esc_html__( 'Parent Indicator Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.ink-navbar-parent-indicator-yes .ink-navbar-nav > li.ink-parent a:after' => 'color: {{VALUE}};',
				],
				'condition' => ['menu_parent_arrow' => 'yes'],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'menu_link_hover', [ 'label' => esc_html__( 'Hover', 'colorway-addons' ) ] );

		$this->add_control(
			'navbar_hover_style_color',
			[
				'label'     => esc_html__( 'Style Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ink-navbar-nav > li:hover > a:before' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .ink-navbar-nav > li:hover > a:after'  => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'navbar_style!' => '',
				],
			]
		);

		$this->add_control(
			'menu_link_color_hover',
			[
				'label'     => esc_html__( 'Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ink-navbar-nav > li > a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'link_background_hover',
			[
				'label'     => esc_html__( 'Background Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ink-navbar-nav > li > a:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'menu_border_color_hover',
			[
				'label'     => esc_html__( 'Border Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ink-navbar-nav > li > a:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'menu_border_radius_hover',
			[
				'label'      => esc_html__( 'Border Radius', 'colorway-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ink-navbar-nav > li > a:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'menu_typography_hover',
				'label'    => esc_html__( 'Typography', 'colorway-addons' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .ink-navbar-nav > li > a:hover',
			]
		);

		$this->add_control(
			'menu_parent_arrow_color_hover',
			[
				'label'     => esc_html__( 'Parent Indicator Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.ink-navbar-parent-indicator-yes .ink-navbar-nav > li.ink-parent a:hover::after' => 'color: {{VALUE}};',
				],
				'condition' => ['menu_parent_arrow' => 'yes'],
			]
		);


		$this->end_controls_tab();

		$this->start_controls_tab( 'menu_link_active', [ 'label' => esc_html__( 'Active', 'colorway-addons' ) ] );

		$this->add_control(
			'navbar_active_style_color',
			[
				'label'     => esc_html__( 'Style Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ink-navbar-nav > li.ink-active > a:before' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .ink-navbar-nav > li.ink-active > a:after'  => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'navbar_style!' => '',
				],
			]
		);

		$this->add_control(
			'menu_hover_color_active',
			[
				'label'     => esc_html__( 'Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ink-navbar-nav > li.ink-active > a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'menu_hover_background_color_active',
			[
				'label'     => esc_html__( 'Background', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ink-navbar-nav > li.ink-active > a' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'menu_border_active',
				'label'    => esc_html__( 'Border', 'colorway-addons' ),
				'default'  => '1px',
				'selector' => '{{WRAPPER}} .ink-navbar-nav > li.ink-active > a',
			]
		);

		$this->add_control(
			'menu_border_radius_active',
			[
				'label'      => esc_html__( 'Border Radius', 'colorway-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ink-navbar-nav > li.ink-active > a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'menu_typography_active',
				'label'    => esc_html__( 'Typography', 'colorway-addons' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .ink-navbar-nav > li.ink-active > a',
			]
		);

		$this->add_control(
			'menu_parent_arrow_color_active',
			[
				'label'     => esc_html__( 'Parent Indicator Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.ink-navbar-parent-indicator-yes .ink-navbar-nav > li.ink-parent.ink-active a:after' => 'color: {{VALUE}};',
				],
				'condition' => ['menu_parent_arrow' => 'yes'],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'dropdown_color',
			[
				'label' => esc_html__( 'Dropdown', 'colorway-addons' ),
				'type'  => Controls_Manager::SECTION,
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'dropdown_background',
			[
				'label'     => esc_html__( 'Dropdown Background', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ink-navbar-dropdown' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->start_controls_tabs( 'dropdown_link_styles' );

		$this->start_controls_tab( 'dropdown_link_normal', [ 'label' => esc_html__( 'Normal', 'colorway-addons' ) ] );

		$this->add_control(
			'dropdown_link_color',
			[
				'label'     => esc_html__( 'Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ink-navbar-dropdown-nav > li > a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'dropdown_link_background',
			[
				'label'     => esc_html__( 'Background', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ink-navbar-dropdown-nav > li > a' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'dropdown_link_spacing',
			[
				'label' => esc_html__( 'Gap', 'colorway-addons' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 25,
					],
				],
				'size_units' => [ 'px'],
				'selectors'  => [
					'{{WRAPPER}} .ink-navbar-dropdown-nav > li + li' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'dropdown_link_padding',
			[
				'label'      => esc_html__( 'Padding', 'colorway-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ink-navbar-dropdown-nav > li > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'dropdown_link_border',
				'label'    => esc_html__( 'Border', 'colorway-addons' ),
				'default'  => '1px',
				'selector' => '{{WRAPPER}} .ink-navbar-dropdown-nav > li > a',
			]
		);

		$this->add_control(
			'dropdown_link_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'colorway-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ink-navbar-dropdown-nav > li > a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'dropdown_link_typography',
				'label'    => esc_html__( 'Typography', 'colorway-addons' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .ink-navbar-dropdown-nav > li > a',
			]
		);

		$this->add_control(
			'dropdown_parent_arrow_color',
			[
				'label'     => esc_html__( 'Parent Indicator Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.ink-navbar-parent-indicator-yes .ink-navbar-dropdown-nav > li.ink-parent a:after' => 'color: {{VALUE}};',
				],
				'condition' => ['menu_parent_arrow' => 'yes'],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'dropdown_link_hover', [ 'label' => esc_html__( 'Hover', 'colorway-addons' ) ] );

		$this->add_control(
			'dropdown_link_hover_color',
			[
				'label'     => esc_html__( 'Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ink-navbar-dropdown-nav > li > a:hover' => 'color: {{VALUE}};',
				],
			]
		);


		$this->add_control(
			'dropdown_link_hover_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ink-navbar-dropdown-nav > li > a:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'dropdown_border_hover_color',
			[
				'label'     => esc_html__( 'Border Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ink-navbar-dropdown-nav > li > a:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'dropdown_radius_hover',
			[
				'label'      => esc_html__( 'Border Radius', 'colorway-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ink-navbar-dropdown-nav > li > a:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'dropdown_typography_hover',
				'label'    => esc_html__( 'Typography', 'colorway-addons' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .ink-navbar-dropdown-nav > li > a:hover',
			]
		);

		$this->add_control(
			'dropdown_parent_arrow_color_hover',
			[
				'label'     => esc_html__( 'Parent Indicator Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.ink-navbar-parent-indicator-yes .ink-navbar-dropdown-nav > li.ink-parent a:hover::after' => 'color: {{VALUE}};',
				],
				'condition' => ['menu_parent_arrow' => 'yes'],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'dropdown_link_active', [ 'label' => esc_html__( 'Active', 'colorway-addons' ) ] );

			$this->add_control(
				'dropdown_active_color',
				[
					'label'     => esc_html__( 'Color', 'colorway-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ink-navbar-dropdown-nav > li.ink-active > a' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'dropdown_active_bg_color',
				[
					'label'     => esc_html__( 'Background', 'colorway-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ink-navbar-dropdown-nav > li.ink-active > a' => 'background-color: {{VALUE}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'dropdown_active_border',
					'label'    => esc_html__( 'Border', 'colorway-addons' ),
					'default'  => '1px',
					'selector' => '{{WRAPPER}} .ink-navbar-dropdown-nav > li.ink-active > a',
				]
			);

			$this->add_control(
				'dropdown_active_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'colorway-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .ink-navbar-dropdown-nav > li.ink-active > a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'dropdown_typography_active',
					'label'    => esc_html__( 'Typography', 'colorway-addons' ),
					'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
					'selector' => '{{WRAPPER}} .ink-navbar-dropdown-nav > li.ink-active > a',
				]
			);

			$this->add_control(
				'dropdown_parent_arrow_color_active',
				[
					'label'     => esc_html__( 'Parent Indicator Color', 'colorway-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.ink-navbar-parent-indicator-yes .ink-navbar-dropdown-nav > li.ink-parent.ink-active a:after' => 'color: {{VALUE}};',
					],
					'condition' => ['menu_parent_arrow' => 'yes'],
				]
			);


		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {

		$settings = $this->get_settings();
		$id       = 'ink-navbar-' . $this->get_id();
		$nav_menu = ! empty( $settings['navbar'] ) ? wp_get_nav_menu_object( $settings['navbar'] ) : false;

		if ( ! $nav_menu ) {
			return;
		}

		$nav_menu_args = array(
			'fallback_cb'    => false,
			'container'      => false,
			'menu_id'        => 'ink-navmenu',
			'menu_class'     => 'ink-navbar-nav',
			'theme_location' => 'default_navmenu', // creating a fake location for better functional control
			'menu'           => $nav_menu,
			'echo'           => true,
			'depth'          => 0,
			'walker'        => new ca_menu_walker
		);

		$this->add_render_attribute(
			[
				'navbar-attr' => [
					'class' => [
						'ink-navbar-container',
						'ink-navbar',
						'ink-navbar-transparent'
					],
					'ink-navbar' => [
						wp_json_encode(array_filter([
							'align'      => $settings['dropdown_align'] ? $settings['dropdown_align'] : 'left',
							'delay-show' => $settings['dropdown_delay_show']['size'] ? $settings['dropdown_delay_show']['size'] : false,
							'delay-hide' => $settings['dropdown_delay_hide']['size'] ? $settings['dropdown_delay_hide']['size'] : false,
							'offset'     => $settings['dropdown_offset']['size'] ? $settings['dropdown_offset']['size'] : false,
							'duration'   => $settings['dropdown_duration']['size'] ? $settings['dropdown_duration']['size'] : false
						]))
					]
				]
			]
		);

        ?>
        <div id="<?php esc_attr($id); ?>" class="ink-navbar-wrapper">
            <nav <?php echo $this->get_render_attribute_string('navbar-attr'); ?>>
                <?php wp_nav_menu(apply_filters('widget_nav_menu_args', $nav_menu_args, $nav_menu, $settings)); ?>
                <label class="menu-icon" for="menu-btn"><i class="fas fa-bars"></i></label>    
            </nav>
        </div>

        <script>
            jQuery(document).ready(function () {
                jQuery(".menu-icon").toggle(function () {
                    jQuery("ul#ink-navmenu").css("display", "block");
                }, function () {
                    jQuery("ul#ink-navmenu").css("display", "none");
                });
            });
        </script>

        <?php
	}
}