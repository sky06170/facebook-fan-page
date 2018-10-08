<?php

require_once __DIR__."/../vendor/autoload.php";

use Facebook\FanPage\FacebookFanPage;

$options = facebookFanPageOptions()['article'];

$pages = new FacebookFanPage($options);

$message = 'test publish!'.'('.uniqid().')';

$response = $pages->publishArticle($message);

echo $response;

?>