<?php

class SessionManagementController {
	
	function __construct($sessionPath) {
		session_set_cookie_params(0, $sessionPath);
		if (!session_id()) {
			session_regenerate_id(true);
			session_start();
		}
	}
	
	function UpdateActivity() {
		if (isset($_SESSION['last_activity']))
			$_SESSION['last_activity'] = time();
	}

	function VerifyActivity() {
		if (!isset($_SESSION['authenticated_id']) || !isset($_SESSION['authenticated_email']) || !isset($_SESSION['last_activity'])) {
			$this->RemoveActivity();
			header('Location: ../index.php?timeoutStatus=0');
			exit();
		}
		else {
			if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 900)) {
				$this->RemoveActivity();
				header('Location: ../index.php?timeoutStatus=1');
				exit();
			}
			$this->UpdateActivity();
		}
	}
	
	function RemoveActivity() {
		session_unset();
		session_destroy();
	}
	
	function CheckValidPage($redirectURL, $authenticated) {
		if ($authenticated) {
			if (!isset($_SESSION['authenticated_id']) || !isset($_SESSION['authenticated_email']) || !isset($_SESSION['last_activity'])) {
				header('Location: '.$redirectURL);
				exit();
			}
		}
		else {
			if (!(!isset($_SESSION['authenticated_id']) || !isset($_SESSION['authenticated_email']) || !isset($_SESSION['last_activity']))) {
				header('Location: '.$redirectURL);
				exit();
			}			
		}
	}
	
}