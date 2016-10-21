<?php

//credentials and utils
require 'config.php';
$action = $_GET['action'];


### new product ###
if ($action == "save") {
    //fails if data not valid
    if (!validateData($_POST)) die('fail1');
    //prepare data for the shopify API
    $data = formatData($_POST);
    //post them to shopify
    $url  = "https://".API_KEY.":".PASSWORD."@".STORE_URL."/admin/products.json";
    echo postDataToUrl($url, $data);
}




############## FUNCTIONS ########################################################

//checks if data to create new product are valid
function validateData($data) {
    //generic validations
    if (strlen($data['title']) < 3) return false;
    if (strlen($data['description']) < 3) return false;
    if (strlen($data['type']) < 3) return false;
    if (strlen($data['vendor']) < 3) return false;
    //special validations
    if (!validateSKU($data['sku'])) return false;
    if (!validatePrice($data['price'])) return false;
    if ($data['imgOption'] == "useFile" && !validateImgFile($data['imageFile'])) return false;
    if ($data['imgOption'] == "useUrl"  && !validateImgUrl($data['imageUrl'])) return false;
    //nothing invalid
    return true;
}

//return whether $str is a valid SKU
function validateSKU($str) {
    return preg_match('/^\w+$/i', $str)||$str=="";
}

//return whether $str is a valid Price
function validatePrice($str) {
    if (!is_numeric($str)) return false;
    $price = floatval($str);
    return ($price >= 0 && $price <= 999999);
}

//return whether $str is a valid Image file (simple check by header)
function validateImgFile($str) {
    $header = explode(",",$str)[0]; 
    $type   = explode("/",$header)[0];
    return ($type == "data:image");
}

//return whether $str is a valid Image url
function validateImgUrl($str) {
    if (@getimagesize($str)) return true;
    else                     return false;
}

//formats data to be compatible with shopify API
function formatData($data) {
    //strip header from image data
    $img64 = explode(",",$data['imageFile'])[1]; 
    //image file or URL
    if ($data['imgOption'] == "useFile") {
        $img64 = explode(",",$data['imageFile'])[1];//strip header
        $img   = array('attachment' => $img64);
    } else $img = array('src' => $data['imageUrl']);
    //default variant
    $variant = array(
        'sku'    => trim($data['sku']),
        'price'  => trim($data['price'])
    );
    //create data array
    $fdata = array(
        'product' => array(
            'title'         => trim($data['title']),
            'body_html'     => '<strong>'.$data['description'].'</strong>',
            'vendor'        => trim($data['vendor']),
            'product_type'  => $data['type'],
            'images'        => array($img),
            'variants'      => array($variant)
        )
    );
    return $fdata;
}