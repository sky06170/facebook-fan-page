<?php

require_once __DIR__."/../vendor/autoload.php";

use Facebook\Pages\FacebookPages;

$version = '{your facebook graph api version}';

$pagesID = '{your facebook fans page ID}';

$pagesToken = '{your facebook fans page Token}';

$pages = new FacebookPages($version,$pagesID,$pagesToken);

$postID = isset($_GET['postID']) && !empty($_GET['postID']) ? $_GET['postID'] : '';

$response = $pages->delete($postID);

echo $response;

?>