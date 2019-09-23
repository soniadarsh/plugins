<?php
/**
 * Colorway Addons Admin Settings Class 
 *
 */
if (!function_exists('is_plugin_active')) {
    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}

class InkSlides_Admin_Settings {

    private $settings_api;

    function __construct() {
        $this->settings_api = new InkSlides_Settings_API;

        add_action('admin_init', [$this, 'admin_init']);
        add_action('admin_menu', [$this, 'admin_menu'], 201);
    }

    function admin_init() {

        //set the settings
        $this->settings_api->set_sections($this->get_settings_sections());
        $this->settings_api->set_fields($this->colorway_addons_admin_settings());

        //initialize settings
        $this->settings_api->admin_init();
    }

    function admin_menu() {
        add_submenu_page(
                'elementor', '', esc_html__('ColorWay Addons Settings', 'colorway-addons'), 'manage_options', 'colorway_addons_options', [$this, 'plugin_page']
        );
    }

    function get_settings_sections() {
        $sections = [
            [
                'id' => 'colorway_addons_active_modules',
                'title' => esc_html__('ColorWay Addons Widgets', 'colorway-addons')
            ],
//                        [
//                'id'    => 'colorway_addons_elementor_extend',
//                'title' => esc_html__( 'Colorway Addons Extends', 'colorway-addons' )
//            ],
        ];
        return $sections;
    }

    protected function colorway_addons_admin_settings() {
        $settings_fields = [
            'colorway_addons_active_modules' => [
                [
                    'name' => 'image-compare',
                    'label' => esc_html__('Image Compare', 'colorway-addons'),
                    'type' => 'checkbox',
                    'default' => "on",
                ],
                [
                    'name' => 'column-slider',
                    'label' => esc_html__('Panel Slider', 'colorway-addons'),
                    'type' => 'checkbox',
                    'default' => "on",
                ],
                [
                    'name' => 'post-slider',
                    'label' => esc_html__('Post Slider', 'colorway-addons'),
                    'type' => 'checkbox',
                    'default' => "on",
                ],
                [
                    'name' => 'slider',
                    'label' => esc_html__('Slider', 'colorway-addons'),
                    'type' => 'checkbox',
                    'default' => "on",
                ],
                [
                    'name' => 'slideshow',
                    'label' => esc_html__('Slideshow', 'colorway-addons'),
                    'type' => 'checkbox',
                    'default' => "on",
                ],
                [
                    'name' => 'woocommerce',
                    'label' => esc_html__('Woocommerce', 'colorway-addons'),
                    'type' => 'checkbox',
                    'default' => "on",
                ],
                [
                    'name' => 'section_sticky_show',
                    'label' => esc_html__('Sticky Section', 'colorway-addons'),
                    'type' => 'checkbox',
                    'default' => "on",
                ],
            ],

        ];

        return $settings_fields;
    }

    function plugin_page() {

        echo '<div class="wrap">';
        echo '<h1>ColorWay Addons Settings</h1>';
        $this->save_message();
        $this->settings_api->show_navigation();
        $this->settings_api->show_forms();

        //$this->footer_info();
        echo '</div>';
    }

    function save_message() {
        if (isset($_GET['settings-updated'])) {
            ?>
            <div class="updated notice is-dismissible"> 
                <p><strong><?php esc_html_e('Your settings have been saved.', 'colorway-addons') ?></strong></p>
            </div>

            <?php
        }
    }

    /**
     * Get all the pages
     *
     * @return array page names with key value pairs
     */
    function get_pages() {
        $pages = get_pages();
        $pages_options = [];
        if ($pages) {
            foreach ($pages as $page) {
                $pages_options[$page->ID] = $page->post_title;
            }
        }

        return $pages_options;
    }

}

new InkSlides_Admin_Settings();
