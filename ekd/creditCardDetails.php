<!DOCTYPE html>
<html lang="en">
<head>
	<?php
	require_once __DIR__.'/config.php';
	require_once __DIR__.'/navbar.php';
	require_once __DIR__.'/controllers/SessionManagementController.php';
	require_once __DIR__.'/controllers/StatusMessageController.php';
	require_once __DIR__.'/controllers/TokenController.php';
	require_once __DIR__.'/models/CreditCardModel.php';
	$sessionManager = new SessionManagementController(SESSION_COOKIE_PATH);
	$sessionManager->CheckValidPage('index.php', true);
	?>
	<title>Credit Card Details</title>
</head>
<body background="images/background.png" style="background-color:black;">
	<div class="container">
		<div class="col-md-6 col-md-offset-3" style="background-color:white; border:1px solid grey;">
			<h2 align="center">Edit Credit Card Information</h2><br>
			<?php
			if (isset($_GET['modifyCreditCardStatus'])) {
				StatusMessageController::GetModifyCreditCardMessage($_GET['modifyCreditCardStatus']);
			}
			$creditCard = new CreditCardModel($_SESSION['authenticated_id']);
			?>
			<form action="process/manageCreditCardDetails.php" method="post">
				<label>Credit Card Number:</label>
				<input type="number" class="form-control" name="txtCCNumber" min="1000000000000000" max="9999999999999999" placeholder="Numeric values, strictly 16 digits" value="<?php if ($creditCard->GetCreditCardNumber() != null) echo $creditCard->GetCreditCardNumber(); ?>"required><br>
				<label>Credit Card Type:</label>
				<select class="form-control" name="txtCCType">
					<option value="Visa" <?php if ($creditCard->GetCreditCardType() == 'Visa') echo 'selected="selected"'; ?>>Visa</option>
					<option value="MasterCard" <?php if ($creditCard->GetCreditCardType() == 'MasterCard') echo 'selected="selected"'; ?>>MasterCard</option>
				</select><br>
				<label>Expiry Date:</label>
				<input type="date" class="form-control" name="txtCCDate" placeholder="YYYY-MM-DD" value="<?php if ($creditCard->GetCreditCardExpiryDate() != null) echo $creditCard->GetCreditCardExpiryDate(); ?>" required><br>
				<input type="hidden" name="txtToken" value="<?php echo TokenController::GenerateToken(); ?>">
				<button class="form-control btn-primary" type="submit" name="btnSubmit">Submit</button><br>
			</form>
		</div>
	</div><br><br><br>
</body>
</html>