<?php

namespace CwAddons;

use Elementor\Utils;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * Main class for colorway addons
 */

class Colorway_Addons_Loader {

    /**
     * @var Colorway_Addons_Loader
     */
    private static $_instance;

    /**
     * @var Manager
     */
    private $_modules_manager;
    private $classes_aliases = [
        'CwAddons\Modules\PanelPostsControl\Module' => 'CwAddons\Modules\QueryControl\Module',
        'CwAddons\Modules\PanelPostsControl\Controls\Group_Control_Posts' => 'CwAddons\Modules\QueryControl\Controls\Group_Control_Posts',
        'CwAddons\Modules\PanelPostsControl\Controls\Query' => 'CwAddons\Modules\QueryControl\Controls\Query',
    ];

    /**
     * @deprecated
     *
     * @return string
     */
    public function get_version() {
        return INKCA_VER;
    }

    /**
     * Throw error on object clone
     *
     * The whole idea of the singleton design pattern is that there is a single
     * object therefore, we don't want the object to be cloned.
     *
     * @since 1.0.0
     * @return void
     */
    public function __clone() {
        // Cloning instances of the class is forbidden
        _doing_it_wrong(__FUNCTION__, esc_html__('Cheatin&#8217; huh?', 'colorway-addons'), '1.1.6');
    }

    /**
     * Disable unserializing of the class
     *
     * @since 1.0.0
     * @return void
     */
    public function __wakeup() {
        // Unserializing instances of the class is forbidden
        _doing_it_wrong(__FUNCTION__, esc_html__('Cheatin&#8217; huh?', 'colorway-addons'), '1.1.6');
    }

    /**
     * @return \Elementor\Colorway_Addons_Loader
     */
    public static function elementor() {
        return \Elementor\Plugin::$instance;
    }

    /**
     * @return Colorway_Addons_Loader
     */
    public static function instance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /**
     * we loaded module manager + admin php from here
     * @return [type] [description]
     */
    private function _includes() {
        require INKCA_PATH . 'includes/modules-manager.php';
        if (is_admin()) {
            if (!defined('COLORWAY_ADDONS_CONFIG_HIDE')) {
                require INKCA_PATH . 'includes/admin.php';
            }
            if (!defined('COLORWAY_ADDONS_AS_THEME')) {
                // Updater function for update plugin automatically
                //require INKCA_PATH . 'includes/updater/src/V1/PluginUpdater.php';
                // Set up the Update integration
                //new \CwAddons\V1\PluginUpdater('Colorway Addons', 'https://www.inkthemes.co/license/', INKCA_PNAME, INKCA__FILE__, INKCA_VER);
            }
        }
    }

    /**
     * Autoloader function for all classes files
     * @param  [type] $class [description]
     * @return [type]        [description]
     */
    public function autoload($class) {
        if (0 !== strpos($class, __NAMESPACE__)) {
            return;
        }

        $has_class_alias = isset($this->classes_aliases[$class]);

        // Backward Compatibility: Save old class name for set an alias after the new class is loaded
        if ($has_class_alias) {
            $class_alias_name = $this->classes_aliases[$class];
            $class_to_load = $class_alias_name;
        } else {
            $class_to_load = $class;
        }

        if (!class_exists($class_to_load)) {
            $filename = strtolower(
                    preg_replace(
                            ['/^' . __NAMESPACE__ . '\\\/', '/([a-z])([A-Z])/', '/_/', '/\\\/'], ['', '$1-$2', '-', DIRECTORY_SEPARATOR], $class_to_load
                    )
            );
            $filename = INKCA_PATH . $filename . '.php';

            if (is_readable($filename)) {
                include( $filename );
            }
        }

        if ($has_class_alias) {
            class_alias($class_alias_name, $class);
        }
    }

    /**
     * Register all script that need for any specific widget on call basis.
     * @return [type] [description]
     */
    public function register_site_scripts() {

        $suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
        $settings = get_option('colorway_addons_api_settings');

        wp_register_script('ink-uikit-icons', INKCA_URL . 'assets/js/ink-uikit-icons' . $suffix . '.js', ['jquery', 'ink-uikit'], '3.0.0.42', true);
        wp_register_script('twentytwenty', INKCA_URL . 'assets/vendor/js/jquery.twentytwenty' . $suffix . '.js', ['jquery'], '0.1.0', true);
        wp_register_script('eventmove', INKCA_URL . 'assets/vendor/js/jquery.event.move' . $suffix . '.js', ['jquery'], '2.0.0', true);
        wp_register_script('tippyjs', INKCA_URL . 'assets/vendor/js/tippy.all' . $suffix . '.js', ['jquery'], '', true);

        if (!empty($settings['disqus_user_name'])) {
            wp_register_script('disqus', '//' . $settings['disqus_user_name'] . '.disqus.com/count.js', ['jquery'], null, true);
        }
    }

    /**
     * Loading site related style from here.
     * @return [type] [description]
     */
    public function enqueue_site_styles() {

        $direction_suffix = is_rtl() ? '.rtl' : '';
        wp_register_style('twentytwenty', INKCA_URL . 'assets/css/twentytwenty' . $direction_suffix . '.css', [], INKCA_VER);
        wp_enqueue_style('ink-addon-bootstrap', INKCA_URL . '/assets/css/bootstrap' . $direction_suffix . '.css', [], INKCA_VER);
        wp_enqueue_style('colorway-addons-site', INKCA_URL . 'assets/css/colorway-addons-site' . $direction_suffix . '.css', [], INKCA_VER);
    }

    /**
     * Loading site related script that needs all time such as uikit.
     * @return [type] [description]
     */
    public function enqueue_site_scripts() {

        $suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

        wp_enqueue_script('ink-uikit', INKCA_URL . 'assets/js/ink-uikit' . $suffix . '.js', ['jquery'], INKCA_VER);
        wp_enqueue_script('colorway-addons-site', INKCA_URL . 'assets/js/colorway-addons-site' . $suffix . '.js', ['jquery'], INKCA_VER);

        $locale_settings = [
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('colorway-addons-site'),
        ];

        // localize for user login widget ajax login script
        wp_localize_script('ink-uikit', 'colorway_addons_ajax_login_config', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'loadingmessage' => esc_html__('Sending user info, please wait...', 'colorway-addons'),
        ));


        // TODO for editor script
        wp_localize_script('ink-uikit', 'InkSlidesSiteConfig', apply_filters('colorway_addons/frontend/localize_settings', $locale_settings)
        );
    }

    /**
     * Load editor editor related style from here
     * @return [type] [description]
     */
    public function enqueue_preview_styles() {
        $direction_suffix = is_rtl() ? '.rtl' : '';

        wp_enqueue_style('colorway-addons-preview', INKCA_URL . 'assets/css/colorway-addons-preview' . $direction_suffix . '.css', '', INKCA_VER);
    }

    public function enqueue_editor_styles() {
        $direction_suffix = is_rtl() ? '-rtl' : '';
        //wp_enqueue_style('prefix-font-awesome', 'https://use.fontawesome.com/releases/v5.3.1/css/all.css');
        wp_enqueue_style('colorway-addons-editor', INKCA_URL . 'assets/css/colorway-addons-editor' . $direction_suffix . '.css', '', INKCA_VER);
    }
    
    public function font_awesome_styles() {
       wp_enqueue_style( 'font-awesome-css', plugins_url( '/', __FILE__ ).'assets/font-awesome/css/fontawesome.css', false, true );
   }


    /**
     * Add colorway_addons_ajax_login() function with wp_ajax_nopriv_ function 
     * @return [type] [description]
     */
    public function colorway_addons_ajax_login_init() {
        // Enable the user with no privileges to run colorway_addons_ajax_login() in AJAX
        add_action('wp_ajax_nopriv_colorway_addons_ajax_login', [$this, "colorway_addons_ajax_login"]);
    }

    /**
     * For ajax login
     * @return [type] [description]
     */
    public function colorway_addons_ajax_login() {
        // First check the nonce, if it fails the function will break
        check_ajax_referer('ajax-login-nonce', 'security');

        // Nonce is checked, get the POST data and sign user on
        $access_info = [];
        $access_info['user_login'] = !empty($_POST['username']) ? $_POST['username'] : "";
        $access_info['user_password'] = !empty($_POST['password']) ? $_POST['password'] : "";
        $access_info['remember'] = true;
        $user_signon = wp_signon($access_info, false);

        if (is_wp_error($user_signon)) {
            echo json_encode(['loggedin' => false, 'message' => esc_html__('Wrong username or password!', 'colorway-addons')]);
        } else {
            echo json_encode(['loggedin' => true, 'message' => esc_html__('Login successful, Redirecting...', 'colorway-addons')]);
        }

        die();
    }

    public function colorway_addons_ajax_search() {
        global $wp_query;

        $result = array('results' => array());
        $query = isset($_REQUEST['s']) ? $_REQUEST['s'] : '';

        if (strlen($query) >= 3) {

            $wp_query->query_vars['posts_per_page'] = 5;
            $wp_query->query_vars['post_status'] = 'publish';
            $wp_query->query_vars['s'] = $query;
            $wp_query->is_search = true;

            foreach ($wp_query->get_posts() as $post) {

                $content = !empty($post->post_excerpt) ? strip_tags(strip_shortcodes($post->post_excerpt)) : strip_tags(strip_shortcodes($post->post_content));

                if (strlen($content) > 180) {
                    $content = substr($content, 0, 179) . '...';
                }

                $result['results'][] = array(
                    'title' => $post->post_title,
                    'text' => $content,
                    'url' => get_permalink($post->ID)
                );
            }
        }

        die(json_encode($result));
    }

    /**
     * initialize the category
     * @return [type] [description]
     */
    public function colorway_addons_init() {
        $this->_modules_manager = new Manager();

        $elementor = \Elementor\Plugin::$instance;

        // Add element category in panel
        $elementor->elements_manager->add_category('colorway-addons', [
            'title' => esc_html__('Colorway Addons', 'colorway-addons'),
            'icon' => 'font',
                ], 1
        );

        do_action('colorway_addons/init');
    }

    private function setup_hooks() {
        add_action('elementor/init', [$this, 'colorway_addons_init']);
        add_action('elementor/editor/after_enqueue_styles', [$this, 'enqueue_editor_styles']);
        add_action('elementor/init', [$this, 'font_awesome_styles']);
        
        add_action('elementor/frontend/before_register_scripts', [$this, 'register_site_scripts']);

        add_action('elementor/preview/enqueue_styles', [$this, 'enqueue_preview_styles']);

        add_action('elementor/frontend/after_register_styles', [$this, 'enqueue_site_styles']);
        add_action('elementor/frontend/before_enqueue_scripts', [$this, 'enqueue_site_scripts']);

        if (!is_user_logged_in()) {
            add_action('elementor/init', [$this, 'colorway_addons_ajax_login_init']);
        }
    }

    /**
     * Colorway_Addons_Loader constructor.
     */
    private function __construct() {
        // Register class automatically
        spl_autoload_register([$this, 'autoload']);
        // Include some backend files
        $this->_includes();
        // Finally hooked up all things
        $this->setup_hooks();
        // Load admin class for admin related content process
        if (is_admin()) {
            new Admin();
        }
    }

}

if (!defined('INKCA_TESTS')) {
    // In tests we run the instance manually.
    Colorway_Addons_Loader::instance();
}