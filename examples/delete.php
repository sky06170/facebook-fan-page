<?php

require_once __DIR__."/../vendor/autoload.php";

use FacebookFanPage\FacebookFanPage;

$options = facebookFanPageOptions();

$pages = new FacebookFanPage($options);

$postID = isset($_GET['postID']) && !empty($_GET['postID']) ? $_GET['postID'] : '';

$response = $pages->delete($postID);

echo $response;

?>