<?php
namespace CwAddons\Modules\ColumnSlider;

use CwAddons\Base\Colorway_Addons_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Colorway_Addons_Module_Base {

	public function get_name() {
		return 'column-slider';
	}

	public function get_widgets() {
		$widgets = [
			'Column_Slider',
		];

		return $widgets;
	}
}
