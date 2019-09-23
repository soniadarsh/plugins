<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use GetResponse\jsonRPCClient;
use GetResponse\GetResponse;

$api_key = 'e0be0b3f752b2b28abed8dae9e691c4f';
$api_url = 'http://api2.getresponse.com';

$client = new jsonRPCClient($api_url);

$client = new jsonRPCClient($api_url);
$campaigns = $client->get_campaigns($api_key);
echo "<pre>";
print_r($campaigns);
echo "</pre>";

$campaigns = $client->get_campaigns(
        $api_key, [
    'name' => [ 'EQUALS' => 'leadnew']
        ]
);
echo "<pre>";
print_r($campaigns);
echo "</pre>";

$api = new GetResponse($gp_api_key);
$api->addContact($list_id, $full_name, $email, 'insert', 0, ['name' => $full_name]);
