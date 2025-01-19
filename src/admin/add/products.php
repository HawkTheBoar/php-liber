<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/add/addTemplate.php";
$config = loadJson($_SERVER['DOCUMENT_ROOT'] . "/admin/config.json");
$addPath = "/admin/add/products.php";
$siteName = 'products';
if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    AddTemplate::handlePost($siteName, $config, $addPath);
}
else{
    AddTemplate::handleGet($siteName, $config, $addPath);
    
}