<?php
namespace CwAddons\Modules\TextSlider;

use CwAddons\Base\Colorway_Addons_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Colorway_Addons_Module_Base {

	public function get_name() {
		return 'text-slider';
	}

	public function get_widgets() {
		$widgets = [
			'TextSlider',
		];

		return $widgets;
	}
}
