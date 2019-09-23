<?php
/**
  Plugin Name: LeadUp Pro Plugin
  Plugin URI: http://inkthemes.com/
  Description: With LeadUp Plugin the business owner allows to grab leads directly from their website so that all the leads can be utilised for the business purpose, Moreover you can put the LeadUp form in any page just by placing a shortcode on the page you desire to show the LeadUp form
  Version: 1.0.7
  Author: inkthemes
  Author URI: http://inkthemes.com
  Text Domain: leadcapture
  Domain Path: /languages/
 */
ob_start();

final class LeadsCapturePlugin {

    public function __construct() {
        require_once(plugin_dir_path(__FILE__) . 'leads-database.php');
        define('LEADS_PLUGIN_URL', plugin_dir_url(__FILE__));
        define('LEADS_PLUGIN_DIR', plugin_dir_path(__FILE__));
        define('CSS_PLUGIN_URL', LEADS_PLUGIN_URL . 'css/');
        define('JQUERY_PLUGIN_URL', LEADS_PLUGIN_URL . 'js/');
        define('IMG_PLUGIN_URL', LEADS_PLUGIN_URL . 'images/');
        $file_name = array(
            'autosave-php',
            'leads-autosave',
            'leads-menu',
            'class-leads',
            'leads-customform',
            'leads-showdata',
            'function-leads');
        foreach ($file_name as $files) {
            if (file_exists(LEADS_PLUGIN_DIR . $files . '.php')) {
                require_once(LEADS_PLUGIN_DIR . $files . '.php');
            }
        }
        if (file_exists(LEADS_PLUGIN_DIR . 'leads-widget.php')) {
            require_once(LEADS_PLUGIN_DIR . 'leads-widget.php');
        }
        if (file_exists(LEADS_PLUGIN_DIR . 'leads-frontend.php')) {
            require_once(LEADS_PLUGIN_DIR . 'leads-frontend.php');
        }
//        if (file_exists(plugin_dir_path(__FILE__) . 'leads-tiny/leads-tiny.php')) {
//            require(plugin_dir_path(__FILE__) . 'leads-tiny/leads-tiny.php');
//        }

        add_action('init', array($this, 'frontend_style'));
        add_action('plugins_loaded', array($this, 'leadcapture_text_domain'));
    }

    public function frontend_style() {
        if (!is_admin()) {
            wp_enqueue_style('leadcapture_front_style', CSS_PLUGIN_URL . 'leads-front.css');
        }
        wp_enqueue_script('leadcapture_recaptcha', '//www.google.com/recaptcha/api.js');       
        wp_enqueue_script('jquery-form-validation', 'https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js', array('jquery'));
          wp_enqueue_script('leadcapture_form_validation', JQUERY_PLUGIN_URL . 'form-validation.js', array('jquery'));
    }

    public function leadcapture_text_domain() {
        load_plugin_textdomain('leadcapture', false, dirname(plugin_basename(__FILE__)) . '/languages/');
    }
    
    /**
    * Admin notice
    *
    * Warning when the site doesn't have Elementor installed or activated.
    *
    * @since 1.0.0
    * @access public
    */
   public function admin_notice_missing_main_plugin() {
       if (isset($_GET['activate'])) {
           unset($_GET['activate']);
       }

       $message = sprintf(
               /* translators: 1: Plugin name 2: Elementor */
               __('"%1$s" recommends "%2$s" to be installed and activated for advance styling <a href="' . esc_url(admin_url('plugin-install.php?s=Elementor&tab=search&type=term')) . '">%3$s</a>', 'leadcapture'), '<strong>' . esc_html__('LeadUp Plugin', 'leadcapture') . '</strong>', '<strong>' . esc_html__('Elementor Plugin', 'leadcapture') . '</strong>', '<strong>' . esc_html__('Install/Activate Elementor', 'leadcapture') . '</strong>'
       );

       printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
   } 
    
     /**
	 * Initialize the plugin
	 *
	 * Validates that Elementor is already loaded.
	 * Checks for basic plugin requirements, if one check fail don't continue,
	 * if all check have passed include the plugin class.
	 *
	 * Fired by `plugins_loaded` action hook.
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function ink_elementor_init() {

		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_missing_main_plugin' ) );
			return;
		}else{
		// Once we get here, We have passed all validation checks so we can safely include our plugin
		require_once( plugin_dir_path(__FILE__).'elementor/plugin.php' );
                }
	}

}

function leads() {
    $leadscapture = new LeadsCapturePlugin();
    add_action( 'plugins_loaded', array( $leadscapture, 'ink_elementor_init' ) );
}

leads();

ob_clean();

/*
 * Self Hosted Plugin Upadte
 */
//require ( LEADS_PLUGIN_DIR . 'leadup-plugin-update-checker/plugin-update-checker.php' );
//$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
//	'https://www.inkthemes.com/wp-content/uploads/leadup_info.json',
//	__FILE__, //Full path to the main plugin file or functions.php.
//	'leadup'
//);

require (  LEADS_PLUGIN_DIR . 'leadup-plugin-update-checker/plugin-update-checker.php' );
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://github.com/MagnetBrains/InkThemes/',
	__FILE__,
	'leadup'
);

 $myUpdateChecker->setAuthentication('ae88873ac6f45c47aaf572cc9f7e00ceb06c30b5');
$myUpdateChecker->setBranch('master');
$myUpdateChecker->getVcsApi()->enableReleaseAssets();

