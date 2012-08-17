<?php 
class SystemComponent 
	{ 
	var $settings; 
	function getSettings() 
		{ 
		// System variables 
			$settings['domain'] = "http://" . $_SERVER["HTTP_HOST"]; // Root Domain - http://example.com
			$settings['siteName'] = "";
			$settings['siteEmail'] = "";
		return $settings; 
		} 
	} 
?> 