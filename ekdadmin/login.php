<!DOCTYPE html>
<html lang="en">
<head>
	<?php
	require_once __DIR__.'/config.php';
	require_once __DIR__.'/navbar.php';
	require_once __DIR__.'/controllers/SessionManagementController.php';
	require_once __DIR__.'/controllers/StatusMessageController.php';
	$sessionManager = new SessionManagementController(SESSION_COOKIE_PATH);
	$sessionManager->CheckValidPage('index.php', false);
	?>
	<title>EKD Admin Portal</title>
	<script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body background="images/background.png" style="background-color:black;">
	<div class="container">
		<div class="col-md-6 col-md-offset-3" style="background-color:white; border:1px solid grey;">
			<h2 align="center">EKD Admin Portal</h2><br>
			<form action="process/login.php" method="post">
          		<div class = "modal-body">
           			<label>Email:</label>
            		<input class="form-control" type="email" name="txtEmail" required="required"><br>
            		<label>Password:</label>
            		<input class="form-control" type="password" name="txtPassword" autocomplete="off" required="required"><br>
            		<div align="center" class="g-recaptcha" data-sitekey="<?php echo RECAPTCHA_CLIENT_KEY; ?>"></div>
         		</div>
         		<div class = "modal-footer">
            		<button type="submit" class="form-control btn btn-primary" name="btnLogin">Login</button><br>
         		</div>
            </form>
		</div>
	</div><br><br><br>
</body>
</html>