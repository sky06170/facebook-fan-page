facebook-fan-page
=======================

## Installing

Install Composer

```bash
curl -sS https://getcomposer.org/installer | php
```

Install facebook-fan-page:

```bash
php composer.phar require sky06170/facebook-fan-page
```

require Composer's autoloader:

```php
require 'vendor/autoload.php';
```


## Config

setting src/Config/config.php

```php
return [

		'version' => 'v2.12', //your facebook graph api version

		'pagesID' => '', //your facebook fan page ID

		'pagesToken' => '' //your facebook fan page Token

	];
```

## Example

publish

```php
use Facebook\FanPage\FacebookFanPage;

$options = facebookFanPageOptions();

$pages = new FacebookFanPage($options);

$message = 'test publish';

$response = $pages->publish($message);
```

delete

```php
use Facebook\FanPage\FacebookFanPage;

$options = facebookFanPageOptions();

$pages = new FacebookFanPage($options);

$postID = isset($_GET['postID']) && !empty($_GET['postID']) ? $_GET['postID'] : '';

$response = $pages->delete($postID);
```
