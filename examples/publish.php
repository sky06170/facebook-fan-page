<?php

require_once __DIR__."/../vendor/autoload.php";

use FacebookFanPage\FacebookFanPage;

$options = facebookFanPageOptions();

$pages = new FacebookFanPage($options);

$message = 'test publish!'.'('.uniqid().')';

$response = $pages->publish($message);

echo $response;

?>