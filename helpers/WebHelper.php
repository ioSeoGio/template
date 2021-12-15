<?php

namespace app\helpers;

class WebHelper {

	public static function isExternal(string $url) 
	{
		$components = parse_url($url);

		if (empty($components['host'])) {
			return false;  // we will treat url like '/relative.php' as relative	
		} 

		if (strcasecmp($components['host'], 'example.com') === 0) {
			return false; // url host looks exactly like the local host 
		} 

  		return strrpos(strtolower($components['host']), '.example.com') !== strlen($components['host']) - strlen('.example.com'); // check if the url host is a subdomain
	}
}