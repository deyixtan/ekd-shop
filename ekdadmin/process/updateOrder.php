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

if ($query = $dbConnection->prepare('UPDATE orders SET status=2 WHERE status=1 AND order_id=?'))
{
	$query->bind_param('i', $_POST['txtOrderID']);
	$query->execute();
	$redirectURL = StringHandlerController::AddQueryParam($redirectURL, 'updateOrderStatus', '0');
}

header('Location: '.$redirectURL);