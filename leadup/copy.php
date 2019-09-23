<?php

session_start();
require(plugin_dir_path(__FILE__) . 'class-leads.php');
global $wpdb;
$tablename = $wpdb->prefix . 'leads_dynamicform';
$last = $wpdb->get_row("SHOW TABLE STATUS LIKE '" . $tablename . "'");
$_SESSION['last_id'] = $last->Auto_increment;
//echo $_SESSION['last_id'];
$a = new LeadsSetData();
$keyup_check = '';

add_action('wp_ajax_add_foobar', 'add_foobar');
add_action('wp_ajax_nopriv_add_foobar', 'add_foobar');

function add_foobar() {
// Handle request then generate response using WP_Ajax_Response
// Don't forget to stop execution afterward.
    global $wpdb, $leads_dynamicform;
    $id = $_POST['session'];
    
//    var_dump(json_encode($id));
    
    echo $_POST['name'];
    
//s    $data = $wpdb->get_row('SELECT * FROM wp_options WHERE option_id = ' . $id, ARRAY_A);
//    echo json_encode($data);
//    wp_die(); // just to be safe
//    $a->set_lead_name($_POST['Name']);

    $tablename = $wpdb->prefix . 'leads_dynamicform';
    $last = $wpdb->get_row("SHOW TABLE STATUS LIKE '" . $tablename . "'");
//    if ($_SESSION['last_id'] == ($last->Auto_increment - 1)) {
//        echo 'hello';
//    } else {
    $query = $wpdb->insert($tablename, array(
        'name' => $_SESSION['name'],
        'leadform1' => $_SESSION['name'],
        'leadform2' => $_SESSION['name'],
        'leadform3' => $_SESSION['name'],
        'leadform4' => $_SESSION['name'],
        'leadform5' => $_SESSION['name'],
        'leadform6' => $_SESSION['name'],
        'leadform7' => $_SESSION['name'],
        'leadform8' => $_SESSION['name'],
        'leadform9' => $_SESSION['name'],
        'date' => date('Y-m-d'),
        'rand_value' => ''
    ));
//    }
//    print_r('ksjdhfkjsdf');
    ?>
    <?php

//    $sql = "SELECT * FROM $leads_dynamicform WHERE  rand_value =$this->randvalue";
//    $value = $wpdb->get_row($sql);
    echo 'lasjfkdjf';

    wp_die();
}
