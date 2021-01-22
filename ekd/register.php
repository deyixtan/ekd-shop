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
	$sessionManager->CheckValidPage('index.php', false);
	?>
	<title>Registration</title>
</head>
<body background="images/background.png" style="background-color:black;">
	<div class="container">
		<div class="col-md-6 col-md-offset-3" style="background-color:white; border:1px solid grey;">
			<h2 align="center">Registration</h2><br>
			<?php 
			if (isset($_GET['registerStatus'])) {
				StatusMessageController::GetRegisterMessage($_GET['registerStatus']);
			}
			?>
			<form action="process/register.php" method="post">
				<label>Email:</label>
				<input type="email" class="form-control" name="txtEmail" placeholder="Valid email" value="<?php if (isset($_SESSION['registerEmail'])) echo $_SESSION['registerEmail']; ?>" required><br>
				<label>Password:</label>
				<input type="password" class="form-control" name="txtPassword" placeholder="Alphanumeric values with symbols between 8 to 20 characers" value="<?php if (isset($_SESSION['registerPassword'])) echo $_SESSION['registerPassword']; ?>" autocomplete="off" required><br>
				<label>Retype Password:</label>
				<input type="password" class="form-control" name="txtPassword2" placeholder="Alphanumeric values with symbols between 8 to 20 characers" autocomplete="off" required><br>
				<label>First Name:</label>
				<input type="text" class="form-control" name="txtFirstName" placeholder="Alphabets with spaces between 2 to 35 characters" value="<?php if (isset($_SESSION['registerFirstName'])) echo $_SESSION['registerFirstName']; ?>" required><br>
				<label>Last Name:</label>
				<input type="text" class="form-control" name="txtLastName" placeholder="Alphabets with spaces between 2 to 35 characters" value="<?php if (isset($_SESSION['registerLastName'])) echo $_SESSION['registerLastName']; ?>" required><br>
				<label>Mobile Number:</label>
				<input type="number" class="form-control" name="txtMobileNumber" placeholder="Numeric values, strictly 8 digits" min="60000000" max="99999999" value="<?php if (isset($_SESSION['registerMobileNumber'])) echo $_SESSION['registerMobileNumber']; ?>" required><br>
				<label>Date of Birth:</label>
				<input type="date" class="form-control" name="txtDOB" placeholder="YYYY-MM-DD" value="<?php if (isset($_SESSION['registerDOB'])) echo $_SESSION['registerDOB']; ?>" required><br>
				<label>Address:</label>
				<input type="text" class="form-control" name="txtAddress" placeholder="Alphanumeric values with spaces between 2 to 100 characters" value="<?php if (isset($_SESSION['registerAddress'])) echo $_SESSION['registerAddress']; ?>" required><br><br>
				<input type="hidden" name="txtToken" value="<?php echo TokenController::GenerateToken(); ?>">
				<button type="submit" class="btn btn-primary form-control" name="btnRegister">Register</button><br><br><br>
			</form>
		</div>
	</div><br><br><br>
</body>
</html>