<?php
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../controllers/SessionManagementController.php';
require_once __DIR__.'/../controllers/StatusMessageController.php';
require_once __DIR__.'/../controllers/StringHandlerController.php';
require_once __DIR__.'/../controllers/TokenController.php';
require_once __DIR__.'/../models/ItemFeedbackModel.php';

$sessionManager = new SessionManagementController(SESSION_COOKIE_PATH);
$sessionManager->CheckValidPage('../index.php', true);
$sessionManager->VerifyActivity();
$tokenResult = TokenController::VerifyTokenValidity();

$redirectURL = StatusMessageController::GetCleanRedirectURL();
$feedback = new ItemFeedbackModel($_POST['txtItemID']);

if (isset($_POST['btnPostFeedback']) && $tokenResult) {
	$feedbackMessage = filter_var($_POST['txtFeedback'], FILTER_SANITIZE_STRING);
	if (strlen($feedbackMessage) >= 10 && preg_match(PATTERN_FEEDBACKMESSAGE, $feedbackMessage)) {
		$feedback->SubmitFeedback($_POST['txtUserID'], $feedbackMessage);
		$redirectURL = StringHandlerController::AddQueryParam($redirectURL, 'addFeedbackStatus', '0');
	}
	else { 
		$redirectURL = StringHandlerController::AddQueryParam($redirectURL, 'addFeedbackStatus', '1');
	}
}
else if (isset($_POST['btnDeleteFeedback']) && $tokenResult) {
	$feedback->DeleteFeedback($_POST['txtFeedbackID']);
}

header('Location: '.$redirectURL);
