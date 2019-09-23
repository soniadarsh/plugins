<?php
namespace CwAddons\Modules\Stickynav;

use CwAddons\Base\Colorway_Addons_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! function_exists('is_plugin_active')){ include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); }

class Module extends Colorway_Addons_Module_Base {

	public function get_name() {
		return 'stickynav';
	}

	public function get_widgets() {

		$widgets = [
			'Stickynav',
		];

		return $widgets;
	}
}
