<?php
namespace CwAddons\Modules\Woocommerce;

use CwAddons\Base\Colorway_Addons_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Colorway_Addons_Module_Base {

	public static function is_active() {
		return function_exists( 'WC' );
	}

	public function get_name() {
		return 'ink-woocommerce';
	}

	public function get_widgets() {
		return [
			'Products',
			'Add_To_Cart',
			'Elements',
			'Categories',
			'WC_Carousel',
		];
	}

	public function add_product_post_class( $classes ) {
		$classes[] = 'product';

		return $classes;
	}

	public function add_products_post_class_filter() {
		add_filter( 'post_class', [ $this, 'add_product_post_class' ] );
	}

	public function remove_products_post_class_filter() {
		remove_filter( 'post_class', [ $this, 'add_product_post_class' ] );
	}
}
