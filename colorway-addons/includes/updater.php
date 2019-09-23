<?php

//set_site_transient('update_plugins', null);

// Take over the update check
add_filter('pre_set_site_transient_update_plugins', 'colorway_addons_check_update');

function colorway_addons_check_update($checked_data) {
	global $wp_version;

	$ep_api_url = 'https://inkthemes.co/updates/';
	
	//Comment out these three lines during testing.
	if ( empty( $checked_data->response ) ) {
		return $checked_data;
	}

	$args = array(
		'slug'    => INKCA_PNAME,
		'version' => INKCA_VER,
	);
	$request_string = array(
			'body' => array(
				'action'  => 'basic_check', 
				'request' => serialize($args),
				'api-key' => md5(get_bloginfo('url'))
			),
			'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo('url')
		);

	// Start checking for an update
	$raw_response = wp_remote_post($ep_api_url, $request_string);
	
	if (!is_wp_error($raw_response) && ($raw_response['response']['code'] == 200)) {
		$response = unserialize($raw_response['body']);
	}

	if ( !empty($response) && is_object($response)) { // Feed the update data into WP updater
		$checked_data->response[INKCA_PNAME.'/'.INKCA_PNAME.'.php'] = $response;
	}

	return $checked_data;
}


// Take over the Plugin info screen
add_filter('plugins_api', 'colorway_addons_api_call', 10, 3);

function colorway_addons_api_call($def, $action, $args) {
	global $wp_version;
	$ep_api_url = 'https://inkthemes.co/updates/';
	
	if (!isset($args->slug) || ($args->slug != INKCA_PNAME))
		return false;
	
	// Get the current version
	$plugin_info     = get_site_transient('update_plugins');
	$current_version = $plugin_info->checked[INKCA_PNAME.'/'.INKCA_PNAME.'.php'];
	$args->version   = $current_version;
	
	$request_string = array(
			'body' => array(
				'action' => $action, 
				'request' => serialize($args),
				'api-key' => md5(get_bloginfo('url'))
			),
			'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo('url')
		);
	
	$request = wp_remote_post($ep_api_url, $request_string);
	
	if (is_wp_error($request)) {
		$res = new WP_Error('plugins_api_failed', __('An Unexpected HTTP Error occurred during the API request.</p> <p><a href="?" onclick="document.location.reload(); return false;">Try again</a>'), $request->get_error_message());
	} else {
		$res = unserialize($request['body']);
		
		if ($res === false)
			$res = new WP_Error('plugins_api_failed', __('An unknown error occurred'), $request['body']);
	}
	
	return $res;
}