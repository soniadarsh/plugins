<?php
namespace CwAddons;

use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Admin {

	public function __construct() {
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_styles' ] );		
	}

	public function enqueue_styles() {

		$suffix = is_rtl() ? '.rtl' : '';

		wp_register_style( 'colorway-addons-admin', INKCA_ASSETS_URL . 'css/admin' . $suffix . '.css', INKCA_VER );

		wp_enqueue_style( 'colorway-addons-admin' );
	}

}
