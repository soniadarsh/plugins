<?php
namespace CwAddons\Modules\ImageCompare\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Image_Compare extends Widget_Base {

	protected $_has_template_content = false;

	public function get_name() {
		return 'ink-image-compare';
	}

	public function get_title() {
		return esc_html__( 'Image Compare', 'colorway-addons' );
	}

	public function get_icon() {
		return 'ink-widget-icon fas fa-balance-scale';
	}

	public function get_categories() {
		return [ 'colorway-addons' ];
	}

	public function get_style_depends() {
		return [ 'twentytwenty' ];
	}

	public function get_script_depends() {
		return [ 'eventmove', 'twentytwenty' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_content_layout',
			[
				'label' => esc_html__( 'Layout', 'colorway-addons' ),
			]
		);


		$this->add_control(
			'before_image',
			[
				'label' => esc_html__( 'Before Image (Same Size of Both Image)', 'colorway-addons' ),
				'type'  => Controls_Manager::MEDIA,
				'default' => [
					'url' => INKCA_ASSETS_URL.'images/before.jpg',
				],
				'dynamic'     => [ 'active' => true ],
			]
		);

		$this->add_control(
			'after_image',
			[
				'label' => esc_html__( 'After Image (Same Size of Both Image)', 'colorway-addons' ),
				'type'  => Controls_Manager::MEDIA,
				'default' => [
					'url' => INKCA_ASSETS_URL.'images/after.jpg',
				],
				'dynamic'     => [ 'active' => true ],
			]
		);

		$this->add_control(
			'before_label',
			[
				'label'       => esc_html__( 'Before Label', 'colorway-addons' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Before Label', 'colorway-addons' ),
				'default'     => esc_html__( 'Before', 'colorway-addons' ),
				'label_block' => true,
				'dynamic'     => [ 'active' => true ],
			]
		);

		$this->add_control(
			'after_label',
			[
				'label'       => esc_html__( 'After Label', 'colorway-addons' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'After Label', 'colorway-addons' ),
				'default'     => esc_html__( 'After', 'colorway-addons' ),
				'label_block' => true,
				'dynamic'     => [ 'active' => true ],
			]
		);

		$this->add_control(
			'orientation',
			[
				'label'   => esc_html__( 'Orientation', 'colorway-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'horizontal',
				'options' => [
					'horizontal' => esc_html__( 'Horizontal', 'colorway-addons' ),
					'vertical'   => esc_html__( 'Vertical', 'colorway-addons' ),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_style',
			[
				'label' => esc_html__( 'Style', 'colorway-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'before_background',
			[
				'label' => esc_html__( 'Before Background', 'colorway-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ink-image-compare .twentytwenty-before-label:before' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'before_color',
			[
				'label' => esc_html__( 'Before Color', 'colorway-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ink-image-compare .twentytwenty-before-label:before' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'after_background',
			[
				'label' => esc_html__( 'After Background', 'colorway-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ink-image-compare .twentytwenty-after-label:before' => 'background-color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'after_color',
			[
				'label' => esc_html__( 'After Color', 'colorway-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ink-image-compare .twentytwenty-after-label:before' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'bar_color',
			[
				'label' => esc_html__( 'Bar Color', 'colorway-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ink-image-compare .twentytwenty-handle' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .ink-image-compare .twentytwenty-handle:before' => 'background-color: {{VALUE}}; -webkit-box-shadow: 0 3px 0 {{VALUE}}, 0px 0px 12px rgba(51, 51, 51, 0.5); box-shadow: 0 3px 0 {{VALUE}}, 0px 0px 12px rgba(51, 51, 51, 0.5);',
					'{{WRAPPER}} .ink-image-compare .twentytwenty-handle:after' => 'background-color: {{VALUE}}; -webkit-box-shadow: 0 3px 0 {{VALUE}}, 0px 0px 12px rgba(51, 51, 51, 0.5); box-shadow: 0 3px 0 {{VALUE}}, 0px 0px 12px rgba(51, 51, 51, 0.5);',
					'{{WRAPPER}} .ink-image-compare .twentytwenty-handle span.twentytwenty-left-arrow' => 'border-right-color: {{VALUE}};',
					'{{WRAPPER}} .ink-image-compare .twentytwenty-handle span.twentytwenty-right-arrow' => 'border-left-color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

	}

	public function render() {
		$settings     = $this->get_settings();
		?>

		<div class="ink-image-compare ink-position-relative">
			<div class="twentytwenty-container">
				<?php echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'before_image' ); ?>
				<?php echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'after_image' ); ?>
			</div>
		</div>

		<script>
			jQuery(document).ready(function($) {
				"use strict";
				$(".elementor-element-<?php echo esc_attr($this->get_id()); ?> .twentytwenty-container").twentytwenty({
					default_offset_pct: 0.7, 
					orientation: '<?php echo esc_attr($settings['orientation']); ?>',
					before_label: '<?php echo esc_html($settings['before_label']); ?>',
					after_label: '<?php echo esc_html($settings['after_label']); ?>',
				});
			});
		</script>

		<?php
	}
}
