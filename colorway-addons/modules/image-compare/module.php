<?php
namespace CwAddons\Modules\ImageCompare;

use CwAddons\Base\Colorway_Addons_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Colorway_Addons_Module_Base {

	public function get_name() {
		return 'image-compare';
	}

	public function get_widgets() {

		$widgets = [
			'Image_Compare',
		];

		return $widgets;
	}
}
