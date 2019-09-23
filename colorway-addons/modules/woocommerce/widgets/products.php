<?php
namespace CwAddons\Modules\Woocommerce\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;

use CwAddons\Modules\Woocommerce\Skins;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Products extends Widget_Base {

	public function get_name() {
		return 'ink-wc-products';
	}

	public function get_title() {
		return esc_html__( 'WC - Products', 'colorway-addons' );
	}

	public function get_icon() {
		return 'ink-widget-icon fab fa-product-hunt';
	}

	public function get_categories() {
		return [ 'colorway-addons' ];
	}

	public function get_script_depends() {
		return [ 'datatables' ];
	}

	public function get_style_depends() {
		return [ 'datatables' ];
	}

	public function _register_skins() {
		$this->add_skin( new Skins\Skin_Table( $this ) );
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_woocommerce_layout',
			[
				'label' => esc_html__( 'Layout', 'colorway-addons' ),
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label'          => esc_html__( 'Columns', 'colorway-addons' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => '4',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'options'        => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',
				],
				'condition' => [
					'_skin' => '',
				],
			]
		);

		$this->add_responsive_control(
			'item_gap',
			[
				'label'   => esc_html__( 'Column Gap', 'colorway-addons' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 30,
				],
				'range' => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 5,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ink-wc-products .ink-wc-products-wrapper.ink-grid'     => 'margin-left: -{{SIZE}}px',
					'{{WRAPPER}} .ink-wc-products .ink-wc-products-wrapper.ink-grid > *' => 'padding-left: {{SIZE}}px',
				],
				'condition' => [
					'_skin' => '',
				],
			]
		);

		$this->add_responsive_control(
			'row_gap',
			[
				'label'   => esc_html__( 'Row Gap', 'colorway-addons' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 30,
				],
				'range' => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 5,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ink-wc-products .ink-wc-products-wrapper.ink-grid'     => 'margin-top: -{{SIZE}}px',
					'{{WRAPPER}} .ink-wc-products .ink-wc-products-wrapper.ink-grid > *' => 'margin-top: {{SIZE}}px',
				],
				'condition' => [
					'_skin' => '',
				],
			]
		);

//		$this->add_control(
//			'alignment',
//			[
//				'label'   => esc_html__( 'Alignment', 'colorway-addons' ),
//				'type'    => Controls_Manager::CHOOSE,
//				'default' => 'center',
//				'options' => [
//					'left' => [
//						'title' => esc_html__( 'Left', 'colorway-addons' ),
//						'icon'  => 'fa fa-align-left',
//					],
//					'center' => [
//						'title' => esc_html__( 'Center', 'colorway-addons' ),
//						'icon'  => 'fa fa-align-center',
//					],
//					'right' => [
//						'title' => esc_html__( 'Right', 'colorway-addons' ),
//						'icon'  => 'fa fa-align-right',
//					],
//				],
//				'selectors' => [
//					'{{WRAPPER}} .ink-wc-products .ink-wc-product .ink-wc-product-inner' => 'text-align: {{VALUE}}',
//					'{{WRAPPER}} .ink-wc-products .ink-wc-product .star-rating' => 'text-align: {{VALUE}}; display: inline-block !important',
//				],
//				'condition' => [
//					'_skin' => '',
//				],
//			]
//		);

		$this->add_control(
			'table_header_alignment',
			[
				'label'   => esc_html__( 'Header Alignment', 'colorway-addons' ),
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
					'{{WRAPPER}} .ink-wc-products table th' => 'text-align: {{VALUE}}',
				],
				'condition' => [
					'_skin!' => '',
				],
			]
		);

		$this->add_control(
			'table_data_alignment',
			[
				'label'   => esc_html__( 'Data Alignment', 'colorway-addons' ),
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
					'{{WRAPPER}} .ink-wc-products table td' => 'text-align: {{VALUE}}',
				],
				'condition' => [
					'_skin!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image',
				'label'     => esc_html__( 'Image Size', 'colorway-addons' ),
				'exclude'   => [ 'custom' ],
				'default'   => 'medium',
				'condition' => [
					'_skin' => '',
				],
			]
		);

		$this->add_control(
			'show_badge',
			[
				'label'     => esc_html__( 'Show Badge', 'colorway-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => [
					'_skin' => '',
				],
			]
		);

		$this->add_control(
			'show_title',
			[
				'label'   => esc_html__( 'Title', 'colorway-addons' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_excerpt',
			[
				'label'     => esc_html__( 'Excerpt', 'colorway-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => [
					'_skin!' => '',
				],
			]
		);

		$this->add_control(
			'excerpt_limit',
			[
				'label'      => esc_html__( 'Excerpt Limit', 'colorway-addons' ),
				'type'       => Controls_Manager::NUMBER,
				'default'    => 10,
				'conditions' => [
					'terms' => [
						[
							'name'  => 'show_excerpt',
							'value' => 'yes',
						],
						[
							'name'     => '_skin',
							'operator' => '!=',
							'value'    => '',
						],
					],
				],
			]
		);

		$this->add_control(
			'show_rating',
			[
				'label'   => esc_html__( 'Rating', 'colorway-addons' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_price',
			[
				'label'   => esc_html__( 'Price', 'colorway-addons' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_cart',
			[
				'label'   => esc_html__( 'Add to Cart', 'colorway-addons' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_searching',
			[
				'label'   => esc_html__( 'Search', 'colorway-addons' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_ordering',
			[
				'label'   => esc_html__( 'Ordering', 'colorway-addons' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_info',
			[
				'label'   => esc_html__( 'Info', 'colorway-addons' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);
                
                $this->add_control(
			'alignment',
			[
				'label'   => esc_html__( 'Alignment', 'colorway-addons' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
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
					'{{WRAPPER}} .ink-wc-products .ink-wc-product .ink-wc-product-inner' => 'text-align: {{VALUE}}',
					'{{WRAPPER}} .ink-wc-products .ink-wc-product .star-rating' => 'text-align: {{VALUE}}; display: inline-block !important',
				],
				'condition' => [
					'_skin' => '',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_query',
			[
				'label' => esc_html__( 'Query', 'colorway-addons' ),
			]
		);

		$this->add_control(
			'posts_per_page',
			[
				'label'   => esc_html__( 'Product Limit', 'colorway-addons' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 8,
			]
		);

		

		$this->add_control(
			'meta_key',
			[
				'label'   => esc_html__( 'Meta Key', 'colorway-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'total_sales',
				'options' => [
					'total_sales'    => esc_html__( 'Total Sales', 'colorway-addons' ),
					'_regular_price' => esc_html__( 'Regular Price', 'colorway-addons' ),
					'_sale_price'    => esc_html__( 'Sale Price', 'colorway-addons' ),
				],
			]
		);

		$this->add_control(
			'orderby',
			[
				'label'   => esc_html__( 'Order by', 'colorway-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'date',
				'options' => [
					'date'     => esc_html__( 'Date', 'colorway-addons' ),
					'title'    => esc_html__( 'Title', 'colorway-addons' ),
					'category' => esc_html__( 'Category', 'colorway-addons' ),
					'rand'     => esc_html__( 'Random', 'colorway-addons' ),
				],
			]
		);

		$this->add_control(
			'order',
			[
				'label'   => esc_html__( 'Order', 'colorway-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'DESC',
				'options' => [
					'DESC' => esc_html__( 'Descending', 'colorway-addons' ),
					'ASC'  => esc_html__( 'Ascending', 'colorway-addons' ),
				],
			]
		);
                
                $this->add_control(
			'show_pagination',
			[
				'label' => esc_html__( 'Pagination', 'colorway-addons' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_item',
			[
				'label'     => esc_html__( 'Item', 'colorway-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'_skin' => '',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_item_style' );

		$this->start_controls_tab(
			'tab_item_normal',
			[
				'label' => esc_html__( 'Normal', 'colorway-addons' ),
			]
		);

		$this->add_control(
			'item_background',
			[
				'label'     => esc_html__( 'Background', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ink-wc-products .ink-wc-product .ink-wc-product-inner' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'item_border',
				'label'       => esc_html__( 'Border Color', 'colorway-addons' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .ink-wc-products .ink-wc-product .ink-wc-product-inner',
				'separator'   => 'before',
			]
		);

		$this->add_responsive_control(
			'item_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'colorway-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ink-wc-products .ink-wc-product .ink-wc-product-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'item_shadow',
				'selector' => '{{WRAPPER}} .ink-wc-products .ink-wc-product .ink-wc-product-inner',
			]
		);

		$this->add_responsive_control(
			'item_padding',
			[
				'label'      => esc_html__( 'Item Padding', 'colorway-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ink-wc-products .ink-wc-product .ink-wc-product-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'desc_padding',
			[
				'label'      => esc_html__( 'Description Padding', 'colorway-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ink-wc-products .ink-wc-product-desc' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_item_hover',
			[
				'label' => esc_html__( 'Hover', 'colorway-addons' ),
			]
		);

		$this->add_control(
			'item_hover_background',
			[
				'label'     => esc_html__( 'Background', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ink-wc-products .ink-wc-product .ink-wc-product-inner:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'item_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'item_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .ink-wc-products .ink-wc-product .ink-wc-product-inner:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'item_hover_shadow',
				'selector' => '{{WRAPPER}} .ink-wc-products .ink-wc-product .ink-wc-product-inner:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_table',
			[
				'label'     => esc_html__( 'Table', 'colorway-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'_skin!' => '',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_table_style' );

		$this->start_controls_tab(
			'tab_table_normal',
			[
				'label' => esc_html__( 'Normal', 'colorway-addons' ),
			]
		);

		$this->add_control(
			'table_heading_background',
			[
				'label'     => esc_html__( 'Heading Background', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ink-wc-products table th' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'table_heading_color',
			[
				'label'     => esc_html__( 'Heading Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ink-wc-products table th' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'cell_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ink-wc-products table td'                  => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .ink-wc-products table th'                  => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .ink-wc-products table.dataTable.no-footer' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'table_odd_row_background',
			[
				'label'     => esc_html__( 'Odd Row Background', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ink-wc-products table.dataTable.stripe tbody tr.odd' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'table_even_row_background',
			[
				'label'     => esc_html__( 'Even Row Background', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ink-wc-products table.dataTable.stripe tbody tr.even' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'cell_border',
				[
				'label'     => esc_html__( 'Cell Border', 'colorway-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => [
					'_skin!' => '',
				],
			]
		);

		$this->add_control(
			'stripe',
				[
				'label'     => esc_html__( 'stripe', 'colorway-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => [
					'_skin!' => '',
				],
			]
		);

		$this->add_control(
			'hover_effect',
				[
				'label'     => esc_html__( 'Hover Effect', 'colorway-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => [
					'_skin!' => '',
				],
			]
		);		

		$this->add_responsive_control(
			'table_row_padding',
			[
				'label'      => esc_html__( 'Row Padding', 'colorway-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ink-wc-products .ink-wc-product table tr' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'table_cell_padding',
			[
				'label'      => esc_html__( 'Cell Padding', 'colorway-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ink-wc-products .ink-wc-product table td' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_table_hover',
			[
				'label' => esc_html__( 'Hover', 'colorway-addons' ),
			]
		);

		$this->add_control(
			'table_odd_row_hover_background',
			[
				'label'     => esc_html__( 'Odd Row Background', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ink-wc-products table.dataTable.stripe tbody tr.odd:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'table_even_row_hover_background',
			[
				'label'     => esc_html__( 'Even Row Background', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ink-wc-products table.dataTable.stripe tbody tr.even:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_search_field_style',
			[
				'label' => esc_html__( 'Search Field', 'colorway-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_searching' => 'yes',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_search_field_style' );

		$this->start_controls_tab(
			'tab_search_field_normal',
			[
				'label' => esc_html__( 'Normal', 'colorway-addons' ),
			]
		);

		$this->add_control(
			'search_field_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ink-wc-products input[type*="search"]' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'search_field_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ink-wc-products input[type*="search"]' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'search_field_border',
				'label'       => esc_html__( 'Border', 'colorway-addons' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .ink-wc-products input[type*="search"], {{WRAPPER}} .ink-wc-products select',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'search_field_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'colorway-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ink-wc-products input[type*="search"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'search_field_padding',
			[
				'label'      => esc_html__( 'Padding', 'colorway-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ink-wc-products input[type*="search"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; height: auto;',
				],
			]
		);

		$this->add_control(
			'search_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ink-wc-products .dataTables_filter label' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'search_spacing',
			[
				'label'     => esc_html__( 'Spacing', 'colorway-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .dataTables_filter' => 'margin-bottom: {{SIZE}}px;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'search_text_typography',
				'label'     => esc_html__( 'Text Typography', 'colorway-addons' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .ink-wc-products .dataTables_filter label',
				'separator' => 'before',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_search_field_focus',
			[
				'label' => esc_html__( 'Focus', 'colorway-addons' ),
			]
		);

		$this->add_control(
			'search_field_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'search_field_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .ink-wc-products input[type*="search"]:focus' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_select_field_style',
			[
				'label'     => esc_html__( 'Select Field', 'colorway-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_pagination' => 'yes',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_select_field_style' );

		$this->start_controls_tab(
			'tab_select_field_normal',
			[
				'label' => esc_html__( 'Normal', 'colorway-addons' ),
			]
		);

		$this->add_control(
			'select_field_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ink-wc-products select'   => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'select_field_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ink-wc-products select' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'select_field_border',
				'label'       => esc_html__( 'Border', 'colorway-addons' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .ink-wc-products select',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'select_field_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'colorway-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ink-wc-products select' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'select_field_padding',
			[
				'label'      => esc_html__( 'Padding', 'colorway-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ink-wc-products select' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'select_text_color',
			[
				'label'     => esc_html__( 'Border Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'select_field_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .ink-wc-products .dataTables_length label' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'select_text_typography',
				'label'     => esc_html__( 'Text Typography', 'colorway-addons' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .ink-wc-products .dataTables_length label',
				'separator' => 'before',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_select_field_focus',
			[
				'label' => esc_html__( 'Focus', 'colorway-addons' ),
			]
		);

		$this->add_control(
			'select_field_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'select_field_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .ink-wc-products select:focus'   => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_image',
			[
				'label' => esc_html__( 'Image', 'colorway-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'image_border',
				'label'    => esc_html__( 'Image Border', 'colorway-addons' ),
				'selector' => '{{WRAPPER}} .ink-wc-products .ink-wc-product-image',
			]
		);

		$this->add_responsive_control(
			'image_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'colorway-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .ink-wc-products .ink-wc-product-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'    => 'image_shadow',
				'exclude' => [
					'shadow_position',
				],
				'selector' => '{{WRAPPER}} .ink-wc-products .ink-wc-product-image',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_title',
			[
				'label'     => esc_html__( 'Title', 'colorway-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_title' => 'yes',
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ink-wc-products .ink-wc-product-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hover_title_color',
			[
				'label'     => esc_html__( 'Hover Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ink-wc-products .ink-wc-product-title:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_margin',
			[
				'label'      => esc_html__( 'Margin', 'colorway-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ink-wc-products .ink-wc-product-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'label'    => esc_html__( 'Typography', 'colorway-addons' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .ink-wc-products .ink-wc-product-title',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_excerpt',
			[
				'label'     => esc_html__( 'Excerpt', 'colorway-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_excerpt' => 'yes',
				],
			]
		);

		$this->add_control(
			'excerpt_color',
			[
				'label'     => esc_html__( 'Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ink-wc-products .ink-wc-product-excerpt' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'excerpt_typography',
				'label'    => esc_html__( 'Typography', 'colorway-addons' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .ink-wc-products .ink-wc-product-excerpt',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_rating',
			[
				'label'     => esc_html__( 'Rating', 'colorway-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_rating' => 'yes',
				],
			]
		);

		$this->add_control(
			'rating_color',
			[
				'label'     => esc_html__( 'Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#e7e7e7',
				'selectors' => [
					'{{WRAPPER}} .ink-wc-products .star-rating:before' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_control(
			'active_rating_color',
			[
				'label'     => esc_html__( 'Active Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFCC00',
				'selectors' => [
					'{{WRAPPER}} .ink-wc-products .star-rating span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'rating_margin',
			[
				'label'      => esc_html__( 'Margin', 'colorway-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ink-wc-products .star-rating span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_price',
			[
				'label'     => esc_html__( 'Price', 'colorway-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_price' => 'yes',
				],
			]
		);

		$this->add_control(
			'old_price_color',
			[
				'label'     => esc_html__( 'Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ink-wc-products .ink-wc-product-price del' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'old_price_margin',
			[
				'label'      => esc_html__( 'Margin', 'colorway-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ink-wc-products .ink-wc-product-price del' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'old_price_typography',
				'label'    => esc_html__( 'Typography', 'colorway-addons' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .ink-wc-products .ink-wc-product-price del',
			]
		);

		$this->add_control(
			'sale_price_heading',
			[
				'label'     => esc_html__( 'Sale Price', 'colorway-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'sale_price_color',
			[
				'label'     => esc_html__( 'Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ink-wc-products .ink-wc-product-price, {{WRAPPER}} .ink-wc-products .ink-wc-product-price ins' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'sale_price_margin',
			[
				'label'      => esc_html__( 'Margin', 'colorway-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ink-wc-products .ink-wc-product-price, {{WRAPPER}} .ink-wc-products .ink-wc-product-price ins' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'sale_price_typography',
				'label'    => esc_html__( 'Typography', 'colorway-addons' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .ink-wc-products .ink-wc-product-price, {{WRAPPER}} .ink-wc-products .ink-wc-product-price ins',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_button',
			[
				'label'     => esc_html__( 'Button', 'colorway-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_cart' => 'yes',
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
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ink-wc-products .ink-wc-add-to-cart a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'background_color',
			[
				'label'     => esc_html__( 'Background Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ink-wc-products .ink-wc-add-to-cart a' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'border',
				'label'       => esc_html__( 'Border', 'colorway-addons' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .ink-wc-products .ink-wc-add-to-cart a',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'colorway-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ink-wc-products .ink-wc-add-to-cart a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'button_padding',
			[
				'label'      => esc_html__( 'Padding', 'colorway-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ink-wc-products .ink-wc-add-to-cart a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'button_fullwidth',
			[
				'label'     => esc_html__( 'Fullwidth Button', 'colorway-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'selectors' => [
					'{{WRAPPER}} .ink-wc-products .ink-wc-add-to-cart a' => 'width: 100%;',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_shadow',
				'selector' => '{{WRAPPER}} .ink-wc-products .ink-wc-add-to-cart a',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'button_typography',
				'label'     => esc_html__( 'Typography', 'colorway-addons' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .ink-wc-products .ink-wc-add-to-cart a',
				'separator' => 'before',
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
					'{{WRAPPER}} .ink-wc-products .ink-wc-add-to-cart a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_hover_color',
			[
				'label'     => esc_html__( 'Background Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ink-wc-products .ink-wc-add-to-cart a:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .ink-wc-products .ink-wc-add-to-cart a:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_badge',
			[
				'label'     => esc_html__( 'Badge', 'colorway-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'_skin' => '',
				],
			]
		);

		$this->add_control(
			'badge_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ink-wc-products .ink-wc-product .onsale' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'badge_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ink-wc-products .ink-wc-product .onsale' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'badge_padding',
			[
				'label'      => esc_html__( 'Padding', 'colorway-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ink-wc-products .ink-wc-product .onsale' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'badge_margin',
			[
				'label'      => esc_html__( 'Margin', 'colorway-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ink-wc-products .ink-wc-product .onsale' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'badge_border',
				'label'       => esc_html__( 'Border', 'colorway-addons' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .ink-wc-products .ink-wc-product .onsale',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'badge_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'colorway-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ink-wc-products .ink-wc-product .onsale' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'badge_shadow',
				'selector' => '{{WRAPPER}} .ink-wc-products .ink-wc-product .onsale',
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_pagination',
			[
				'label'     => esc_html__( 'Pagination', 'colorway-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_pagination' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'pagination_spacing',
			[
				'label'     => esc_html__( 'Spacing', 'colorway-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} ul.ink-pagination'    => 'margin-top: {{SIZE}}px;',
					'{{WRAPPER}} .dataTables_paginate' => 'margin-top: {{SIZE}}px;',
				],
			]
		);

		$this->add_control(
			'pagination_color',
			[
				'label'     => esc_html__( 'Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ul.ink-pagination li a'    => 'color: {{VALUE}};',
					'{{WRAPPER}} ul.ink-pagination li span' => 'color: {{VALUE}};',
					'{{WRAPPER}} .paginate_button'          => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'active_pagination_color',
			[
				'label'     => esc_html__( 'Active Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ul.ink-pagination li.ink-active a' => 'color: {{VALUE}};',
					'{{WRAPPER}} .paginate_button.current'          => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'pagination_margin',
			[
				'label'     => esc_html__( 'Margin', 'colorway-addons' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} ul.ink-pagination li a'    => 'margin: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
					'{{WRAPPER}} ul.ink-pagination li span' => 'margin: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
					'{{WRAPPER}} .paginate_button'          => 'margin: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
			]
		);

		$this->add_responsive_control(
			'pagination_arrow_size',
			[
				'label'     => esc_html__( 'Arrow Size', 'colorway-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} ul.ink-pagination li a svg' => 'height: {{SIZE}}px; width: auto;',
				],
				'condition' => [
					'_skin' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'pagination_typography',
				'label'    => esc_html__( 'Typography', 'colorway-addons' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} ul.ink-pagination li a, {{WRAPPER}} ul.ink-pagination li span, {{WRAPPER}} .dataTables_paginate',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_info',
			[
				'label'     => esc_html__( 'Info', 'colorway-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_info' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'info_spacing',
			[
				'label'     => esc_html__( 'Spacing', 'colorway-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .dataTables_info' => 'margin-top: {{SIZE}}px;',
				],
			]
		);

		$this->add_control(
			'info_color',
			[
				'label'     => esc_html__( 'Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dataTables_info' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'info_typography',
				'label'    => esc_html__( 'Typography', 'colorway-addons' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .dataTables_info',
			]
		);

		$this->end_controls_section();
	}

	public function render_image() {
		$settings = $this->get_settings();
		?>
		<div class="ink-wc-product-image ink-background-cover">
			<a href="<?php the_permalink(); ?>">
				<img src="<?php echo wp_get_attachment_image_url(get_post_thumbnail_id(), $settings['image_size']); ?>">
			</a>
		</div>
		<?php
	}

	public function render_header($skin="default") {
		$settings = $this->get_settings();
		$id = 'ink-wc-products-' . $this->get_id();

		$this->add_render_attribute('wc-products', 'class', ['ink-wc-products', 'ink-wc-products-skin-' . $skin]);

		?>
		<div <?php echo $this->get_render_attribute_string( 'wc-products' ); ?>>
			
		<?php
	}

	public function render_footer() {
		$settings = $this->get_settings();
		$id       = 'ink-wc-products-' . $this->get_id();

		?>
		</div>
		<?php
	}

	public function render_query() {
		$settings = $this->get_settings();

		//global $wp_query;
		//global $woocommerce_loop;

		if ( get_query_var('paged') ) { $paged = get_query_var('paged'); } 
		elseif ( get_query_var('page') ) { $paged = get_query_var('page'); } 
		else { $paged = 1; }

		$args = array(
			'post_type'           => 'product',
			'post_status'         => 'publish',
			'ignore_sticky_posts' => 1,
			'posts_per_page'      => $settings['posts_per_page'],
			//'no_found_rows'       => true,
			'meta_key'            => $settings['meta_key'],
			'orderby'             => $settings['orderby'],
			'order'               => $settings['order'],
			'paged'               => $paged,
		);

		$wp_query = new \WP_Query($args);

		return $wp_query;
	}

	public function render_loop_item() {
		$settings = $this->get_settings();
		global $post;

		$wp_query = $this->render_query();

		if($wp_query->have_posts()) {

			$this->add_render_attribute('wc-products-wrapper', 'ink-grid', '');

			$this->add_render_attribute(
				[
					'wc-products-wrapper' => [
						'class' => [
							'ink-wc-products-wrapper',
							'ink-grid',
							'ink-grid-medium',
							'ink-child-width-1-'. $settings['columns_mobile'],
							'ink-child-width-1-'. $settings['columns_tablet'] .'@s',
							'ink-child-width-1-'. $settings['columns'] .'@m',
						],
					],
				]
			);

			?>
			<div <?php echo $this->get_render_attribute_string( 'wc-products-wrapper' ); ?>>
			<?php			

			$this->add_render_attribute('wc-product', 'class', 'ink-wc-product');

			while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
		  		<div <?php echo $this->get_render_attribute_string( 'wc-product' ); ?>>
		  			<div class="ink-wc-product-inner">
		  				<?php if ('yes' == $settings['show_badge']) : ?>
				  			<div class="ink-wc-products-badge">
					  			<?php woocommerce_show_product_loop_sale_flash(); ?>
				  			</div>
			  			<?php endif; ?>

		               <?php $this->render_image(); ?>

	           			<div class="ink-wc-product-desc">
		               		<?php if ( 'yes' == $settings['show_title']) : ?>
			           			<h2 class="ink-wc-product-title">
			           				<a href="<?php the_permalink(); ?>" class="ink-link-reset">
						               <?php the_title(); ?>
						           </a>
				               </h2>
				            <?php endif; ?>

		           			<?php if (('yes' == $settings['show_price']) or ('yes' == $settings['show_rating'])) : ?>
			               		<?php if ( 'yes' == $settings['show_price']) : ?>
				           			<span class="ink-wc-product-price">
										<?php woocommerce_template_single_price(); ?>
									</span>
					            <?php endif; ?>
						               
				               <?php if ('yes' == $settings['show_rating']) : ?>
					               	<div class="ink-wc-rating">
					           			<?php woocommerce_template_loop_rating(); ?>
				           			</div>
			                	<?php endif; ?>
		                	<?php endif; ?>
						</div>

	                	<?php if ('yes' == $settings['show_cart']) : ?>
		                	<div class="ink-wc-add-to-cart">
								<?php woocommerce_template_loop_add_to_cart();?>
							</div>
						<?php endif; ?>

					</div>
				</div>
			<?php endwhile;	?>
			</div>
			<?php

			if ($settings['show_pagination']) {
				colorway_addons_post_pagination($wp_query);
			}

			wp_reset_postdata();
			
		} else {
			echo '<div class="ink-alert-warning" ink-alert>Sorry!! There is no product<div>';
		}
	}

	public function render() {
		$this->render_header();
		$this->render_loop_item();
		$this->render_footer();
	}
		
}
