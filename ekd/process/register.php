<?php
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../controllers/RegistrationController.php';
require_once __DIR__.'/../controllers/SessionManagementController.php';
require_once __DIR__.'/../controllers/StatusMessageController.php';
require_once __DIR__.'/../controllers/StringHandlerController.php';
require_once __DIR__.'/../controllers/TokenController.php';

$sessionManager = new SessionManagementController(SESSION_COOKIE_PATH);
$sessionManager->CheckValidPage('../index.php', false);
$tokenResult = TokenController::VerifyTokenValidity();

if (isset($_POST['btnRegister']) && $tokenResult) {
	$registration = new RegistrationController($_POST['txtEmail'], 
											   $_POST['txtPassword'],
											   $_POST['txtPassword2'],
											   $_POST['txtFirstName'], 
									 		   $_POST['txtLastName'], 
									 		   $_POST['txtMobileNumber'], 
									 		   $_POST['txtDOB'], 
									 		   $_POST['txtAddress']);
	$registration->SaveRegistrationFields();
	$registerResult = $registration->Register();
	if ($registerResult == 0) {
		$registration->DestroySavedRegistrationFields();
	}
	
	$redirectURL = StatusMessageController::GetCleanRedirectURL();
	$redirectURL = StringHandlerController::AddQueryParam($redirectURL, 'registerStatus', $registerResult);
	header('Location: '.$redirectURL);
	exit();
}

header('Location: ../index.php');