<?php
/*
  Plugin Name: AppointUp Plugin
  Plugin URI: https://www.inkthemes.com/
  Description: With AppointUp Plugin you can book the appointment of the clients directly through your Website. Moreover,  the clients will be notified instantly regarding the appointment details.
  Version: 1.0.4
  Author: inkthemes
  Author URI: https://www.inkthemes.com/
  License: GPL2
  License URI: https://www.inkthemes.com/
  Text Domain: appointment
  Domain Path: /languages/
 */
ob_start();

class Ink_Appointment {

    /**
     * Plugin dir file url
     * @var type string
     */
    var $dir = '';

    /**
     * Plugin dir host url
     * @var type string
     */
    var $dir_url = '';

    /**
     * Plugin csv file pa
     * @var type string
     */
    function __construct() {
        $this->dir = plugin_dir_path(__FILE__);
        $this->dir_url = plugin_dir_url(__FILE__);
    }

    /**
     * Load scripts
     */
    function scripts() {
//        if (!is_admin()) {
        wp_enqueue_style('cal-css-ui', $this->dir_url . 'ink-admin/js/cal-front/jquery-ui.css');
        wp_enqueue_style('ink-form-css', $this->dir_url . 'ink-admin/css/ink-form.css');
        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        if (!is_plugin_active('elementor/elementor.php')) {
            $form_style = get_option('apt_form_style');
            switch ($form_style) {
                case 1:
                    wp_enqueue_style('ink-form-color-css', $this->dir_url . 'ink-admin/css/colors/blue.css');
                    break;
                case 2:
                    wp_enqueue_style('ink-form-color-css', $this->dir_url . 'ink-admin/css/colors/green.css');
                    break;
                case 3:
                    wp_enqueue_style('ink-form-color-css', $this->dir_url . 'ink-admin/css/colors/red.css');
                    break;
                case 4:
                    wp_enqueue_style('ink-form-color-css', $this->dir_url . 'ink-admin/css/colors/yellow.css');
                    break;
                default :
                    '';
            }
        }

        wp_enqueue_script('jquery-ui-cal', $this->dir_url . 'ink-admin/js/cal-front/jquery-ui.js', array('jquery'));
        wp_enqueue_script('ink-required', $this->dir_url . 'ink-admin/js/ink-required.js', array('jquery', 'wp-color-picker'));
        wp_enqueue_script('inkappointment-jquery-form-val-lib', '//ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js');
        wp_enqueue_script('inkappointment-jquery-form-validation', $this->dir_url . 'ink-admin/js/form-validation.js', array('jquery'));
        wp_enqueue_script('google-captcha', 'https://www.google.com/recaptcha/api.js');

        if (get_option('apt_form_background_color') != '') :
            $color = get_option('apt_form_background_color');
            $custom_css = "
                .ink-container{
                        background: $color !important;
                }";
            wp_add_inline_style('ink-form-css', $custom_css);
        endif;

        if (get_option('apt_form_text_color') != '') :
            $color = get_option('apt_form_text_color');
            $custom_css = "
                .ink-container .ink-form ul.inkappform span.msg_text,.ink-container ul.inkappform span.fix_date,.ink-container ul.inkappform input.inktext, .ink-container ul.inkappform textarea.inktext,.ink-container ul.inkappform select.inktext,.ink-container ul.inkappform input.inktext::placeholder, .ink-container ul.inkappform textarea.inktext::placeholder{
                        color: $color !important;
                }";
            wp_add_inline_style('ink-form-css', $custom_css);
        endif;

        if (get_option('apt_form_background_input_color') != '') :
            $color = get_option('apt_form_background_input_color');
            $custom_css = "
                .ink-container ul.inkappform input.inktext, .ink-container ul.inkappform textarea.inktext, .ink-container ul.inkappform select.inktext,input#aptcal, #DOPBookingSystem_CheckInView1, #DOPBookingSystem_CheckOutView1{
                        background: $color !important;
                }";
            wp_add_inline_style('ink-form-css', $custom_css);
        endif;

        if (get_option('apt_form_border_input_color') != '') :
            $color = get_option('apt_form_border_input_color');
            $custom_css = "
                .ink-container ul.inkappform input.inktext, .ink-container ul.inkappform textarea.inktext,.ink-container ul.inkappform select.inktext,.ink-container ul.inkappform input.inktext:focus, ul.inkappform textarea.inktext:focus{
                            border: 1px solid $color !important;
                }.ink-container .ink-form ul.inkappform li h2{
                border-bottom: 1px solid $color !important;
                 }";
            wp_add_inline_style('ink-form-css', $custom_css);
        endif;

        if (get_option('submit_btn_background_color') != '') :
            $color = get_option('submit_btn_background_color');
            $custom_css = "
                .ink-container ul.inkappform input#submit{
                background-color: $color !important;
                 }";
            wp_add_inline_style('ink-form-css', $custom_css);
        endif;

        if (get_option('submit_btn_hover_background_color') != '') :
            $color = get_option('submit_btn_hover_background_color');
            $custom_css = "
                .ink-container ul.inkappform input#submit:hover{
                background-color: $color !important;
                 }";
            wp_add_inline_style('ink-form-css', $custom_css);
        endif;

        if (get_option('submit_btn_txt_color') != '') :
            $color = get_option('submit_btn_txt_color');
            $custom_css = "
                .ink-container ul.inkappform input#submit{
                color: $color !important;
                 }";
            wp_add_inline_style('ink-form-css', $custom_css);
        endif;

        if (get_option('submit_btn_shadow_color') != '') :
            $color = get_option('submit_btn_shadow_color');
            $custom_css = "
                .ink-container ul.inkappform input#submit{
                webkit-box-shadow: 0 2px 0 $color !important;      
                -moz-box-shadow: 0 2px 0 $color !important;      
                box-shadow: 0 2px 0 $color !important;
                 }";
            wp_add_inline_style('ink-form-css', $custom_css);
        endif;

//    }
    }

    /**
     * Include all modules files
     */
    function include_files() {

        /**
         * Load db file
         */
        require_once $this->dir . 'ink-admin/appointments-form/database/apt-database.php';

        /**
         * Load tiny editor init file 
         */
       // require_once $this->dir . 'ink-admin/apt-tiny/apt-tiny.php';

        /**
         * Load apt functions file
         */
        require_once $this->dir . 'ink-admin/appointments-form/apt-function.php';

        /**
         * Load text data file
         */
        require_once $this->dir . 'ink-admin/appointments-form/text-data.php';

        /**
         * Load apt form widget file
         */
        require_once $this->dir . 'ink-admin/apt-form.php';

        /**
         * Load paypal integration page file.
         */
        require_once $this->dir . 'ink-admin/appointments-form/getway/paypal-page.php';

        /**
         * Load payment transaction file.
         */
        require_once $this->dir . 'ink-admin/appointments-form/getway/paypal/paypaltrans.php';

        /**
         * Load payment paypalipn file.
         */
        // require_once $this->dir . 'ink-admin/appointments-form/getway/paypal/paypal-ipn.php';

        /**
         * Load aptleads files.
         */
        require_once $this->dir . 'ink-admin/class-aptleads.php';

        /**
         * Load aptleads files.
         */
        require_once $this->dir . 'ink-admin/apt-function-leads.php';


        require_once $this->dir . 'ink-admin/appointments-form/templates/calendar-lib/event.php';

        /**
         * Load widget file.
         */
        require_once $this->dir . 'widget.php';

        /**
         * Twilio File
         */
        $is_sms_on = get_option('sms_enable');
        if ($is_sms_on == 'on') {
            require_once $this->dir . 'ink-admin/appointments-form/getway/Twilio/autoload.php';
        }
    }

    /**
     * Load ajax files
     */
    function apt_ajax_load_scripts() {
// load our jquery file that sends the $.post request
        wp_enqueue_script('jquery-apt-ajax', $this->dir_url . 'ink-admin/js/ink-apt-ajax.js', array('jquery'));
// make the ajaxurl var available to the above script
        wp_localize_script('jquery-apt-ajax', 'script_call', array('ajaxurl' => admin_url('admin-ajax.php')));
    }

}

/**
 * Class for Appointment system initialization.
 */
class Ink_Appointment_Init extends Ink_Appointment {

    /**
     * Constructor for parent class
     */
    function __construct() {
        parent::__construct();
        add_action('plugins_loaded', array($this, 'ink_elementor_init'));
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
        if (!did_action('elementor/loaded')) {
            add_action('admin_notices', array($this, 'admin_notice_missing_main_plugin'));
            return;
        } else {
            // Once we get here, We have passed all validation checks so we can safely include our plugin
            require_once( plugin_dir_path(__FILE__) . 'ink-admin/elementor/plugin.php' );
        }
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
                __('"%1$s" recommends "%2$s" to be installed and activated for advance styling <a href="' . esc_url(admin_url('plugin-install.php?s=Elementor&tab=search&type=term')) . '">%3$s</a>', 'appointment'), '<strong>' . esc_html__('AppointUp Plugin', 'appointment') . '</strong>', '<strong>' . esc_html__('Elementor Plugin', 'appointment') . '</strong>', '<strong>' . esc_html__('Install/Activate Elementor', 'appointment') . '</strong>'
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }

    /**
     * Init function
     */
    static function Init() {
        $obj = new Ink_Appointment_Init();
        load_plugin_textdomain('appointment', false, dirname(plugin_basename(__FILE__)) . '/languages/');
        /**
         * Include files
         */
        $obj->_include();

        /**
         * Include scripts
         */
        $obj->_include_scripts();
        add_filter('plugin_action_links_' . plugin_basename(__FILE__), array($obj, 'apt_admin_plugin_actions'), -10);
    }

    /**
     * Default install modules
     */
    static function Install() {
        Apt_DB::Install();
    }

    /**
     * Uninstall default options
     */
    static function Uninstall() {
        Apt_DB::Uninstall();
    }

    /**
     * Adding custom setting link on pluing list
     * @param type $links
     * @return type
     */
    function apt_admin_plugin_actions($links) {
        $apt_plugin_links = array(
            '<a href="admin.php?page=paymentsettings">' . __('Settings', 'appointment') . '</a>'
        );
        return array_merge($apt_plugin_links, $links);
    }

    /**
     * Include modules
     */
    function _include() {
        $this->include_files();
    }

    /**
     * Load scripts
     */
    function _include_scripts() {
        add_action('wp_enqueue_scripts', array($this, 'scripts'));
        add_action('wp_enqueue_scripts', array($this, 'apt_ajax_load_scripts'));
        add_action('admin_enqueue_scripts', array($this, 'scripts'));
        add_action('admin_enqueue_scripts', array($this, 'apt_ajax_load_scripts'));
    }

}

Ink_Appointment_Init::Init();
Ink_Appointment_Init::Install();
//register_activation_hook(__FILE__, array('Ink_Appointment_Init', 'Install'));
//register_deactivation_hook(__FILE__, array('Ink_Appointment_Init', 'Uninstall'));

register_activation_hook(__FILE__, 'apt_on_activate');
register_deactivation_hook(__FILE__, 'apt_on_deactivate');

/*
 * Appointment calendar shortcode
 */

function ink_apt_calendar() {
    include(plugin_dir_path(__FILE__) . 'ink-admin/appointments-form/templates/calendar-lib/calendar-apt.php');
}

add_shortcode('apt_calendar', 'ink_apt_calendar');

ob_clean();

/*
 * Self Hosted Plugin Upadte
 */
//require ( plugin_dir_path(__FILE__) . 'appointup-plugin-update-checker/plugin-update-checker.php' );
//$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
//	'https://www.inkthemes.com/wp-content/uploads/appointup_info.json',
//	__FILE__, //Full path to the main plugin file or functions.php.
//	'appointup'
//);

require ( plugin_dir_path(__FILE__) . 'appointup-plugin-update-checker/plugin-update-checker.php' );
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://github.com/soniadarsh/plugins/',
	__FILE__,
	'appointup'
);
//$myUpdateChecker->setAuthentication('ae88873ac6f45c47aaf572cc9f7e00ceb06c30b5');
//select branch
$myUpdateChecker->setBranch('master');
$myUpdateChecker->getVcsApi()->enableReleaseAssets();