<?php
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../controllers/SessionManagementController.php';
require_once __DIR__.'/../controllers/StatusMessageController.php';
require_once __DIR__.'/../controllers/StringHandlerController.php';
require_once __DIR__.'/../controllers/TokenController.php';
require_once __DIR__.'/../models/CreditCardModel.php';

$sessionManager = new SessionManagementController(SESSION_COOKIE_PATH);
$sessionManager->CheckValidPage('../index.php', true);
$tokenResult = TokenController::VerifyTokenValidity();

$redirectURL = StatusMessageController::GetCleanRedirectURL();

if ($tokenResult && isset($_POST['btnSubmit']) && isset($_POST['txtCCNumber']) && isset($_POST['txtCCType']) && isset($_POST['txtCCDate'])) {
	$ccNumber = $_POST['txtCCNumber'];
	$ccType = $_POST['txtCCType'];
	$ccDate = $_POST['txtCCDate'];
	
	if (!preg_match(PATTERN_CCNUMBER, $ccNumber)) {
		$redirectURL = StringHandlerController::AddQueryParam($redirectURL, 'modifyCreditCardStatus', '2');
	}
	else if ($ccType != 'Visa' && $ccType != 'MasterCard') {
		$redirectURL = StringHandlerController::AddQueryParam($redirectURL, 'modifyCreditCardStatus', '3');
	}
	else if (!preg_match(PATTERN_DOB, $ccDate) && $ccDate > date('Y-m-d')) {
		$redirectURL = StringHandlerController::AddQueryParam($redirectURL, 'modifyCreditCardStatus', '4');
	}
	else {
		$creditCard = new CreditCardModel($_SESSION['authenticated_id']);
		$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);
		if ($creditCard->GetCreditCardID() == null) {
			$ccCCV = 0;
			$query = $connection->prepare('INSERT INTO credit_cards(card_number,card_type,card_ccv,card_expiry_date,customer_id) VALUES(?,?,?,?,?)');
			$query->bind_param("isisi", $ccNumber, $ccType, $ccCCV, $ccDate, $_SESSION['authenticated_id']);
			$query->execute();
		}
		else {
			$query = $connection->prepare('UPDATE credit_cards SET card_number=?,card_type=?,card_expiry_date=? WHERE customer_id=?');
			$query->bind_param("issi", $ccNumber, $ccType, $ccDate, $_SESSION['authenticated_id']);
			$query->execute();
		}
		$redirectURL = StringHandlerController::AddQueryParam($redirectURL, 'modifyCreditCardStatus', '0');
	}
}
else {
	$redirectURL = StringHandlerController::AddQueryParam($redirectURL, 'modifyCreditCardStatus', '1');
}

header('Location: '.$redirectURL);
