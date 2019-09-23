<?php

require_once('mailget_curl.php');
$mailget_key = get_option('mailget-api-key');
$send_val = 'multiple';/** For sending autoresponder use $send_val='single' * */
$mailget_obj = new mailget_curl($mailget_key);
$list_arr = $mailget_obj->get_list_in_json($mailget_key);
$list_id = '';

/* To add emails in list */

if (!empty($list_arr)) {
    foreach ($list_arr as $list_arr_row) {
        if ($list_arr_row->list_name == get_option('mailget-list-name')) {
            $list_id = $list_arr_row->list_id;
        }
    }
//    echo '<pre>';
//    print_r($_POST);
//    echo '<pre>';
    $mailget_arr = array(array(
            'name' => $_POST['Name'],
            'email' => $_POST['Email'],
            'get_date' => get_the_time('M, d, Y'),
            'ip' => $_SERVER['REMOTE_ADDR']
        ),
        array(
            'name' => 'XYZ',
            'email' => 'xyz@gmail.comas',
            'get_date' => '20-15-1996',
            'ip' => '10.10.10.10'
        )
    );
    if ($list_id != '') {
        $curl_status = $mailget_obj->curl_data($mailget_arr, $list_id, $send_val);
    }
}