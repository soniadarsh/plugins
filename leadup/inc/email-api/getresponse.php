<?php

# Demonstrates how to add new contact to campaign.
# JSON::RPC module is required
# available at http://github.com/GetResponse/DevZone/blob/master/API/lib/jsonRPCClient.php
include plugin_dir_path(__FILE__) . 'GetResponse/jsonRPCClient.php';

use GetResponse\jsonRPCClient;

//use Exception;
//use GetResponse\RuntimeException;
# your API key is available at
# https://app.getresponse.com/my_api_key.html
$api_key = get_option('getresponse-api-key');
//echo $api_key;
# API 2.x URL
$api_url = 'http://api2.getresponse.com';
# initialize JSON-RPC client
$client = new jsonRPCClient($api_url);
# find campaign named 'test'
try {
    $campaigns = $client->get_campaigns(
            $api_key, array(
        # find by name literally
        'name' => array('EQUALS' => get_option('getresponse-list-name'))
            )
    );
} catch (Exception $e) {
    # check for communication and response errors
    # implement handling if needed
    die($e->getMessage());
}
# uncomment following line to preview Response
# print_r($campaigns);
# because there can be only one campaign of this name
# first key is the CAMPAIGN_ID required by next method
# (this ID is constant and should be cached for future use)
$CAMPAIGN_ID = array_keys($campaigns);
$CAMPAIGN_ID = array_pop($CAMPAIGN_ID);
$name = $_POST['Name'];
$email = $_POST['Email'];

$domain = substr(strrchr($email, "@"), 1);

$domain_status = checkdnsrr($domain, 'MX');

if ($domain_status == true) {
    try {
        $contacts = $client->get_contacts(
                $api_key, array(
            'campaigns' => array($CAMPAIGN_ID),
                )
        );

        $status = 0;
        foreach ($contacts as $contact) {
            if ($contact['email'] == $email) {
                $status++;
            }
        }
    } catch (Exception $e) {
        # check for communication and response errors
        # implement handling if needed
        die($e->getMessage());
    }

# add contact to the campaign
    if ($status == 0) {
        $result = $client->add_contact(
                $api_key, array(
            # identifier of 'test' campaign
            'campaign' => $CAMPAIGN_ID,
            # basic info
            'name' => $_POST['Name'],
            'email' => $_POST['Email'],
                )
        );
    }
}