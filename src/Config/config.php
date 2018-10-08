<?php

function facebookFanPageOptions()
{	
	return [
		'article' => [
			'version' => '', //your facebook graph api version
			'pageID' => '', //your facebook fan page ID
			'pageToken' => '', //your facebook fan page Token
			'utc' => 8 //Universal Time Coordinated
		],
		'instant_article' => [
			'version' => '', //your facebook graph api version
			'pageID' => '', //your facebook fan page ID
			'pageToken' => '', //your facebook fan page Token
		],
	];
}

?>