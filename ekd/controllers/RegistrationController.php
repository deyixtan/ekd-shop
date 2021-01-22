<?php
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../controllers/SessionManagementController.php';
require_once __DIR__.'/../models/CustomerModel.php';

class RegistrationController {

	private $userEmail;
	private $userPassword;
	private $userPassword2;
	private $userFirstName;
	private $userLastName;
	private $userMobileNumber;
	private $userDOB;
	private $userAddress;	
	
	function __construct($userEmail, $userPassword, $userPassword2, $userFirstName, $userLastName, $userMobileNumber, $userDOB, $userAddress) {
		$this->userEmail = $userEmail;
		$this->userPassword = $userPassword;
		$this->userPassword2 = $userPassword2;
		$this->userFirstName = $userFirstName;
		$this->userLastName = $userLastName;
		$this->userMobileNumber = $userMobileNumber;
		$this->userDOB = $userDOB;
		$this->userAddress = $userAddress;
	}
	
	function Register() {
		$emailResult = $this->VerifyEmailValidity();
		$passwordMatchResult = $this->VerifyPasswordMatchValidity();
		$passwordResult = $this->VerifyPasswordValidity();
		$firstNameResult = $this->VerifyFirstNameValidity();
		$lastNameResult = $this->VerifyLastNameValidity();
		$mobileNumberResult = $this->VerifyMobileNumberValidity();
		$dobResult = $this->VerifyDOBValidity();
		$addressResult = $this->VerifyAddressValidity();
		
		if (!$emailResult)
			return 1;
		else if (!$passwordMatchResult)
			return 2;
		else if (!$passwordResult)
			return 3;
		else if (!$firstNameResult)
			return 4;
		else if (!$lastNameResult)
			return 5;
		else if (!$mobileNumberResult)
			return 6;
		else if (!$dobResult)
			return 7;
		else if (!$addressResult)
			return 8;
		
		$customer = new CustomerModel();
		$registrationResult = $customer->RegisterUser($this->userEmail, 
													  $this->userPassword,
													  $this->userPassword2,
													  $this->userFirstName,
													  $this->userLastName,
													  $this->userMobileNumber,
													  $this->userDOB,
													  $this->userAddress);
	
		if ($registrationResult == 0)
			return 0;
		else if ($registrationResult == 1)
			return 9;
		else if ($registrationResult == 2)
			return 10;
	}
	
	function VerifyEmailValidity() {
		if (filter_var($this->userEmail, FILTER_VALIDATE_EMAIL))
			return true;
		return false;
	}
	
	function VerifyPasswordMatchValidity() {
		if ($this->userPassword == $this->userPassword2)
			return true;
		return false;
	}
	
	function VerifyPasswordValidity() {
		if (preg_match(PATTERN_PASSWORD, $this->userPassword))
			return true;
		return false;
	}
	
	function VerifyFirstNameValidity() {
		if (preg_match(PATTERN_NAME, $this->userFirstName))
			return true;
		return false;
	}
	
	function VerifyLastNameValidity() {
		if (preg_match(PATTERN_NAME, $this->userLastName))
			return true;
		return false;
	}
	
	function VerifyMobileNumberValidity() {
		if (preg_match(PATTERN_MOBILENUMBER, $this->userMobileNumber))
			return true;
		return false;
	}
	
	function VerifyDOBValidity() {
		if (preg_match(PATTERN_DOB, $this->userDOB))
			return true;
		return false;
	}
	
	function VerifyAddressValidity() {
		if (preg_match(PATTERN_ADDRESS, $this->userAddress))
			return true;
		return false;
	}
	
	function SaveRegistrationFields() {
		$sessionManager = new SessionManagementController(SESSION_COOKIE_PATH);
		$_SESSION['registerEmail'] = $this->userEmail;
		$_SESSION['registerPassword'] = $this->userPassword;
		$_SESSION['registerFirstName'] = $this->userFirstName;
		$_SESSION['registerLastName'] = $this->userLastName;
		$_SESSION['registerMobileNumber'] = $this->userMobileNumber;
		$_SESSION['registerDOB'] = $this->userDOB;
		$_SESSION['registerAddress'] = $this->userAddress;
	}
	
	function DestroySavedRegistrationFields() {
		$sessionManager = new SessionManagementController(SESSION_COOKIE_PATH);
		$_SESSION['registerEmail'] = '';
		$_SESSION['registerPassword'] = '';
		$_SESSION['registerFirstName'] = '';
		$_SESSION['registerLastName'] = '';
		$_SESSION['registerMobileNumber'] = '';
		$_SESSION['registerDOB'] = '';
		$_SESSION['registerAddress'] = '';
	}
}