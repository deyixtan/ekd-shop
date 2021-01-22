<!DOCTYPE html>
<html lang="en">
<head>
	<?php require_once __DIR__.'/navbar.php';?>
	<?php require_once __DIR__.'/controllers/StatusMessageController.php';?>
	<?php require_once __DIR__.'/controllers/TokenController.php';?>
	<?php require_once __DIR__.'/models/CustomerModel.php';?>
	<?php require_once __DIR__.'/models/EmployeeModel.php';?>
	<?php require_once __DIR__.'/models/ItemFeedbackModel.php';?>
	<?php require_once __DIR__.'/models/ItemModel.php';?>
	<?php
		SessionManagementController::UpdateActivity();

		$item = new ItemModel();
		if (isset($_GET['id']))
			$item->RetrieveItemInfo($_GET['id']);

		$employee = new EmployeeModel();
		$employee->RetrieveEmployeeInfo($item->GetItemEmployeeID());
	?>
	<title><?php echo $item->GetItemName(); ?></title>
</head>
<body background="images/background.png" style="background-color:black;">
	<div class="container">
		<div class="col-md-8 col-md-offset-2">
			<?php 
			if (isset($_GET['addOrderItemStatus'])) {
				StatusMessageController::GetAddOrderItemMessage($_GET['addOrderItemStatus']);
			}
			else if (isset($_GET['addFeedbackStatus'])) {
				StatusMessageController::GetAddFeedbackMessage($_GET['addFeedbackStatus']);
			}
			?>
			<div id="myCarousel" class="carousel slide" data-ride="carousel" style="background-color: white;border: 1px solid grey">
				<div class="carousel-inner" role="listbox">
					<?php
					if ($item->GetItemID() == null) {
						exit('<h1 align="center">Invalid item!</h1>');
					}
					
					$images = explode(',', $item->GetItemImageURL());
					foreach ($images as $imageIndex => $image) {
						if ($imageIndex == 0) {
							echo '<div class="item active" align="center">';
						}
						else {
							echo '<div class="item" align="center">';
						}
						echo '	<img style="height:250px;" src="'.$image.'">';
						echo '</div>';
					}
					?>
				</div>
				
				<!-- Carousel slider buttons -->
				<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
    				<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    				<span class="sr-only">Previous</span>
  				</a>
  				<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
    				<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    				<span class="sr-only">Next</span>
  				</a>
			</div>
			
			<div class="col-md-12" style="background-color: white;border: 1px solid grey">
				<form action="process/manageShoppingCart.php" method="post">
					<h1 align="center"><?php echo $item->GetItemName(); ?></h1><br>
					<pre><?php echo $item->GetItemDescription(); ?></pre>
					<table class="table table-bordered">
						<tbody>
							<tr>
								<td><strong>Seller</strong></td>
								<td><?php echo $employee->GetEmployeeFullName(); ?></td>
							</tr>
							<tr>
								<td><strong>Price</strong></td>
								<td>SGD <?php echo number_format($item->GetItemPrice(), 2) ?></td>
							</tr>
							<tr>
								<td><strong>Stock Quantity</strong></td>
								<td><?php echo $item->GetItemStockQuantity() ?></td>
							</tr>						
							<tr>
								<td><strong>Available Size</strong></td>
								<td>
									<select class="form-control" name="cboSize">
										<?php 
										$sizes = explode(',', $item->GetItemSize());
										foreach ($sizes as $index => $size) {
											echo '<option value="'.$index.'" >'.$size.'</option>';
										}
										?>
									</select>
								</td>
							</tr>
							<tr>
								<td><strong>Available Colour</strong></td>
								<td>
									<select class="form-control" name="cboColor">
										<?php 
										$colours = explode(',', $item->GetItemColor());
										foreach ($colours as $index => $colour) {
											echo '<option value="'.$index.'" >'.$colour.'</option>';
										}
										?>
									</select>
								</td>
							</tr>
							<tr>
								<td><strong>Available Gender</strong></td>
								<td>
									<select class="form-control" name="cboGender">
										<?php 
										$genders = explode(',', $item->GetItemGender());
										foreach ($genders as $index => $gender) {
											echo '<option value="'.$index.'" >'.$gender.'</option>';
										}
										?>
									</select>
								</td>
							</tr>
						</tbody>
					</table>
				<?php
				if (isset($_SESSION['authenticated_id']) && isset($_SESSION['authenticated_email']) && $item->GetItemStockQuantity() > 0) {
					echo '<div align="center">';
					echo '	<label>Quantity</label><br>';
					echo '	<input type="number" name="txtQuantity" value="1" min="1" max="100"><br><br>';
					echo '	<input type="hidden" name="itemID" value="'.$item->GetItemID().'">';
					echo '	<input type="hidden" name="txtToken" value="'.TokenController::GenerateToken().'">';
					echo '	<input class="btn btn-success" name="btnAddItemToCart" type="submit" value="Add to Shopping Cart"><br><br>';
					echo '</div>';
				}
				?>
				</form>
			</div>
						
			<!-- Feedbacks -->
			<div class="col-md-12" style="background-color: white;border: 1px solid grey;margin-top:20px;">
				<h3 align="center">Feedbacks</h3>
			</div>
			<?php
			$feedback = new ItemFeedbackModel($_GET['id']);
			if (isset($_SESSION['authenticated_id']) && isset($_SESSION['authenticated_email']) && $item->GetItemStockQuantity() > 0) {
				echo '<div align="center" class="col-md-12" style="background-color: white;border: 1px solid grey"><br>';
				echo '	<form action="process/manageFeedback.php" method="post">';
				echo '		<textarea class="form-control" name="txtFeedback" rows="5" style="resize: none;" placeholder="Enter your feedback here..." required></textarea><br>';
				echo '		<input type="hidden" name="txtItemID" value="'.$_GET['id'].'">';
				echo '		<input type="hidden" name="txtUserID" value="'.$_SESSION['authenticated_id'].'">';
				echo '		<input type="hidden" name="txtToken" value="'.TokenController::GenerateToken().'">';
				echo '		<input class="btn btn-primary" name="btnPostFeedback" type="submit" value="Post Feedback"><br><br>';
				echo '	</form>';
				echo '</div>';
			}
			
			$fbIDArr = $feedback->GetItemFeedbackIDArray();
			$fbUserArr = $feedback->GetItemFeedbackCustomerIDArray();
			$fbDateTimeArr = $feedback->GetItemFeedbackDateTimeArray();
			$fbMessageArr = $feedback->GetItemFeedbackMessageArray();
			if (!(empty($fbIDArr) && empty($fbIDArr))) {
				foreach ($fbIDArr as $index => $value) {
					$fbUser = new CustomerModel();
					$fbUser->RetrieveCustomerInfo($fbUserArr[$index]);
					echo '<div class="col-md-12" style="background-color: white;border: 1px solid grey"><br>';
					if (isset($_SESSION['authenticated_id']) && $fbUser->GetCustomerID() == $_SESSION['authenticated_id']) {
						echo '<form action="process/manageFeedback.php" method="post">';
						echo '	<input type="hidden" name="txtFeedbackID" value="'.$fbIDArr[$index].'">';
						echo '	<button type="submit" name="btnDeleteFeedback" class="close">&times;</button>';
						echo '	<input type="hidden" name="txtToken" value="'.TokenController::GenerateToken().'">';
						echo '</form>';
					}
					echo '	<label>'.$fbUser->GetCustomerFullName().' ('.$fbDateTimeArr[$index].')</label>';
					echo '	<pre>'.$fbMessageArr[$index].'</pre><br>';
					echo '</div>';	
				}
			}
			else {
				echo '<div class="col-md-12" style="background-color: white;border: 1px solid grey">';
				echo '	<h4 align="center" style="color:red">Currently there is no feedback for this item.</h4>';
				echo '</div>';
			}
			?>
		</div>
	</div><br><br>
</body>
</html>