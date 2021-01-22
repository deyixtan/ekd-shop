<?php
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../controllers/SessionManagementController.php';
require_once __DIR__.'/../controllers/ShoppingCartController.php';
require_once __DIR__.'/../controllers/StatusMessageController.php';
require_once __DIR__.'/../controllers/StringHandlerController.php';
require_once __DIR__.'/../controllers/TokenController.php';

$sessionManager = new SessionManagementController(SESSION_COOKIE_PATH);
$sessionManager->CheckValidPage('../index.php', true);
$sessionManager->VerifyActivity();
$tokenResult = TokenController::VerifyTokenValidity();

$redirectURL = StatusMessageController::GetCleanRedirectURL();

$shoppingCart = new ShoppingCartController($_SESSION['authenticated_id']);
$manageResult = null;

if (isset($_POST['btnAddItemToCart'])) {
	if (isset($_POST['txtQuantity']) && !empty($_POST['txtQuantity']) && $_POST['txtQuantity'] >= 1 && $_POST['txtQuantity'] <= 100) {
		if (isset($_POST['cboSize']) && isset($_POST['cboColor']) && isset($_POST['cboGender']) && preg_match(PATTERN_ADDORDERITEM_CBO_MAXVALUE, $_POST['cboSize']) && preg_match(PATTERN_ADDORDERITEM_CBO_MAXVALUE, $_POST['cboColor']) && preg_match(PATTERN_ADDORDERITEM_CBO_MAXVALUE, $_POST['cboGender'])) {		
			if ($tokenResult)
				$manageResult = $shoppingCart->AddItemToCart($_POST['itemID'], $_POST['txtQuantity'], $_POST['cboSize'], $_POST['cboColor'], $_POST['cboGender']);
			else
				$manageResult = 1;
		}
		else {
			$manageResult = 2;
		}
	}
	else {
		$manageResult = 3;
	}
	$redirectURL = StringHandlerController::AddQueryParam($redirectURL, 'addOrderItemStatus', $manageResult);
}
else if (isset($_POST['btnDeleteOrderItem'])) {
	if ($tokenResult) {
		$manageResult = $shoppingCart->DeleteItemFromCart($_POST['txtOrderItemID']);
		$redirectURL = StringHandlerController::AddQueryParam($redirectURL, 'removeOrderItemStatus', $manageResult);
	}
	else {
		$manageResult = 1;
	}
}
else if (isset($_POST['btnCheckoutOrder'])) {
	if ($tokenResult)
		$manageResult = $shoppingCart->CheckOutOrder(1, filter_var($_POST['txtTotalCost'], FILTER_SANITIZE_STRING), filter_var($_POST['txtRemarks'], FILTER_SANITIZE_STRING));
	else
		$manageResult = 1;
	$redirectURL = StringHandlerController::AddQueryParam($redirectURL, 'checkoutOrderStatus', $manageResult);
}
else {
	$redirectURL = '../index.php';
}

header('Location: '.$redirectURL);