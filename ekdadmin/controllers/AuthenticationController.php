<?php
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../controllers/SessionManagementController.php';
require_once __DIR__.'/../models/CustomerModel.php';
require_once __DIR__.'/../models/EmployeeModel.php';

class AuthenticationController {

	private $userEmail;
	private $userPassword;
	
	function __construct($userEmail, $userPassword) {
		$this->userEmail = $userEmail;
		$this->userPassword = $userPassword;
	}
		
	function Authenticate($privilegeLevel) {
		$authenticateResult = null;
		$customer = new CustomerModel();
		$employee = new EmployeeModel();
		$emailResult = $this->VerifyEmailValidity();
		$passwordResult = $this->VerifyPasswordValidity();
		$captchaResult = $this->VerifyreCAPTCHAValidity();
		
		if (!$emailResult)
			return 1;
		else if (!$passwordResult)
			return 2;
		else if (!$captchaResult)
			return 3;
			
		if ($privilegeLevel == 0)
			$authenticateResult = $customer->CheckUserCredentials($this->userEmail, $this->userPassword);
		else if ($privilegeLevel == 1)
			$authenticateResult = $employee->CheckUserCredentials($this->userEmail, $this->userPassword);
		
		if ($authenticateResult != null) {
			$sessionManager = new SessionManagementController(SESSION_COOKIE_PATH);
			$_SESSION['last_activity'] = time();
			if ($privilegeLevel == 0) {
				$_SESSION['authenticated_id'] = $customer->GetCustomerAuthID();
				$_SESSION['authenticated_email'] = $customer->GetCustomerAuthEmail();
			}
			else if ($privilegeLevel == 1) {
				$_SESSION['authenticated_id'] = $employee->GetEmployeeAuthID();
				$_SESSION['authenticated_email'] = $employee->GetEmployeeAuthEmail();
			}
			return 0;
		}
		else {
			return 4;
		}
	}
	
	function VerifyEmailValidity() {
		if (filter_var($this->userEmail, FILTER_VALIDATE_EMAIL))
			return true;
		return false;
	}
	
	function VerifyPasswordValidity() {
		if (preg_match(PATTERN_PASSWORD, $this->userPassword))
			return true;
		return false;
	}
	
	function VerifyreCAPTCHAValidity() {
		if (isset($_POST['g-recaptcha-response']) && $_POST['g-recaptcha-response']) {
			$url = 'https://www.google.com/recaptcha/api/siteverify?secret='.RECAPTCHA_SERVER_KEY.'&response='.$_POST['g-recaptcha-response'].'&$remoteip='.$_SERVER['REMOTE_ADDR'];
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$response = curl_exec($ch);
			curl_close($ch);
			
			$result = json_decode($response, true);
			if (isset($result['success']) && $result['success'])
				return true;
			else
				return false;
		}
		else {
			return false;
		}
	}
}