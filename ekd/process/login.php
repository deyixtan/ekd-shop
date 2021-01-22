<?php
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../controllers/AuthenticationController.php';
require_once __DIR__.'/../controllers/StatusMessageController.php';
require_once __DIR__.'/../controllers/StringHandlerController.php';
require_once __DIR__.'/../controllers/SessionManagementController.php';

$sessionManager = new SessionManagementController(SESSION_COOKIE_PATH);
$sessionManager->CheckValidPage('../index.php', false);

if (isset($_POST['btnLogin'])) {
	$auth = new AuthenticationController($_POST['txtEmail'], $_POST['txtPassword']);
	$authResult = $auth->Authenticate(0);
	
	$redirectURL = StatusMessageController::GetCleanRedirectURL();
	$redirectURL = StringHandlerController::AddQueryParam($redirectURL, 'loginStatus', $authResult);
	
	header('Location: '.$redirectURL);
	exit();
}

header('Location: ../index.php');