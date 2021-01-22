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
	$sessionManager->CheckValidPage('login.php', true);
	?>
	<title>Modify Item</title>
	<script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body background="images/background.png" style="background-color:black;">
	<div class="container">
		<div class="col-md-6 col-md-offset-3" style="background-color:white; border:1px solid grey;">
			<h2 align="center">Modify Item</h2><br>
			<?php
			if (isset($_GET['modifyItemStatus'])) {
				StatusMessageController::GetModifyItemMessage($_GET['modifyItemStatus']);
			}
			?>
			<form action="process/modifyItem.php" method="post">
				<label>Item ID:</label>
            	<input class="form-control" type="number" name="txtItemID" required="required"><br>
           		<label>Item Name:</label>
            	<input class="form-control" type="text" name="txtItemName" required="required"><br>
            	<label>Description:</label>
            	<input class="form-control" type="text" name="txtDescription" required="required"><br>
            	<label>Size:</label>
            	<input class="form-control" type="text" name="txtSize" required="required"><br>
            	<label>Color:</label>
            	<input class="form-control" type="text" name="txtColor" required="required"><br>
            	<label>Gender:</label>
            	<input class="form-control" type="text" name="txtGender" required="required"><br>
            	<label>Price:</label>
            	<input class="form-control" type="text" name="txtPrice" required="required"><br>
            	<label>Stock Quantity:</label>
            	<input class="form-control" type="text" name="txtQuantity" required="required"><br>
            	<label>Image URL:</label>
            	<input class="form-control" type="text" name="txtImageURL" required="required"><br>
            	<input type="hidden" name="txtToken" value="<?php echo TokenController::GenerateToken(); ?>">
            	<button type="submit" class="form-control btn btn-primary" name="btnModifyItem">Modify Item</button><br><br><br>
            </form>
		</div>
	</div><br><br><br>
</body>
</html>