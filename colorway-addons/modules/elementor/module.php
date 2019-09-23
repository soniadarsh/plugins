<?php
namespace CwAddons\Modules\Elementor;

use Elementor;
use Elementor\Elementor_Base;
use Elementor\Controls_Manager;
use Elementor\Element_Base;
use Elementor\Widget_Base;
use CwAddons\Base\Colorway_Addons_Module_Base;
use CwAddons\Plugin;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Colorway_Addons_Module_Base {

	public function __construct() {
		parent::__construct();
		$this->add_actions();
	}


	public function get_name() {
		return 'ink-elementor';
	}

	public function get_script_depends() {
		return [ 'particles' ];
	}

	public function register_controls_bg_parallax($section, $section_id, $args) {

		static $bg_sections = [ 'section_background' ];

		if ( !in_array( $section_id, $bg_sections ) ) { return; }
		
		$section->add_control(
			'section_parallax_on1',
			[
				'label'        => esc_html__( 'Enable Parallax', 'colorway-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '',
				'return_value' => 'yes',
				'description'  => esc_html__( 'Set parallax background by enable this option.', 'colorway-addons' ),
				'separator'    => 'before',
				'condition'    => [
					'background_background' => ['classic'],
				],
			]
		);

		$section->add_control(
			'section_parallax_value1',
			[
				'label'        => esc_html__( 'Parallax Amount', 'colorway-addons' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => -500,
						'max' => 500,
						'step' => 10,
					],
				],
				'default' => [
					'size' => -200,
				],
				'description'  => esc_html__( 'How much parallax move happen on scroll.', 'colorway-addons' ),
				'condition'    => [
					'section_parallax_on1' => 'yes',
				],
			]
		);

	}

	public function register_controls_sticky($section, $section_id, $args) {

		static $layout_sections = [ 'section_layout'];

		if ( ! in_array( $section_id, $layout_sections ) ) { return; }
		

		$section->start_controls_section(
			'section_sticky_controls',
			[
				'label' => __( 'Sticky Options', 'colorway-addons' ),
				'tab' => Controls_Manager::TAB_LAYOUT,
			]
		);


		$section->add_control(
			'section_sticky_on',
			[
				'label'        => esc_html__( 'Enable Sticky', 'colorway-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'description'  => esc_html__( 'Set sticky options by enable this option.', 'colorway-addons' ),
			]
		);

		$section->add_control(
			'section_sticky_offset',
			[
				'label'   => esc_html__( 'Offset', 'colorway-addons' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
					],
				],
				'condition' => [
					'section_sticky_on' => 'yes',
				],
			]
		);

		$section->add_control(
			'section_sticky_active_bg',
			[
				'label'     => esc_html__( 'Active Background Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.ink-sticky.ink-active' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'section_sticky_on' => 'yes',
				],
			]
		);

		$section->add_control(
			'item_border_radius',
			[
				'label'      => esc_html__( 'Active Padding', 'colorway-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}}.ink-sticky.ink-active' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'section_sticky_on' => 'yes',
				],
			]
		);

		$section->add_control(
			'section_sticky_animation',
			[
				'label'     => esc_html__( 'Animation', 'colorway-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => colorway_addons_transition_options(),
				'condition' => [
					'section_sticky_on' => 'yes',
				],
			]
		);

		$section->add_control(
			'section_sticky_bottom',
			[
				'label' => esc_html__( 'Scroll on', 'colorway-addons' ),
				'description'  => esc_html__( 'If you don\'t want to scroll after specific section so set that section ID/CLASS here. for example: #section1 or .section1 it\'s support ID/CLASS', 'colorway-addons' ),
				'type' => Controls_Manager::TEXT,
				'condition' => [
					'section_sticky_on' => 'yes',
				],
			]
		);

		$section->add_control(
			'section_sticky_on_scroll_up',
			[
				'label'        => esc_html__( 'Sticky on Scroll Up', 'colorway-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'description'  => esc_html__( 'Set sticky options when you scroll up your mouse.', 'colorway-addons' ),
				'condition' => [
					'section_sticky_on' => 'yes',
				],
			]
		);


		$section->add_control(
			'section_sticky_off_media',
			[
				'label'       => __( 'Turn Off', 'colorway-addons' ),
				'type'        => Controls_Manager::CHOOSE,
				'options' => [
					'960' => [
						'title' => __( 'On Tablet', 'colorway-addons' ),
						'icon'  => 'fa fa-tablet',
					],
					'768' => [
						'title' => __( 'On Mobile', 'colorway-addons' ),
						'icon'  => 'fa fa-mobile',
					],
				],
				'condition' => [
					'section_sticky_on' => 'yes',
				],
				'separator' => 'before',
			]
		);

		$section->end_controls_section();

	}

	public function register_controls_particles($section, $section_id, $args) {

		static $bg_sections = [ 'section_background' ];

		if ( !in_array( $section_id, $bg_sections ) ) { return; }

		$section->add_control(
			'section_particles_on1',
			[
				'label'        => esc_html__( 'Enable Particles', 'colorway-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '',
				'return_value' => 'yes',
				'description'  => __( 'Switch on to enable Particles options! Note that currently particles are not visible in edit/preview mode for better elementor performance. It\'s only can viewed on the frontend. <b>Z-Index Problem: set column z-index 1 so particles will set behind the content.</b>', 'colorway-addons' ),
			]
		);
		
		$section->add_control(
			'section_particles_js1',
			[
				'label' => esc_html__( 'Particles JSON', 'colorway-addons' ),
				'type' => Controls_Manager::TEXTAREA,
				'condition' => [
					'section_particles_on' => 'yes',
				],
				'description' => __( 'Paste your particles JSON code here - Generate it from <a href="http://vincentgarreau.com/particles.js/#default" target="_blank">Here</a>.', 'colorway-addons' ),
				'default' => '',
			]
		);

	}


	public function register_controls_scheduled($section, $section_id, $args) {

		static $layout_sections = [ 'section_layout'];

		if ( ! in_array( $section_id, $layout_sections ) ) { return; }

		// Schedule content controls
		$section->start_controls_section(
			'section_scheduled_content_controls1',
			[
				'label' => __( 'Schedule Content', 'colorway-addons' ),
				'tab' => Controls_Manager::TAB_LAYOUT,
			]
		);
		
		$section->add_control(
			'section_scheduled_content_on1',
			[
				'label'        => __( 'Schedule Content?', 'colorway-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '',
				'return_value' => 'yes',
				'description'  => __( 'Switch on to schedule the contents of this column|section!.', 'colorway-addons' ),
			]
		);
		
		$section->add_control(
			'section_scheduled_content_start_date1',
			[
				'label' => __( 'Start Date', 'colorway-addons' ),
				'type' => Controls_Manager::DATE_TIME,
				'default' => '2018-02-01 00:00:00',
				'condition' => [
					'section_scheduled_content_on' => 'yes',
				],
				'description' => __( 'Set start date for show this section.', 'colorway-addons' ),
			]
		);
		
		$section->add_control(
			'section_scheduled_content_end_date1',
			[
				'label' => __( 'End Date', 'colorway-addons' ),
				'type' => Controls_Manager::DATE_TIME,
				'default' => '2018-02-28 00:00:00',
				'condition' => [
					'section_scheduled_content_on' => 'yes',
				],
				'description' => __( 'Set end date for hide the section.', 'colorway-addons' ),
			]
		);

		$section->end_controls_section();

	}

	public function register_controls_parallax($section, $section_id, $args) {

		static $style_sections = [ 'section_background'];

		if ( ! in_array( $section_id, $style_sections ) ) { return; }

		// Schedule content controls
		$section->start_controls_section(
			'section_parallax_content_controls1',
			[
				'label' => __( 'Parallax', 'colorway-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		
		$section->add_control(
			'section_parallax_elements1',
			[
				'label'   => __( 'Parallax Items', 'colorway-addons' ),
				'type'    => Controls_Manager::REPEATER,
				'fields' => [
					[
						'name'        => 'section_parallax_title',
						'label'       => __( 'Title', 'colorway-addons' ),
						'type'        => Controls_Manager::TEXT,
						'default'     => __( 'Parallax 1' , 'colorway-addons' ),
						'label_block' => true,
						'render_type' => 'ui',
					],
					[
						'name'      => 'section_parallax_image',
						'label'     => esc_html__( 'Image', 'colorway-addons' ),
						'type'      => Controls_Manager::MEDIA,
						//'condition' => [ 'parallax_content' => 'parallax_image' ],
					],
					[
						'name'    => 'section_parallax_depth',
						'label'   => __( 'Depth', 'colorway-addons' ),
						'type'    => Controls_Manager::NUMBER,
						'default' => 0.1,
						'min'     => 0,
						'max'     => 1,
						'step'    => 0.1,
					],
					[
						'name'    => 'section_parallax_bgp_x',
						'label'   => __( 'Image X Position', 'colorway-addons' ),
						'type'    => Controls_Manager::NUMBER,
						'min'     => 0,
						'max'     => 100,
						'default' => 50,
					],
					[
						'name'    => 'section_parallax_bgp_y',
						'label'   => __( 'Image Y Position', 'colorway-addons' ),
						'type'    => Controls_Manager::NUMBER,
						'min'     => 0,
						'max'     => 100,
						'default' => 50,
					],
					[
						'name'    => 'section_parallax_bg_size',
						'label'   => __( 'Image Size', 'colorway-addons' ),
						'type'    => Controls_Manager::SELECT,
						'default' => 'cover',
						'options' => [
							'auto'    => __( 'Auto', 'colorway-addons' ),
							'cover'   => __( 'Cover', 'colorway-addons' ),
							'contain' => __( 'Contain', 'colorway-addons' ),
						],
					],		
									
				],
				'title_field' => '{{{ section_parallax_title }}}',
			]
		);


		$section->add_control(
			'section_parallax_mode1',
			[
				'label'   => esc_html__( 'Parallax Mode', 'colorway-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					''         => esc_html__( 'Relative', 'colorway-addons' ),
					'clip'     => esc_html__( 'Clip', 'colorway-addons' ),
					'hover'    => esc_html__( 'Hovar (Mobile also turn off)', 'colorway-addons' ),
				],
			]
		);
		

		$section->end_controls_section();

	}


	public function register_controls_widget_parallax($widget, $widget_id, $args) {
		static $widgets = [
			'_section_style', /* Section */
		];

		if ( ! in_array( $widget_id, $widgets ) ) {
			return;
		}

		$widget->add_control(
			'_widget_parallax_on1',
			[
				'label'        => esc_html__( 'Enable Parallax', 'colorway-addons' ),
				'description'  => esc_html__( 'Enable parallax for this element set below option after switch yes.', 'colorway-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '',
				'return_value' => 'yes',
				'separator'    => 'before',
			]
		);

		$widget->add_control(
			'_widget_parallax_x_value1',
			[
				'label'       => esc_html__( 'Parallax X', 'colorway-addons' ),
				'description' => esc_html__( 'If you need to parallax horizontally (x direction) so use this.', 'colorway-addons' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => [
					'px' => [
						'min'   => -200,
						'max'   => 200,
						'step' => 10,
					],
				],
				'condition'    => [
					'_widget_parallax_on1' => 'yes',
				],
			]
		);

		$widget->add_control(
			'_widget_parallax_y_value1',
			[
				'label'       => esc_html__( 'Parallax Y', 'colorway-addons' ),
				'description' => esc_html__( 'If you need to parallax vertically (y direction) so use this.', 'colorway-addons' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => [
					'px' => [
						'min'   => -200,
						'max'   => 200,
						'step' => 10,
					],
				],
				'default' => [
					'size' => 50,
				],
				'condition'    => [
					'_widget_parallax_on1' => 'yes',
				],
			]
		);

		$widget->add_control(
			'_widget_parallax_viewport_value1',
			[
				'label'       => esc_html__( 'ViewPort Start', 'colorway-addons' ),
				'description' => esc_html__('Animation range depending on the viewport.', 'colorway-addons'),
				'type'        => Controls_Manager::SLIDER,
				'range'       => [
					'px' => [
						'min'  => 0.1,
						'max'  => 1,
						'step' => 0.1,
					],
				],
				'default' => [
					'size' => 0.2,
				],
				'condition'    => [
					'_widget_parallax_on1' => 'yes',
				],
			]
		);

		$widget->add_control(
			'_widget_parallax_opacity_value1',
			[
				'label'   => esc_html__( 'Opacity', 'colorway-addons' ),
				'description' => esc_html__( 'This option set your element opacity when happen the parallax.', 'colorway-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '0,1',
				'options' => [
					''  => esc_html__( 'None', 'colorway-addons' ),
					'0,1' => esc_html__( '0 -> 1', 'colorway-addons' ),
					'1,0' => esc_html__( '1 -> 0', 'colorway-addons' ),
				],
				'condition'    => [
					'_widget_parallax_on1' => 'yes',
				],
			]
		);

	}


	protected function add_actions() {

		$bg_parallax              = colorway_addons_option('section_parallax_show', 'colorway_addons_elementor_extend', 'on' );
		$widget_parallax          = colorway_addons_option('widget_parallax_show', 'colorway_addons_elementor_extend', 'on' );
		$section_particles        = colorway_addons_option('section_particles_show', 'colorway_addons_elementor_extend', 'on' );
		$section_schedule         = colorway_addons_option('section_schedule_show', 'colorway_addons_elementor_extend', 'on' );
		$section_sticky           = colorway_addons_option('section_sticky_show', 'colorway_addons_elementor_extend', 'on' );
		$section_parallax_content = colorway_addons_option('section_parallax_content_show', 'colorway_addons_elementor_extend', 'on' );

		if ( 'on' === $bg_parallax ) {
			add_action( 'elementor/element/before_section_end', [ $this, 'register_controls_bg_parallax' ], 10, 3 );		
			add_action( 'elementor/frontend/section/before_render', [ $this, 'parallax_before_render' ], 10, 1 );
		}
		
		if ( 'on' === $widget_parallax ) {
			add_action( 'elementor/element/before_section_end', [ $this, 'register_controls_widget_parallax' ], 10, 3 );
			add_action( 'elementor/frontend/widget/before_render', [ $this, 'widget_parallax_before_render' ], 10, 1 );
		}

		if ( 'on' === $section_particles ) {
			add_action( 'elementor/element/before_section_end', [ $this, 'register_controls_particles' ], 10, 3 );		
			add_action( 'elementor/frontend/section/before_render', [ $this, 'particles_before_render' ], 10, 1 );
			add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
			add_action( 'elementor/editor/before_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
			add_action( 'elementor/frontend/section/after_render', [ $this, 'particles_after_render' ], 10, 1 );
		}
		
		if ( 'on' === $section_schedule ) {
			add_action( 'elementor/element/after_section_end', [ $this, 'register_controls_scheduled' ], 10, 3 );
			add_action( 'elementor/frontend/section/before_render', [ $this, 'schedule_before_render' ], 10, 1 );
		}

		if ( 'on' === $section_parallax_content ) {
			add_action( 'elementor/element/after_section_end', [ $this, 'register_controls_parallax' ], 10, 3 );
			add_action( 'elementor/frontend/section/before_render', [ $this, 'section_parallax_before_render' ], 10, 1 );
		}

		if ( 'on' === $section_sticky ) {
			add_action( 'elementor/element/after_section_end', [ $this, 'register_controls_sticky' ], 10, 3 );
			add_action( 'elementor/frontend/section/before_render', [ $this, 'sticky_before_render' ], 10, 1 );
		}

		
		
	}



	public function parallax_before_render($section) {    		
		$settings = $section->get_settings();
		if( $section->get_settings( 'section_parallax_on1' ) == 'yes' ) {
			$parallax_settings = $section->get_settings( 'section_parallax_value' );
			$section->add_render_attribute( '_wrapper', 'ink-parallax', 'bgy: '.$parallax_settings['size'] );
		}
	}


	public function schedule_before_render($section) {    		
		$settings = $section->get_settings();
		if( $section->get_settings( 'section_scheduled_content_on' ) == 'yes' ) {
			$star_date    = strtotime($settings['section_scheduled_content_start_date']);
			$end_date     = strtotime($settings['section_scheduled_content_end_date']);
			$current_date = strtotime(gmdate( 'Y-m-d H:i', ( time() + ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS ) ) ));

			if ( ($current_date >= $star_date) and ($current_date <= $end_date) ) {
				$section->add_render_attribute( '_wrapper', 'class', 'ink-scheduled' );
			} else {
				$section->add_render_attribute( '_wrapper', 'class', 'ink-hidden' );
			}
		}
	}

	public function sticky_before_render($section) {    		
		$settings = $section->get_settings();
		if( !empty($settings[ 'section_sticky_on' ]) == 'yes' ) {
			$sticky_option = [];
			if ( !empty($settings[ 'section_sticky_on_scroll_up' ]) ) {
				$sticky_option['show-on-up'] = 'show-on-up: true';
			}

			if ( !empty($settings[ 'section_sticky_offset' ]['size']) ) {
				$sticky_option['offset'] = 'offset: ' . $settings[ 'section_sticky_offset' ]['size'];
			}

			if ( !empty($settings[ 'section_sticky_animation' ]) ) {
				$sticky_option['animation'] = 'animation: ink-animation-' . $settings[ 'section_sticky_animation' ] . '; top: 100';
			}

			if ( !empty($settings[ 'section_sticky_bottom' ]) ) {
				$sticky_option['top'] = 'top: ' . $settings[ 'section_sticky_bottom' ];
			}

			if ( !empty($settings[ 'section_sticky_off_media' ]) ) {
				$sticky_option['media'] = 'media: ' . $settings[ 'section_sticky_off_media' ];
			}
			
			$section->add_render_attribute( '_wrapper', 'ink-sticky', implode(";",$sticky_option) );
		}
	}
	

	public function widget_parallax_before_render($widget) {    		
		$settings = $widget->get_settings();
		if( $settings['_widget_parallax_on1'] == 'yes' ) {
			$slider_settings = [];
			if (!empty($settings['_widget_parallax_opacity_value'])) {
				$slider_settings['x'] = 'opacity: ' . $settings['_widget_parallax_opacity_value'] . ';';	
			}
			if (!empty($settings['_widget_parallax_x_value']['size'])) {
				$slider_settings['x'] = 'x: ' . $settings['_widget_parallax_x_value']['size'] . ',0;';	
			}
			if (!empty($settings['_widget_parallax_y_value']['size'])) {
				$slider_settings['y'] = 'y: ' . $settings['_widget_parallax_y_value']['size'] . ',0;';
			}
			if (!empty($settings['_widget_parallax_viewport_value']['size'])) {
				$slider_settings['viewport'] = 'viewport: ' . $settings['_widget_parallax_viewport_value']['size'] . ';';
			}

			$widget->add_render_attribute( '_wrapper', 'ink-parallax', implode(" ",$slider_settings) );
		}
	}
	
	public function particles_before_render($section) {    		
		$settings = $section->get_settings();
		if( $section->get_settings( 'section_particles_on' ) == 'yes' ) {
			$section->add_render_attribute( '_wrapper', 'class', 'ink-particles' );
			$element_id = $section->get_settings( '_element_id' );
			if (empty($element_id)) {
				$section->add_render_attribute( '_wrapper', 'id', 'ink-particles-' . $section->get_id() );	
			}
		}
	}

	public function particles_after_render($section) {
		$settings = $section->get_settings();
		$element_id = $section->get_settings( '_element_id' );
		if (empty($element_id)) {
			$id = 'ink-particles-'.$section->get_id();
		} else {
			$id = $section->get_settings( '_element_id' );
		}
		if( $section->get_settings( 'section_particles_on' ) == 'yes' ) {		
			if ( ! empty( $settings['section_particles_js'] ) ) { ?>
				<script type="text/javascript">
					document.addEventListener("DOMContentLoaded", evt => {
						particlesJS("<?php echo esc_attr($id); ?>", <?php echo $settings['section_particles_js']; ?> );
					});
				</script>
			<?php } else { $this->default_particles_render($section); }
		}
	}

	protected function default_particles_render($section) {
		$element_id = $section->get_settings( '_element_id' );
		if (empty($element_id)) {
			$id = 'ink-particles-'.$section->get_id();
		} else {
			$id = $section->get_settings( '_element_id' );
		}
		?>
		<script type="text/javascript">
			document.addEventListener("DOMContentLoaded", evt => {
				particlesJS("<?php echo esc_attr($id); ?>", {"particles":{"number":{"value":80,"density":{"enable":true,"value_area":800}},"color":{"value":"#ffffff"},"shape":{"type":"circle","stroke":{"width":0,"color":"#000000"},"polygon":{"nb_sides":5},"image":{"src":"img/github.svg","width":100,"height":100}},"opacity":{"value":0.5,"random":false,"anim":{"enable":false,"speed":1,"opacity_min":0.1,"sync":false}},"size":{"value":3,"random":true,"anim":{"enable":false,"speed":40,"size_min":0.1,"sync":false}},"line_linked":{"enable":true,"distance":150,"color":"#ffffff","opacity":0.4,"width":1},"move":{"enable":true,"speed":6,"direction":"none","random":false,"straight":false,"out_mode":"out","bounce":false,"attract":{"enable":false,"rotateX":600,"rotateY":1200}}},"interactivity":{"detect_on":"canvas","events":{"onhover":{"enable":false,"mode":"repulse"},"onclick":{"enable":true,"mode":"push"},"resize":true},"modes":{"grab":{"distance":400,"line_linked":{"opacity":1}},"bubble":{"distance":400,"size":40,"duration":2,"opacity":8,"speed":3},"repulse":{"distance":200,"duration":0.4},"push":{"particles_nb":4},"remove":{"particles_nb":2}}},"retina_detect":true});
			});
		</script>		
	<?php
	}


	public function section_parallax_before_render($section) {
		$parallax_elements = $section->get_settings('section_parallax_elements');
		$settings          = $section->get_settings();

		if( empty($parallax_elements) ) {
			return;
		}

		wp_enqueue_script( 'parallax' );

		$id                = $section->get_id();
		$section->add_render_attribute( 'scene', 'class', 'parallax-scene' );
		$section->add_render_attribute( '_wrapper', 'class', 'has-ink-parallax' );

		if ( 'relative' === $settings['section_parallax_mode']) {
			$section->add_render_attribute( 'scene', 'data-relative-input', 'true' );
		} elseif ( 'clip' === $settings['section_parallax_mode']) {
			$section->add_render_attribute( 'scene', 'data-clip-relative-input', 'true' );
		} elseif ( 'hover' === $settings['section_parallax_mode']) {
			$section->add_render_attribute( 'scene', 'data-hover-only', 'true' );
		}


		?>
		<div data-parallax-id="ink_scene<?php echo esc_attr($id); ?>" id="ink_scene<?php echo esc_attr($id); ?>" <?php echo $section->get_render_attribute_string( 'scene' ); ?>>
			<?php foreach ( $parallax_elements as $index => $item ) : ?>
			
				<?php 

				$image_src = wp_get_attachment_image_src( $item['section_parallax_image']['id'], 'full' ); 

				if ($item['section_parallax_bgp_x']) {
					$section->add_render_attribute( 'item', 'style', 'background-position-x: ' . $item['section_parallax_bgp_x'] . '%;', true );
				}
				if ($item['section_parallax_bgp_y']) {
					$section->add_render_attribute( 'item', 'style', 'background-position-y: ' . $item['section_parallax_bgp_y'] . '%;' );
				}
				if ($item['section_parallax_bg_size']) {
					$section->add_render_attribute( 'item', 'style', 'background-size: ' . $item['section_parallax_bg_size'] . ';' );
				}

				if ($image_src[0]) {
					$section->add_render_attribute( 'item', 'style', 'background-image: url(' . esc_url($image_src[0]) .');' );
				}

				?>
				
				<div data-depth="<?php echo $item['section_parallax_depth']; ?>" class="ink-scene-item" <?php echo $section->get_render_attribute_string( 'item' ); ?>></div>
				

			<?php endforeach; ?>
		</div>

		<?php
	}

	public function enqueue_scripts() {
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		wp_enqueue_script( 'particles', INKCA_URL . 'assets/vendor/js/particles' . $suffix . '.js', ['jquery'], '2.0.0', false );
	}



}
