<?php
namespace CwAddons\Modules\TwoColumnSlider;

use CwAddons\Base\Colorway_Addons_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Colorway_Addons_Module_Base {

	public function get_name() {
		return 'two-column-slider';
	}

	public function get_widgets() {
		$widgets = [
			'TwoColumnSlider',
		];

		return $widgets;
	}
}
