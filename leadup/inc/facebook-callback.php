<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
$_SESSION['url'] = $_SERVER['REQUEST_URI']; // i.e. "about.php"
# fb-login-callback.php
//require(plugin_dir_path(__FILE__) . 'Facebook\autoload.php');
$fb = new Facebook\Facebook([
    'app_id' => '428446340696472',
    'app_secret' => 'f1ac69f0db10e5ebf88e1d31a5d92b66',
    'default_graph_version' => 'v2.3',
        ]);

$helper = $fb->getRedirectLoginHelper();
try {
    $accessToken = $helper->getAccessToken();
} catch (Facebook\Exceptions\FacebookSDKException $e) {
    // There was an error communicating with Graph
    echo $e->getMessage();
    exit;
}

if (isset($accessToken)) {
    // User authenticated your app!
    // Save the access token to a session and redirect
    $_SESSION['facebook_access_token'] = (string) $accessToken;
    // Log them into your web framework here . . .
    // Redirect here . . .
    // echo $_SESSION['facebook_access_token'];
    //echo $accessToken;
    //exit;
} elseif ($helper->getError()) {
    // The user denied the request
    // You could log this data . . .
    var_dump($helper->getError());
    var_dump($helper->getErrorCode());
    var_dump($helper->getErrorReason());
    var_dump($helper->getErrorDescription());
    // You could display a message to the user
    // being all like, "What? You don't like me?"
    exit;
}

//$fb->setDefaultAccessToken($accessToken);
# These will fall back to the default access token
//$res = $fb->get('/me');
//print_r($res);
//$res = $fb->post('/me/feed', $data);
//$res = $fb->delete('/123', $data);
// If they've gotten this far, they shouldn't be here
//http_response_code(400);

$curl_handle = curl_init();
curl_setopt($curl_handle, CURLOPT_URL, "https://graph.facebook.com/me?fields=picture,friends,likes,tagged_places,friendlists,albums,books,games,movies,music,television,videos,feed,location,email,bio,birthday,currency,devices,education,favorite_athletes,install_type,installed,interested_in,is_verified,languages,meeting_for,middle_name,name_format,payment_pricepoints,test_group,political,relationship_status,religion,security_settings,significant_other,sports,quotes,third_party_id,video_upload_limits,viewer_can_send_gift,website,work,public_key,cover,favorite_teams,hometown,inspirational_people,id,about,address,name,first_name,last_name,age_range,link,gender,locale,timezone,updated_time,verified&access_token=" . $accessToken);
curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl_handle, CURLOPT_USERAGENT, 'fb');
curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl_handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
# Return response instead of printing.
$query = curl_exec($curl_handle);
curl_close($curl_handle);
//print_r($query);
echo "<pre>";
print_r(json_decode($query));
echo "</pre>";
exit;

//https://graph.facebook.com/me/?fields=is,name,first_name,last_name &access_token=