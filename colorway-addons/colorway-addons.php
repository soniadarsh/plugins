<?php
/**
 * Plugin Name: ColorWay Addons
 * Plugin URI: https://www.inkthemes.com/colorway/
 * Description: With ColorWay Addons, get all the elements you'll ever need for your striking website. This plugin is a complete suite of sliders, e-commerce options and a lot more to take your website to another level.
 * Version: 1.1.6
 * Author: InkThemes
 * Author URI: https://www.inkthemes.com/
 * Text Domain: colorway-addons 
 */

// Some pre define value for easy use
define( 'INKCA_VER', '1.1.6' );
define( 'INKCA__FILE__', __FILE__ );
define( 'INKCA_PNAME', basename( dirname(INKCA__FILE__)) );
define( 'INKCA_PBNAME', plugin_basename(INKCA__FILE__) );
define( 'INKCA_PATH', plugin_dir_path( INKCA__FILE__ ) );
define( 'INKCA_MODULES_PATH', INKCA_PATH . 'modules/' );
define( 'INKCA_URL', plugins_url( '/', INKCA__FILE__ ) );
define( 'INKCA_ASSETS_URL', INKCA_URL . 'assets/' );
define( 'INKCA_MODULES_URL', INKCA_URL . 'modules/' );


// Helper function here
include(dirname(__FILE__).'/includes/helper.php');
include(dirname(__FILE__).'/includes/utils.php');

/**
 * Plugin load here correctly
 * Also loaded the language file from here
 */
function colorway_addons_load_plugin() {
    load_plugin_textdomain( 'colorway-addons', false, basename( dirname( __FILE__ ) ) . '/languages' );

	if ( ! did_action( 'elementor/loaded' ) ) {
		add_action( 'admin_notices', 'colorway_addons_fail_load' );
		return;
	}
	// Admin settings controller
    require( INKCA_PATH . 'includes/class.settings-api.php' );
    // colorway addons admin settings here
    require( INKCA_PATH . 'includes/admin-settings.php' );
	// colorway addons widget and assets loader
    require( INKCA_PATH . 'loader.php' );
}
add_action( 'plugins_loaded', 'colorway_addons_load_plugin' );


/**
 * Check Elementor installed and activated correctly
 */
function colorway_addons_fail_load() {
	$screen = get_current_screen();
	if ( isset( $screen->parent_file ) && 'plugins.php' === $screen->parent_file && 'update' === $screen->id ) {
		return;
	}

	$plugin = 'elementor/elementor.php';

	if ( _is_elementor_installed() ) {
		if ( ! current_user_can( 'activate_plugins' ) ) { return; }
		$activation_url = wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . $plugin . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $plugin );
		$admin_message = '<p>' . esc_html__( 'Oops! Colorway Addons requires Elementor plugin to be activated.', 'colorway-addons' ) . '</p>';
		$admin_message .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $activation_url, esc_html__( 'Activate Elementor Plugin', 'colorway-addons' ) ) . '</p>';
	} else {
		if ( ! current_user_can( 'install_plugins' ) ) { return; }
		$install_url = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=elementor' ), 'install-plugin_elementor' );
		$admin_message = '<p>' . esc_html__( 'Oops! Colorway Addons requires Elementor plugin to be installed.', 'colorway-addons' ) . '</p>';
		$admin_message .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $install_url, esc_html__( 'Install Elementor Plugin', 'colorway-addons' ) ) . '</p>';
	}

	echo '<div class="error">' . $admin_message . '</div>';
}

/**
 * Check the elementor installed or not
 */
if ( ! function_exists( '_is_elementor_installed' ) ) {

    function _is_elementor_installed() {
        $file_path = 'elementor/elementor.php';
        $installed_plugins = get_plugins();

        return isset( $installed_plugins[ $file_path ] );
    }
}

require ( INKCA_PATH . 'colorway-addons-update-checker/plugin-update-checker.php' );
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://github.com/soniadarsh/plugins/',
	__FILE__,
	'colorway-addons'
);

 $myUpdateChecker->setAuthentication('1bbb1f9e71afbe4c89f93836adb71e5882c3f04c');
$myUpdateChecker->setBranch('master');
$myUpdateChecker->getVcsApi()->enableReleaseAssets();