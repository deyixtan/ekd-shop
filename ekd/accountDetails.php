<!DOCTYPE html>
<html lang="en">
<head>
	<?php
	require_once __DIR__.'/config.php';
	require_once __DIR__.'/navbar.php';
	require_once __DIR__.'/controllers/SessionManagementController.php';
	require_once __DIR__.'/controllers/StatusMessageController.php';
	require_once __DIR__.'/controllers/TokenController.php';
	$sessionManager = new SessionManagementController(SESSION_COOKIE_PATH);
	$sessionManager->CheckValidPage('index.php', true);
	?>
	<title>Account Details</title>
</head>
<body background="images/background.png" style="background-color:black;">
	<div class="container">
		<div class="col-md-6 col-md-offset-3" style="background-color:white; border:1px solid grey;">
			<h2 align="center">Edit Account Information</h2><br>
			<?php
			if (isset($_GET['modifyAccountStatus'])) {
				StatusMessageController::GetModifyAccountMessage($_GET['modifyAccountStatus']);
			}
			$customer = new CustomerModel();
			$customer->RetrieveCustomerInfo($_SESSION['authenticated_id']);
			?>
			<form action="process/manageAccountDetails.php" method="post">
				<label>Email:</label>
				<input type="email" class="form-control" name="txtEmail" placeholder="Valid email" value="<?php if ($customer->GetCustomerEmail() != null) echo $customer->GetCustomerEmail(); ?>" required><br>
				<label>New Password:</label>
				<input type="password" class="form-control" name="txtPassword" placeholder="Alphanumeric values with symbols between 8 to 20 characers" autocomplete="off" required><br>
				<label>First Name:</label>
				<input type="text" class="form-control" name="txtFirstName" placeholder="Alphabets with spaces between 2 to 35 characters" value="<?php if ($customer->GetCustomerFirstName() != null) echo $customer->GetCustomerFirstName(); ?>" required><br>
				<label>Last Name:</label>
				<input type="text" class="form-control" name="txtLastName" placeholder="Alphabets with spaces between 2 to 35 characters" value="<?php if ($customer->GetCustomerLastName() != null) echo $customer->GetCustomerLastName(); ?>" required><br>
				<label>Mobile Number:</label>
				<input type="number" class="form-control" name="txtNumber" placeholder="Numeric values, strictly 8 digits" min="60000000" max="99999999" value="<?php if ($customer->GetCustomerMobileNumber() != null) echo $customer->GetCustomerMobileNumber(); ?>" required><br>
				<label>Date of Birth:</label>
				<input type="date" class="form-control" name="txtDOB" placeholder="YYYY-MM-DD" value="<?php if ($customer->GetCustomerDOB() != null) echo $customer->GetCustomerDOB(); ?>" required><br>
				<label>Address:</label>
				<input type="text" class="form-control" name="txtAddress" placeholder="Alphanumeric values with spaces between 2 to 100 characters" value="<?php if ($customer->GetCustomerAddress() != null) echo $customer->GetCustomerAddress(); ?>" required><br>
				<input type="hidden" name="txtToken" value="<?php echo TokenController::GenerateToken(); ?>">
				<button class="form-control btn-primary" type="submit" name="btnSubmit">Submit</button><br>
			</form>
		</div>
	</div><br><br><br>
</body>
</html>