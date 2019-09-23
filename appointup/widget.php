<?php

class Ink_Appointment_Widget extends WP_Widget {

    function __construct() {
        $params = array(
            'name' => 'AppointUp Widget',
            'description' => __('Just drag and drop the widget to AppointUp in the page', 'appointment')
        );
        parent::__construct('Ink_Appointment_Widget', '', $params);
    }

    public function widget($args, $instance) {
        extract($args);
        $title = apply_filters('widget_title', '');
        $number = strip_tags(isset($instance['number']) ? $instance['number'] : null);
        echo $before_widget;
        if ($title)
            echo $before_title . $title . $after_title;
        $shortcode = do_shortcode('[ink-appointments-form]');
        echo $shortcode;
        //ink_appoitment();
        echo $after_widget;
    }
}

//add_action('widgets_init', create_function('', 'return register_widget("Ink_Appointment_Widget");'));

add_action('widgets_init', function(){
    return register_widget("Ink_Appointment_Widget");
});
