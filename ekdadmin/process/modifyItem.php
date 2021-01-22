<?php
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../controllers/SessionManagementController.php';
require_once __DIR__.'/../controllers/StatusMessageController.php';
require_once __DIR__.'/../controllers/StringHandlerController.php';
require_once __DIR__.'/../controllers/TokenController.php';

$sessionManager = new SessionManagementController(SESSION_COOKIE_PATH);
$sessionManager->CheckValidPage('../index.php', true);
$tokenResult = TokenController::VerifyTokenValidity();

$redirectURL = StatusMessageController::GetCleanRedirectURL();

$dbConnection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);

if (!$dbConnection) {
	echo '<h2>Unable to connect to database server.</h2>';
	exit();
}

if ($query = $dbConnection->prepare('UPDATE items SET item_name=?,description=?,size=?,color=?,gender=?,price=?,stock_quantity=?,image_url=?,employee_id=? WHERE item_id=?'))
{
	$query->bind_param('sssssiisii', $_POST['txtItemName'], $_POST['txtDescription'], $_POST['txtSize'], $_POST['txtColor'], $_POST['txtGender'], $_POST['txtPrice'], $_POST['txtQuantity'], $_POST['txtImageURL'], $_SESSION['authenticated_id'], $_POST['txtItemID']);
	$query->execute();
	$redirectURL = StringHandlerController::AddQueryParam($redirectURL, 'modifyItemStatus', '0');
}

header('Location: '.$redirectURL);