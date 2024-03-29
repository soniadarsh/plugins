<?php
namespace CwAddons\Modules\Woocommerce\Widgets;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use CwAddons\Modules\QueryControl\Module as QueryModule;
use CwAddons\Modules\Woocommerce\Module;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Elements extends Widget_Base {

	public function get_name() {
		return 'ink-wc-elements';
	}

	public function get_title() {
		return esc_html__( 'WC - Elements', 'colorway-addons' );
	}

	public function get_icon() {
		return 'ink-widget-icon fab fa-weebly';
	}

	public function get_categories() {
		return [ 'colorway-addons' ];
	}

	public function on_export( $element ) {
		unset( $element['settings']['product_id'] );

		return $element;
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_product',
			[
				'label' => esc_html__( 'Element', 'colorway-addons' ),
			]
		);

		$this->add_control(
			'element',
			[
				'label' => esc_html__( 'Element', 'colorway-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					''                           => '— ' . esc_html__( 'Select', 'colorway-addons' ) . ' —',
					'woocommerce_cart'           => esc_html__( 'Cart Page', 'colorway-addons' ),
					'product_page'               => esc_html__( 'Single Product Page', 'colorway-addons' ),
					'woocommerce_checkout'       => esc_html__( 'Checkout Page', 'colorway-addons' ),
					'woocommerce_order_tracking' => esc_html__( 'Order Tracking Form', 'colorway-addons' ),
					'woocommerce_my_account'     => esc_html__( 'My Account', 'colorway-addons' ),
				],
			]
		);

		// $this->add_control(
		// 	'product_id',
		// 	[
		// 		'label'       => esc_html__( 'Product', 'colorway-addons' ),
		// 		'type'        => QueryModule::QUERY_CONTROL_ID,
		// 		'post_type'   => '',
		// 		'options'     => [],
		// 		'label_block' => true,
		// 		'filter_type' => 'by_id',
		// 		'object_type' => [ 'product' ],
		// 		'condition'   => [
		// 			'element' => [ 'product_page' ],
		// 		],
		// 	]
		// );
		 
		$this->add_control(
			'product_id',
			[
				'label'       => esc_html__( 'Product', 'colorway-addons' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'filter_type' => 'by_id',
				'object_type' => [ 'product' ],
				'condition'   => [
					'element' => [ 'product_page' ],
				],
			]
		);



		$this->end_controls_section();




		$this->start_controls_section(
			'section_checkout_style_label',
			[
				'label' => esc_html__( 'Label', 'colorway-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition'   => [
					'element' => [ 'woocommerce_checkout' ],
				],
			]
		);

		$this->add_control(
			'label_color',
			[
				'label'     => esc_html__( 'Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce form .form-row label' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'required_color',
			[
				'label'     => esc_html__( 'Required Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce form .form-row .required' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'label_typography',
				'label' => esc_html__( 'Typography', 'colorway-addons' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .woocommerce form .form-row label',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_checkout_style_input',
			[
				'label' => esc_html__( 'Input', 'colorway-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition'   => [
					'element' => [ 'woocommerce_checkout' ],
				],
			]
		);

		$this->add_control(
			'input_placeholder_color',
			[
				'label'     => esc_html__( 'Placeholder Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce .input-text::placeholder' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'input_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce .input-text' => 'color: {{VALUE}};',
					'{{WRAPPER}} .woocommerce select' => 'color: {{VALUE}};',
					'{{WRAPPER}} .woocommerce textarea.input-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'input_text_background',
			[
				'label'     => esc_html__( 'Background Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce .input-text' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .woocommerce select' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .woocommerce textarea.input-text' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'textarea_height',
			[
				'label' => esc_html__( 'Textarea Height', 'colorway-addons' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 125,
				],
				'range' => [
					'px' => [
						'min' => 30,
						'max' => 500,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .woocommerce textarea.input-text' => 'height: {{SIZE}}{{UNIT}}; display: block;',
				],
				'separator' => 'before',

			]
		);

		$this->add_control(
			'input_padding',
			[
				'label' => esc_html__( 'Padding', 'colorway-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .woocommerce .input-text, 
					 {{WRAPPER}} .woocommerce textarea.input-text, 
					 {{WRAPPER}} .select2-container--default .select2-selection--single,
					 {{WRAPPER}} .woocommerce select' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				    '{{WRAPPER}} .select2-container--default .select2-selection--single' => 'height: auto; min-height: 37px;',
					'{{WRAPPER}} .select2-container--default .select2-selection--single .select2-selection__rendered' => 'line-height: initial;',
				],
			]
		);

		$this->add_responsive_control(
			'input_space',
			[
				'label' => esc_html__( 'Element Space', 'colorway-addons' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 25,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .woocommerce form .form-row' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'input_border_show',
			[
				'label' => esc_html__( 'Border Style', 'colorway-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'label_on' => 'Hide',
				'label_off' => 'Show',
				'return_value' => 'yes',
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(), [
				'name'        => 'input_border',
				'label'       => esc_html__( 'Border', 'colorway-addons' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '
					{{WRAPPER}} .woocommerce .input-text, 
					{{WRAPPER}} .woocommerce select, 
					{{WRAPPER}} .select2-container--default .select2-selection--single',
				'condition' => [
					'input_border_show' => 'yes',
				],
			]
		);

		$this->add_control(
			'input_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'colorway-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .woocommerce .input-text, 
					 {{WRAPPER}} .select2-container--default .select2-selection--single, 
					 {{WRAPPER}} .woocommerce select' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'section_checkout_style_order_table',
			[
				'label' => esc_html__( 'Order Table', 'colorway-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition'   => [
					'element' => [ 'woocommerce_checkout' ],
				],
			]
		);

		$this->add_control(
			'order_table_padding',
			[
				'label' => esc_html__( 'Padding', 'colorway-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .woocommerce table.shop_table th, 
					{{WRAPPER}} .woocommerce table.shop_table td' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'order_table_border_show',
			[
				'label' => esc_html__( 'Border Style', 'colorway-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'label_on' => 'Hide',
				'label_off' => 'Show',
				'return_value' => 'yes',
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(), [
				'name'        => 'order_table_border',
				'label'       => esc_html__( 'Border', 'colorway-addons' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .woocommerce table.shop_table',
									
				'condition' => [
					'order_table_border_show' => 'yes',
				],
			]
		);

		$this->add_control(
			'order_table_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'colorway-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .woocommerce table.shop_table' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->end_controls_section();



		// Payment section
		$this->start_controls_section(
			'section_style_checkout_payment',
			[
				'label' => esc_html__( 'Payment', 'colorway-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition'   => [
					'element' => [ 'woocommerce_checkout' ],
				],
			]
		);

		$this->add_control(
			'checkout_payment_color',
			[
				'label'     => esc_html__( 'Text Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-checkout #payment, {{WRAPPER}} .woocommerce-checkout #payment div.payment_box' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'checkout_payment_background',
			[
				'label'     => esc_html__( 'Background Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-checkout #payment' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .woocommerce-checkout #payment div.payment_box' => 'opacity:0.5;',
					'{{WRAPPER}} .woocommerce-checkout #payment div.payment_box::before' => 'opacity:0.5;',
				],
			]
		);

		$this->add_control(
			'checkout_payment_button_heading',
			[
				'label' => esc_html__( 'Button Style', 'colorway-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->start_controls_tabs( 'tabs_payment_button_style' );

		$this->start_controls_tab(
			'tab_payment_button_normal',
			[
				'label' => esc_html__( 'Normal', 'colorway-addons' ),
			]
		);

		$this->add_control(
			'payment_button_text_color',
			[
				'label' => esc_html__( 'Text Color', 'colorway-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .woocommerce input.button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'payment_button_background_color',
			[
				'label' => esc_html__( 'Background Color', 'colorway-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce input.button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'payment_button_border',
				'label' => esc_html__( 'Border', 'colorway-addons' ),
				'placeholder' => '1px',
				'default' => '1px',
				'selector' => '{{WRAPPER}} .woocommerce input.button',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'payment_button_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'colorway-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .woocommerce input.button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'payment_button_box_shadow',
				'selector' => '{{WRAPPER}} .wpcf7-submit',
			]
		);

		$this->add_control(
			'payment_button_text_padding',
			[
				'label' => esc_html__( 'Padding', 'colorway-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .woocommerce input.button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'payment_button_typography',
				'label' => esc_html__( 'Typography', 'colorway-addons' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .woocommerce input.button',
				'separator' => 'before',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_payment_button_hover',
			[
				'label' => esc_html__( 'Hover', 'colorway-addons' ),
			]
		);

		$this->add_control(
			'payment_button_hover_color',
			[
				'label' => esc_html__( 'Text Color', 'colorway-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce input.button:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'payment_button_background_hover_color',
			[
				'label' => esc_html__( 'Background Color', 'colorway-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce input.button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'payment_button_hover_border_color',
			[
				'label' => esc_html__( 'Border Color', 'colorway-addons' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .woocommerce input.button:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();



		// TRacking section 
		$this->start_controls_section(
			'section_tracking_style_label',
			[
				'label' => esc_html__( 'Label', 'colorway-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition'   => [
					'element' => [ 'woocommerce_order_tracking' ],
				],
			]
		);

		$this->add_control(
			'tracking_label_color',
			[
				'label'     => esc_html__( 'Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce form .form-row label' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'tracking_label_typography',
				'label' => esc_html__( 'Typography', 'colorway-addons' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .woocommerce form .form-row label',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_tracking_style_input',
			[
				'label' => esc_html__( 'Input', 'colorway-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition'   => [
					'element' => [ 'woocommerce_order_tracking' ],
				],
			]
		);

		$this->add_control(
			'tracking_input_placeholder_color',
			[
				'label'     => esc_html__( 'Placeholder Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce .input-text::placeholder' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'tracking_input_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce .input-text' => 'color: {{VALUE}};',
					'{{WRAPPER}} .woocommerce select' => 'color: {{VALUE}};',
					'{{WRAPPER}} .woocommerce textarea.input-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'tracking_input_text_background',
			[
				'label'     => esc_html__( 'Background Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce .input-text' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .woocommerce select' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .woocommerce textarea.input-text' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'tracking_input_padding',
			[
				'label' => esc_html__( 'Padding', 'colorway-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .woocommerce .input-text, 
					 {{WRAPPER}} .woocommerce textarea.input-text, 
					 {{WRAPPER}} .select2-container--default .select2-selection--single,
					 {{WRAPPER}} .woocommerce select' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				    '{{WRAPPER}} .select2-container--default .select2-selection--single' => 'height: auto; min-height: 37px;',
					'{{WRAPPER}} .select2-container--default .select2-selection--single .select2-selection__rendered' => 'line-height: initial;',
				],
			]
		);

		$this->add_responsive_control(
			'tracking_input_space',
			[
				'label' => esc_html__( 'Element Space', 'colorway-addons' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 25,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .woocommerce form .form-row' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'tracking_input_border_show',
			[
				'label' => esc_html__( 'Border Style', 'colorway-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'label_on' => 'Hide',
				'label_off' => 'Show',
				'return_value' => 'yes',
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(), [
				'name'        => 'tracking_input_border',
				'label'       => esc_html__( 'Border', 'colorway-addons' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '
					{{WRAPPER}} .woocommerce .input-text, 
					{{WRAPPER}} .woocommerce select, 
					{{WRAPPER}} .select2-container--default .select2-selection--single',
				'condition' => [
					'tracking_input_border_show' => 'yes',
				],
			]
		);

		$this->add_control(
			'tracking_input_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'colorway-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .woocommerce .input-text, 
					 {{WRAPPER}} .select2-container--default .select2-selection--single, 
					 {{WRAPPER}} .woocommerce select' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'section_style_tracking',
			[
				'label' => esc_html__( 'Button', 'colorway-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition'   => [
					'element' => [ 'woocommerce_order_tracking' ],
				],
			]
		);

		$this->add_control(
			'tracking_button_heading',
			[
				'label' => esc_html__( 'Button Style', 'colorway-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->start_controls_tabs( 'tabs_tracking_button_style' );

		$this->start_controls_tab(
			'tab_tracking_button_normal',
			[
				'label' => esc_html__( 'Normal', 'colorway-addons' ),
			]
		);

		$this->add_control(
			'tracking_button_text_color',
			[
				'label' => esc_html__( 'Text Color', 'colorway-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .woocommerce input.button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'tracking_button_background_color',
			[
				'label' => esc_html__( 'Background Color', 'colorway-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce input.button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'tracking_button_border',
				'label' => esc_html__( 'Border', 'colorway-addons' ),
				'placeholder' => '1px',
				'default' => '1px',
				'selector' => '{{WRAPPER}} .woocommerce input.button',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'tracking_button_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'colorway-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .woocommerce input.button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'tracking_button_box_shadow',
				'selector' => '{{WRAPPER}} .wpcf7-submit',
			]
		);

		$this->add_control(
			'tracking_button_text_padding',
			[
				'label' => esc_html__( 'Padding', 'colorway-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .woocommerce input.button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'tracking_button_typography',
				'label' => esc_html__( 'Typography', 'colorway-addons' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .woocommerce input.button',
				'separator' => 'before',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_tracking_button_hover',
			[
				'label' => esc_html__( 'Hover', 'colorway-addons' ),
			]
		);

		$this->add_control(
			'tracking_button_hover_color',
			[
				'label' => esc_html__( 'Text Color', 'colorway-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce input.button:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'tracking_button_background_hover_color',
			[
				'label' => esc_html__( 'Background Color', 'colorway-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce input.button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'tracking_button_hover_border_color',
			[
				'label' => esc_html__( 'Border Color', 'colorway-addons' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .woocommerce input.button:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();




		// Cart style
		
		$this->start_controls_section(
			'section_cart_style_heading',
			[
				'label' => esc_html__( 'Table Heading', 'colorway-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition'   => [
					'element' => [ 'woocommerce_cart' ],
				],
			]
		);

		$this->add_control(
			'cart_table_heading_color',
			[
				'label'     => esc_html__( 'Text Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce table.shop_table th' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'cart_table_heading_background',
			[
				'label'     => esc_html__( 'Background Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce table.shop_table th' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'section_cart_style_table',
			[
				'label' => esc_html__( 'Table Content', 'colorway-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition'   => [
					'element' => [ 'woocommerce_cart' ],
				],
			]
		);

		$this->add_control(
			'cart_table_color',
			[
				'label'     => esc_html__( 'Text Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce table.shop_table td *' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'cart_table_background',
			[
				'label'     => esc_html__( 'Background Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce table.shop_table' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'cart_table_padding',
			[
				'label' => esc_html__( 'Padding', 'colorway-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .woocommerce table.shop_table td' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'cart_table_border_show',
			[
				'label' => esc_html__( 'Border Style', 'colorway-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'label_on' => 'Hide',
				'label_off' => 'Show',
				'return_value' => 'yes',
				'separator' => 'before',
			]
		);



		$this->add_control(
			'cart_table_border_width',
			[
				'label' => esc_html__( 'Border Width', 'colorway-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .woocommerce table.shop_table' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .woocommerce table.shop_table td' => 'border-top-width: {{TOP}}{{UNIT}};',
				],
				'condition'   => [
					'cart_table_border_show' => [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'cart_table_border_color',
			[
				'label' => esc_html__( 'Border Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce table.shop_table' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .woocommerce table.shop_table td' => 'border-top-color: {{VALUE}};',
				],
				'condition'   => [
					'cart_table_border_show' => [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'cart_table_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'colorway-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .woocommerce .input-text, 
					 {{WRAPPER}} .select2-container--default .select2-selection--single, 
					 {{WRAPPER}} .woocommerce select' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_cart_style_input',
			[
				'label' => esc_html__( 'Input', 'colorway-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition'   => [
					'element' => [ 'woocommerce_cart' ],
				],
			]
		);

		$this->add_control(
			'cart_input_placeholder_color',
			[
				'label'     => esc_html__( 'Placeholder Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} table.cart .input-text::placeholder' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'cart_input_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} table.cart .input-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'cart_input_text_background',
			[
				'label'     => esc_html__( 'Background Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} table.cart .input-text' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'cart_input_padding',
			[
				'label' => esc_html__( 'Padding', 'colorway-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} table.cart .input-text, {{WRAPPER}} table.cart td.actions .coupon .input-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; box-sizing: content-box;',
				],
			]
		);


		$this->add_control(
			'cart_input_border_show',
			[
				'label' => esc_html__( 'Border Style', 'colorway-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'label_on' => 'Hide',
				'label_off' => 'Show',
				'return_value' => 'yes',
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(), [
				'name'        => 'cart_input_border',
				'label'       => esc_html__( 'Border', 'colorway-addons' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '
					{{WRAPPER}} table.cart .input-text,
					{{WRAPPER}} table.cart td.actions .coupon .input-text',
				'condition' => [
					'cart_input_border_show' => 'yes',
				],
			]
		);

		$this->add_control(
			'cart_input_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'colorway-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} table.cart .input-text, 
					 {{WRAPPER}} .select2-container--default .select2-selection--single, 
					 {{WRAPPER}} .woocommerce select' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// Cart table button
		$this->start_controls_section(
			'section_style_cart_button',
			[
				'label' => esc_html__( 'Coupon/Update Button', 'colorway-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition'   => [
					'element' => [ 'woocommerce_cart' ],
				],
			]
		);

		$this->add_control(
			'cart_button_heading',
			[
				'label' => esc_html__( 'Button Style', 'colorway-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->start_controls_tabs( 'tabs_cart_button_style' );

		$this->start_controls_tab(
			'tab_cart_button_normal',
			[
				'label' => esc_html__( 'Normal', 'colorway-addons' ),
			]
		);

		$this->add_control(
			'cart_button_text_color',
			[
				'label' => esc_html__( 'Text Color', 'colorway-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .woocommerce input.button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'cart_button_background_color',
			[
				'label' => esc_html__( 'Background Color', 'colorway-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce input.button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'cart_button_border',
				'label' => esc_html__( 'Border', 'colorway-addons' ),
				'placeholder' => '1px',
				'default' => '1px',
				'selector' => '{{WRAPPER}} .woocommerce input.button',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'cart_button_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'colorway-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .woocommerce input.button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'cart_button_box_shadow',
				'selector' => '{{WRAPPER}} .wpcf7-submit',
			]
		);

		$this->add_control(
			'cart_button_text_padding',
			[
				'label' => esc_html__( 'Padding', 'colorway-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .woocommerce input.button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'cart_button_typography',
				'label' => esc_html__( 'Typography', 'colorway-addons' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .woocommerce input.button',
				'separator' => 'before',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_cart_button_hover',
			[
				'label' => esc_html__( 'Hover', 'colorway-addons' ),
			]
		);

		$this->add_control(
			'cart_button_hover_color',
			[
				'label' => esc_html__( 'Text Color', 'colorway-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce input.button:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'cart_button_background_hover_color',
			[
				'label' => esc_html__( 'Background Color', 'colorway-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce input.button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'cart_button_hover_border_color',
			[
				'label' => esc_html__( 'Border Color', 'colorway-addons' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .woocommerce input.button:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();


		// Cart table button
		$this->start_controls_section(
			'section_style_cart_checkout_button',
			[
				'label' => esc_html__( 'Checkout Button', 'colorway-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition'   => [
					'element' => [ 'woocommerce_cart' ],
				],
			]
		);

		$this->add_control(
			'cart_checkout_button_heading',
			[
				'label' => esc_html__( 'Button Style', 'colorway-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->start_controls_tabs( 'tabs_cart_checkout_button_style' );

		$this->start_controls_tab(
			'tab_cart_checkout_button_normal',
			[
				'label' => esc_html__( 'Normal', 'colorway-addons' ),
			]
		);

		$this->add_control(
			'cart_checkout_button_text_color',
			[
				'label' => esc_html__( 'Text Color', 'colorway-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .wc-proceed-to-checkout a.checkout-button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'cart_checkout_button_background_color',
			[
				'label' => esc_html__( 'Background Color', 'colorway-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wc-proceed-to-checkout a.checkout-button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'cart_checkout_button_border',
				'label' => esc_html__( 'Border', 'colorway-addons' ),
				'placeholder' => '1px',
				'default' => '1px',
				'selector' => '{{WRAPPER}} .wc-proceed-to-checkout a.checkout-button',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'cart_checkout_button_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'colorway-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .wc-proceed-to-checkout a.checkout-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'cart_checkout_button_box_shadow',
				'selector' => '{{WRAPPER}} .wpcf7-submit',
			]
		);

		$this->add_control(
			'cart_checkout_button_text_padding',
			[
				'label' => esc_html__( 'Padding', 'colorway-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .wc-proceed-to-checkout a.checkout-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'cart_checkout_button_typography',
				'label' => esc_html__( 'Typography', 'colorway-addons' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .wc-proceed-to-checkout a.checkout-button',
				'separator' => 'before',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_cart_checkout_button_hover',
			[
				'label' => esc_html__( 'Hover', 'colorway-addons' ),
			]
		);

		$this->add_control(
			'cart_checkout_button_hover_color',
			[
				'label' => esc_html__( 'Text Color', 'colorway-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wc-proceed-to-checkout a.checkout-button:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'cart_checkout_button_background_hover_color',
			[
				'label' => esc_html__( 'Background Color', 'colorway-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wc-proceed-to-checkout a.checkout-button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'cart_checkout_button_hover_border_color',
			[
				'label' => esc_html__( 'Border Color', 'colorway-addons' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .wc-proceed-to-checkout a.checkout-button:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	private function get_shortcode() {
		$settings = $this->get_settings();

		switch ( $settings['element'] ) {
			case '':
				return '';
				break;

			case 'product_page':

				if ( ! empty( $settings['product_id'] ) ) {
					$product_data = get_post( $settings['product_id'] );
					$product = ! empty( $product_data ) && in_array( $product_data->post_type, array( 'product', 'product_variation' ) ) ? wc_setup_product_data( $product_data ) : false;
				}

				if ( empty( $product ) && current_user_can( 'manage_options' ) ) {
					return esc_html__( 'Please set a valid product', 'colorway-addons' );
				}

				$this->add_render_attribute( 'shortcode', 'id', $settings['product_id'] );
				break;

			case 'woocommerce_cart':
			case 'woocommerce_checkout':
			case 'woocommerce_order_tracking':
				break;
		}

		$shortcode = sprintf( '[%s %s]', $settings['element'], $this->get_render_attribute_string( 'shortcode' ) );

		return $shortcode;
	}

	protected function render() {
		$shortcode = $this->get_shortcode();

		if ( empty( $shortcode ) ) {
			return;
		}

		Module::instance()->add_products_post_class_filter();

		$html = do_shortcode( $shortcode );

		if ( 'woocommerce_checkout' === $this->get_settings( 'element' ) && '<div class="woocommerce"></div>' === $html ) {
			$html = '<div class="woocommerce">' . esc_html__( 'Your cart is currently empty.', 'colorway-addons' ) . '</div>';
		}

		echo  $html;

		Module::instance()->remove_products_post_class_filter();
	}

	public function render_plain_content() {
		echo $this->get_shortcode();
	}
}
