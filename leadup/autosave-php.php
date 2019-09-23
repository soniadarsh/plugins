<?php

session_start();


require(plugin_dir_path(__FILE__) . 'class-leads.php');
global $wpdb;
$tablename = $wpdb->prefix . 'leads_dynamicform';
$a = new LeadsSetData();
$keyup_check = '';
//$last = $wpdb->get_row("SHOW TABLE STATUS LIKE '" . $tablename . "'");
//
//if ($_SESSION['last_id'] != $last->Auto_increment) {
//    $_SESSION['last_id'] = '';
//}

add_action('wp_ajax_add_foobar', 'add_foobar');
add_action('wp_ajax_nopriv_add_foobar', 'add_foobar');

function add_foobar() {
// Handle request then generate response using WP_Ajax_Response
// Don't forget to stop execution afterward.

    global $wpdb, $leads_dynamicform;
    $autoincreement = $_POST['autoincreement'];
    $name = $_POST['name'];
    echo $name;
    $tablename = $wpdb->prefix . 'leads_dynamicform';
//    $last = $wpdb->get_row("SHOW TABLE STATUS LIKE '" . $tablename . "'");
//    $last2 = $last->Auto_increment;
    if (isset($_SESSION['last_id']) && $_SESSION['last_id'] == $autoincreement) {
        // code to update member data
        $query = $wpdb->replace($tablename, array(
            'id' => $_POST['autoincreement'],
            'name' => $_POST['name'] ? $_POST['name'] : ' ',
            'leadform1' => $_POST['email'] ? $_POST['email'] : ' ',
            'leadform2' => $_POST['message'] ? $_POST['message'] : ' ',
            'leadform3' => $_POST['label1'] ? $_POST['label1'] : ' ',
            'leadform4' => $_POST['label2'] ? $_POST['label2'] : ' ',
            'leadform5' => $_POST['label3'] ? $_POST['label3'] : ' ',
            'leadform6' => $_POST['label4'] ? $_POST['label4'] : ' ',
            'leadform7' => $_POST['label5'] ? $_POST['label5'] : ' ',
            'leadform8' => $_POST['label6'] ? $_POST['label6'] : ' ',
            'leadform9' => $_POST['label7'] ? $_POST['label7'] : ' ',
        ));
    } else {
        // code to create member data
        $query = $wpdb->insert($tablename, array(
            'name' => $_POST['name'],
            'leadform1' => $_POST['email'],
            'leadform2' => $_POST['message'],
            'leadform3' => $_POST['label1'],
            'leadform4' => $_POST['label2'],
            'leadform5' => $_POST['label3'],
            'leadform6' => $_POST['label4'],
            'leadform7' => $_POST['label5'],
            'leadform8' => $_POST['label6'],
            'leadform9' => $_POST['label7'],
            'date' => date('Y-m-d'),
            'rand_value' => ''
        ));
        $last = $wpdb->get_row("SHOW TABLE STATUS LIKE '" . $tablename . "'");
        $_SESSION['last_id'] = $autoincreement;
    }



    wp_die();
}
