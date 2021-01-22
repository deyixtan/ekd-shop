<?php
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../controllers/SessionManagementController.php';
require_once __DIR__.'/../controllers/StatusMessageController.php';
require_once __DIR__.'/../controllers/StringHandlerController.php';
require_once __DIR__.'/../controllers/TokenController.php';
require_once __DIR__.'/../models/EmployeeModel.php';

$sessionManager = new SessionManagementController(SESSION_COOKIE_PATH);
$sessionManager->CheckValidPage('../index.php', true);
$tokenResult = TokenController::VerifyTokenValidity();

$redirectURL = StatusMessageController::GetCleanRedirectURL();

if ($tokenResult && isset($_POST['btnSubmit']) && isset($_POST['txtEmail']) && isset($_POST['txtPassword']) && isset($_POST['txtFirstName']) && isset($_POST['txtLastName']) && isset($_POST['txtNumber']) && isset($_POST['txtDOB']) && isset($_POST['txtAddress'])) {
	$email = $_POST['txtEmail'];
	$pass = $_POST['txtPassword'];
	$fname = $_POST['txtFirstName'];
	$lname = $_POST['txtLastName'];
	$number = $_POST['txtNumber'];
	$dob = $_POST['txtDOB'];
	$address = $_POST['txtAddress'];
	
	if (!filter_var($email, FILTER_SANITIZE_EMAIL)) {
		$redirectURL = StringHandlerController::AddQueryParam($redirectURL, 'modifyAccountStatus', '2');
	}
	else if (!preg_match(PATTERN_PASSWORD, $pass)) {
		$redirectURL = StringHandlerController::AddQueryParam($redirectURL, 'modifyAccountStatus', '3');
	}
	else if (!preg_match(PATTERN_NAME, $fname)) {
		$redirectURL = StringHandlerController::AddQueryParam($redirectURL, 'modifyAccountStatus', '4');
	}
	else if (!preg_match(PATTERN_NAME, $lname)) {
		$redirectURL = StringHandlerController::AddQueryParam($redirectURL, 'modifyAccountStatus', '5');
	}
	else if (!preg_match(PATTERN_MOBILENUMBER, $number)) {
		$redirectURL = StringHandlerController::AddQueryParam($redirectURL, 'modifyAccountStatus', '6');
	}
	else if (!preg_match(PATTERN_DOB, $dob)) {
		$redirectURL = StringHandlerController::AddQueryParam($redirectURL, 'modifyAccountStatus', '7');
	}
	else if (!preg_match(PATTERN_ADDRESS, $address)) {
		$redirectURL = StringHandlerController::AddQueryParam($redirectURL, 'modifyAccountStatus', '8');
	}
	else {
		$employee = new EmployeeModel();
		$employee->RetrieveEmployeeInfo($_SESSION['authenticated_id']);
		$userEmail = $employee->GetEmployeeEmail();
		$emailValidity = $employee->CheckFieldAvailability('email');
		if ($emailValidity || $userEmail == $email) {
			$pass = password_hash($pass, PASSWORD_DEFAULT);
			$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);
			$query = $connection->prepare('UPDATE employees SET email=?,password=?,first_name=?,last_name=?,mobile_number=?,dob=?,address=? WHERE employee_id=?');
			$query->bind_param("ssssissi", $email, $pass, $fname, $lname, $number, $dob, $address, $_SESSION['authenticated_id']);
			$query->execute();
			$redirectURL = StringHandlerController::AddQueryParam($redirectURL, 'modifyAccountStatus', '0');
		}
		else {
			$redirectURL = StringHandlerController::AddQueryParam($redirectURL, 'modifyAccountStatus', '9');
		}
	}
}
else {
	$redirectURL = StringHandlerController::AddQueryParam($redirectURL, 'modifyAccountStatus', '1');
}

header('Location: '.$redirectURL);
