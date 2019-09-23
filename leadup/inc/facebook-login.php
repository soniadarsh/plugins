<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

session_start();
//require(plugin_dir_path(__FILE__) . 'Facebook\autoload.php');
$fb = new Facebook\Facebook([
    'app_id' => '428446340696472',
    'app_secret' => 'f1ac69f0db10e5ebf88e1d31a5d92b66',
    'default_graph_version' => 'v2.3',
        ]);
$helper = $fb->getRedirectLoginHelper();
$permissions = ['user_birthday', 'user_religion_politics', 'user_relationships', 'user_relationship_details', 'user_hometown', 'user_location', 'user_likes', 'user_education_history', 'user_work_history', 'user_website', 'user_managed_groups', 'user_events', 'user_photos', 'user_videos', 'user_friends', 'user_about_me', 'user_status', 'user_games_activity', 'user_tagged_places', 'user_posts', 'read_page_mailboxes', 'rsvp_event', 'email', 'ads_management', 'ads_read', 'read_insights', 'manage_pages, publish_pages', 'publish_actions', 'read_audience_network_insights', 'read_custom_friendlists', 'user_actions.video', 'user_actions.news', 'user_actions.books', 'user_actions.music', 'user_actions.fitness', 'public_profile']; // optional
$callback = 'http://localhost/wordpress-testing/blog.php';
$loginUrl = $helper->getLoginUrl($callback, $permissions);

echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';
