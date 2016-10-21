<?php

//shopify credentials
define(API_KEY, "36db000985409daca6b62af6209d139b");
define(PASSWORD, "58107093f37390aa6fb1f18c4a0a3061");
define(STORE_URL, "smichal-shop.myshopify.com");


//posts $data to $url after json encoding
function postDataToUrl($url, $data) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 1);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_VERBOSE, 0);
    curl_setopt($curl, CURLOPT_HEADER, 1);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec ($curl);
    curl_close ($curl);
	return $response;
}