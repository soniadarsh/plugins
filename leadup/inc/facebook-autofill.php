<style type="text/css">
    .inklead-facebook-btn{
        background-image: url(<?php echo plugins_url('images/facebook_button_icon.png', dirname(__FILE__)) ?>);
        background-image: url(<?php echo plugins_url('images/facebook_button_icon.svg', dirname(__FILE__)) ?>);
    }
</style>
<?php
if (!session_id()) {
    session_start();
}
if (!isset($_GET['code'])) {

    //require(plugin_dir_path(__FILE__) . 'Facebook/autoload.php');
    $fb = new Facebook\Facebook([
        'app_id' => get_option('facebook-app-id'),
        'app_secret' => get_option('facebook-app-secret'),
        'default_graph_version' => 'v2.3',
    ]);
    $helper = $fb->getRedirectLoginHelper();
    $accessToken = $helper->getAccessToken();
    if (isset($accessToken)) {
// User authenticated your app!
// Save the access token to a session and redirect
        $_SESSION['facebook_access_token'] = (string) $accessToken;
        $accesstoken = $_SESSION['facebook_access_token'];
    }
    $permissions = ['email', 'public_profile', 'user_friends']; // optional
    if (is_home()) {
        $callback = home_url('/');
        $_SESSION['callback'] = $callback;
    } else {
        $callback = get_permalink();
        $_SESSION['callback'] = $callback;
    }
//    echo $callback;
    $loginUrl = $helper->getLoginUrl($callback, $permissions);
    $_SESSION['loginurl'] = $loginUrl;
    echo '<a class="inklead-facebook-btn" href="' . $_SESSION['loginurl'] . '">Fill with Facebook!</a>';
} else {
# fb-login-callback.php
    //require(plugin_dir_path(__FILE__) . 'Facebook/autoload.php');
    $fb = new Facebook\Facebook([
        'app_id' => get_option('facebook-app-id'),
        'app_secret' => get_option('facebook-app-secret'),
        'default_graph_version' => 'v2.3',
    ]);
    $helper = $fb->getRedirectLoginHelper();
    $_SESSION['FBRLH_state'] = $_GET['state'];
    try {
        $accessToken = $helper->getAccessToken();
//        echo $accessToken;
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
    } elseif ($helper->getError()) {
        // The user denied the request
        // You could log this data . . .
//        var_dump($helper->getError());
//        var_dump($helper->getErrorCode());
//        var_dump($helper->getErrorReason());
//        var_dump($helper->getErrorDescription());
        // You could display a message to the user
        // being all like, "What? You don't like me?"
        exit;
    }
    if (isset($_SESSION['facebook_access_token'])) {
//        echo 'hello';
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, "https://graph.facebook.com/me?fields=email,name&access_token=" . $accessToken);
        curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_handle, CURLOPT_USERAGENT, 'fb');
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl_handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
# Return response instead of printing.
        $query = curl_exec($curl_handle);
        curl_close($curl_handle);
        $fb_data = json_decode($query);
//        echo "<pre>";
//        print_r(json_decode($query));
//        echo "</pre>";
        echo '<a class="inklead-facebook-btn" href="' . $_SESSION['loginurl'] . '">Fill with Facebook!</a>';
        return $fb_data;
    }
}
