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
	<title>Update Orders</title>
	<script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body background="images/background.png" style="background-color:black;">
	<div class="container">
		<div class="col-md-6 col-md-offset-3" style="background-color:white; border:1px solid grey;">
			<h2 align="center">Update Orders</h2><br>
			<?php
			if (isset($_GET['updateOrderStatus'])) {
				StatusMessageController::GetUpdateOrderMessage($_GET['updateOrderStatus']);
			}
			?>
			<form action="process/updateOrder.php" method="post">
				<label>Order ID:</label>
            	<input class="form-control" type="number" name="txtOrderID" required="required"><br>
            	<input type="hidden" name="txtToken" value="<?php echo TokenController::GenerateToken(); ?>">
            	<button type="submit" class="form-control btn btn-primary" name="btnUpdateOrder">Update Order</button><br><br><br>
            </form>
		</div>
	</div><br><br><br>
</body>
</html>