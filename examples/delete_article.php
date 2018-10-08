<?php

require_once __DIR__."/../vendor/autoload.php";

use Facebook\FanPage\FacebookFanPage;

$options = facebookFanPageOptions()['article'];

$pages = new FacebookFanPage($options);

$postID = isset($_GET['postID']) && !empty($_GET['postID']) ? $_GET['postID'] : '';

$response = $pages->deleteArticle($postID);

echo $response;

?>