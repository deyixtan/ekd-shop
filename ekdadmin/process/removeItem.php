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

if ($query = $dbConnection->prepare('DELETE FROM items WHERE item_id=? AND employee_id=?'))
{
	$query->bind_param('ii', $_POST['txtItemID'], $_SESSION['authenticated_id']);
	$query->execute();
	$redirectURL = StringHandlerController::AddQueryParam($redirectURL, 'removeItemStatus', '0');
}

header('Location: '.$redirectURL);