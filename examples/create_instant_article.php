<?php

require_once __DIR__."/../vendor/autoload.php";

use Facebook\FanPage\FacebookFanPage;

$option = facebookFanPageOptions()['instant_article'];

$pages = new FacebookFanPage($option);

$html_source = '<!doctype html>
        <html>
            <head>
                  <meta charset="utf-8">
                  <meta property="op:markup_version" content="v1.0">
        
                <!-- The URL of the web version of your article --> 
                <link rel="canonical" href="http://my.domain/instant_article.html">
          
                <!-- The style to be used for this article --> 
                <meta property="fb:article_style" content="myarticlestyle">
            </head>
            <body>
                <article>
                    <!-- Body text for your article -->
                    <p> This is some Instant Article content. </p> 
                </article>
            </body>
        </html>';

$response = $pages->createInstantArticle($html_source);

echo $response;