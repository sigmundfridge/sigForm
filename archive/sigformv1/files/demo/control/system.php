<?php 
class SystemComponent 
	{ 
	var $settings; 
	function getSettings() 
		{ 
		// System variables 
		$settings['siteDir'] = null;
		$settings['domain'] = "http://" . $_SERVER["HTTP_HOST"]; // Root Domain - http://example.com
		$settings['siteName'] = "sigfrid";
		$settings['siteEmail'] = "nick@sigfrid.co.uk";
		return $settings; 
		} 
	} 
?> 