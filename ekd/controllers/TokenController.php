<?php
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../controllers/SessionManagementController.php';

class TokenController {
	
	static function GenerateToken() {
		$sessionManager = new SessionManagementController(SESSION_COOKIE_PATH);
		if (empty($_SESSION['token'])) {
			if (function_exists('mcrypt_create_iv'))
				$_SESSION['token'] = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
			else
				$_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));
		}
		return $_SESSION['token'];
	}
	
	static function VerifyTokenValidity() {
		$sessionManager = new SessionManagementController(SESSION_COOKIE_PATH);
		if (!empty($_POST['txtToken']) && !empty($_SESSION['token'])) {
			if (hash_equals($_POST['txtToken'], $_SESSION['token']))
				return true;
			else
				return false;
		}
		return false;
	}
}