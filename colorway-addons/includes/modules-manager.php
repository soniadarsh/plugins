<?php

namespace CwAddons;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

if (!function_exists('is_plugin_active')) {
    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}

final class Manager {

    private $_modules = null;

    private function is_module_active($module_id) {

        $module_data = $this->get_module_data($module_id);
        $options = get_option('colorway_addons_active_modules', []);

        if (!isset($options[$module_id])) {
            return $module_data['default_activation'];
        } else {
            if ($options[$module_id] == "on") {
                return true;
            } else {
                return false;
            }
        }

        return 'true' === $options[$module_id];
    }

    private function get_module_data($module_id) {
        return isset($this->_modules[$module_id]) ? $this->_modules[$module_id] : false;
    }

    public function __construct() {
        $modules = [
            'column-slider',
            'post-slider',
            'query-control',
            'text-slider',
            'advanced-slider',
            'image-compare',
            'two-column-slider',
            'stickynav',
            'wp-menu-bar',
            'woocommerce',
            'elementor'
        ];

		$woocommerce        = colorway_addons_option('woocommerce', 'colorway_addonsy_third_party_widget', 'on' );

		if( is_plugin_active('woocommerce/woocommerce.php') and 'on' === $woocommerce ) {
			$modules[] = 'woocommerce';
		}
        
        // Fetch all modules data
        foreach ($modules as $module) {
            $this->_modules[$module] = require INKCA_MODULES_PATH . $module . '/module.info.php';
        }

        foreach ($this->_modules as $module_id => $module_data) {
            if (!$this->is_module_active($module_id)) {
                continue;
            }

            $class_name = str_replace('-', ' ', $module_id);
            $class_name = str_replace(' ', '', ucwords($class_name));
            $class_name = __NAMESPACE__ . '\\Modules\\' . $class_name . '\Module';

            $class_name::instance();
        }
    }

}
