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
	<title>Remove Item</title>
	<script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body background="images/background.png" style="background-color:black;">
	<div class="container">
		<div class="col-md-6 col-md-offset-3" style="background-color:white; border:1px solid grey;">
			<h2 align="center">Remove Item</h2><br>
			<?php
			if (isset($_GET['removeItemStatus'])) {
				StatusMessageController::GetRemoveItemMessage($_GET['removeItemStatus']);
			}
			?>
			<form action="process/removeItem.php" method="post">
				<label>Item ID:</label>
            	<input class="form-control" type="number" name="txtItemID" required="required"><br>
            	<input type="hidden" name="txtToken" value="<?php echo TokenController::GenerateToken(); ?>">
            	<button type="submit" class="form-control btn btn-primary" name="btnRemoveItem">Remove Item</button><br><br><br>
            </form>
		</div>
	</div><br><br><br>
</body>
</html>