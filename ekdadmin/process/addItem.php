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

if ($query = $dbConnection->prepare('INSERT INTO items(item_name,description,size,color,gender,price,stock_quantity,image_url,employee_id) VALUES(?,?,?,?,?,?,?,?,?)'))
{
	$query->bind_param('sssssiisi', $_POST['txtItemName'], $_POST['txtDescription'], $_POST['txtSize'], $_POST['txtColor'], $_POST['txtGender'], $_POST['txtPrice'], $_POST['txtQuantity'], $_POST['txtImageURL'], $_SESSION['authenticated_id']);
	$query->execute();
	$redirectURL = StringHandlerController::AddQueryParam($redirectURL, 'addItemStatus', '0');
}

header('Location: '.$redirectURL);