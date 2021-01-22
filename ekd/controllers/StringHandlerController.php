<?php

class StringHandlerController {
	
	function RemoveQueryParam($url, $varname) {
	    $parsedUrl = parse_url($url);
	    $query = array();
	
	    if (isset($parsedUrl['query'])) {
	        parse_str($parsedUrl['query'], $query);
	        unset($query[$varname]);
	    }
		
	    $port = isset($parsedUrl['port']) ? ':'.$parsedUrl['port'] : '';
	    $path = isset($parsedUrl['path']) ? $parsedUrl['path'] : '';
	    $query = !empty($query) ? '?'. http_build_query($query) : '';
	
	    return $parsedUrl['scheme'].'://'.$parsedUrl['host'].$port.$path.$query;
	}
		
	static function AddQueryParam($url, $key, $value) {
		$separator = (parse_url($url, PHP_URL_QUERY) == NULL) ? '?' : '&';
	
		$query = $key."=".$value;
		$url .= $separator.$query;
		return $url;
	}
	
}