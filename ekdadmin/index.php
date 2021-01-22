<!DOCTYPE html>
<html lang="en">
<head>
	<?php
	require_once __DIR__.'/config.php';
	require_once __DIR__.'/navbar.php';
	require_once __DIR__.'/controllers/SessionManagementController.php';
	require_once __DIR__.'/frameworks/bootstrap/bootstrap.php';
	$sessionManager = new SessionManagementController(SESSION_COOKIE_PATH);
	$sessionManager->CheckValidPage('login.php', true);
	?>
</head>
<body background="images/background.png" style="background-color:black;">
	<div class="container">
		<div class="col-md-12" style="background-color:white; border:1px solid grey;">
			<div align="center" class="h2">Items</div>
			<?php 
			$dbConnection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);
			
			if (!$dbConnection) {
				echo '<h2>Unable to connect to database server.</h2>';
				exit();
			}
			
			if ($query = $dbConnection->prepare('SELECT * FROM items')) 
			{
				$query->execute();
				$query->bind_result($itemID, $itemName, $description, $size, $color, $gender, $price, $quantity, $imageURL, $employeeID);
				echo '<table class="table table-hover">';
				echo '<tr>';
				echo '	<th>Item ID</th>';
				echo '	<th>Item Name</th>';
				echo '	<th>Size</th>';
				echo '	<th>Color</th>';
				echo '	<th>Gender</th>';
				echo '	<th>Price</th>';
				echo '	<th>Quantity</th>';
				echo '	<th>Employee ID</th>';
				echo '</tr>';
				while ($query->fetch()) {
					echo '<tr>';
					echo '	<td>'.$itemID.'</td>';
					echo '	<td>'.$itemName.'</td>';
					echo '	<td>'.$size.'</td>';
					echo '	<td>'.$color.'</td>';
					echo '	<td>'.$gender.'</td>';
					echo '	<td>'.$price.'</td>';
					echo '	<td>'.$quantity.'</td>';
					echo '	<td>'.$employeeID.'</td>';
					echo '</tr>';
				}
				echo '</table>';
			}
			?>
		</div>
		<div class="col-md-12" style="background-color:white; border:1px solid grey;">
			<div align="center" class="h2">Orders</div>
			<?php 
			$dbConnection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);
			
			if (!$dbConnection) {
				echo '<h2>Unable to connect to database server.</h2>';
				exit();
			}
			
			if ($query = $dbConnection->prepare('SELECT * FROM orders')) 
			{
				$query->execute();
				$query->bind_result($orderID, $customerID, $totalCost, $status, $deliveryDate, $remarks);
				echo '<table class="table table-hover">';
				echo '<tr>';
				echo '	<th>Order ID</th>';
				echo '	<th>Customer ID</th>';
				echo '	<th>Total Cost</th>';
				echo '	<th>Status</th>';
				echo '	<th>Delivery Date</th>';
				echo '	<th>Remarks</th>';
				echo '</tr>';
				while ($query->fetch()) {
					echo '<tr>';
					echo '	<td>'.$orderID.'</td>';
					echo '	<td>'.$customerID.'</td>';
					echo '	<td>'.$totalCost.'</td>';
					echo '	<td>'.$status.'</td>';
					echo '	<td>'.$deliveryDate.'</td>';
					echo '	<td>'.$remarks.'</td>';
					echo '</tr>';
				}
				echo '</table>';
			}
			?>
		</div>
	</div>
</body>
</html>
