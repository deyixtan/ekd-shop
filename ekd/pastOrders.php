<!DOCTYPE html>
<html lang="en">
<head>
	<?php
	require_once __DIR__.'/config.php';
	require_once __DIR__.'/navbar.php';
	require_once __DIR__.'/controllers/SessionManagementController.php';
	require_once __DIR__.'/models/OrderModel.php';
	$sessionManager = new SessionManagementController(SESSION_COOKIE_PATH);
	$sessionManager->CheckValidPage('index.php', true);
	?>
	<title>Past Orders</title>
</head>
<body background="images/background.png" style="background-color:black;">
	<div class="container">
		<div class="col-md-8 col-md-offset-2">
			<div align="center" class="col-md-12" style="background-color:white; border:1px solid grey;">
				<h2>Past Orders</h2>
				<?php
				$order = new OrderModel($_SESSION['authenticated_id']);
				$orderIDs = $order->GetPastOrderIDs();
				$orderTotalCosts = $order->GetPastOrderTotalCosts();
				$orderStatuses = $order->GetPastOrderStatuses();
				$orderDeliveryDates = $order->GetPastOrderDeliveryDates();
				$orderRemarks = $order->GetPastOrderRemarks();
				
				if (!empty($orderIDs)) {
					echo '<table class="table table-hover">';
					echo '	<tr>';
					echo '		<th>Order ID</th>';
					echo '		<th>Total Cost</th>';
					echo '		<th>Status</th>';
					echo '		<th>Estimated Delivery Date</th>';
					echo '		<th>Remarks</th>';
					echo '	</tr>';
					foreach ($orderIDs as $index => $orderID) {
						echo '	<tr>';
						echo '		<td>'.($orderID).'</td>';
						echo '		<td>SGD '.number_format($orderTotalCosts[$index], 2).'</td>';
						if ($orderStatuses[$index] == 1) {
							echo '		<td><font color="red">Delivering</font></td>';
						}
						else {
							echo '		<td><font color="green">Delivered</font></td>';
						}
						echo '		<td>'.$orderDeliveryDates[$index].'</td>';
						echo '		<td>'.$orderRemarks[$index].'</td>';
						echo '	</tr>';
					}
					echo '	</table>';
				}
				else {
					echo '<div align="center">';
					echo '	<h4 align="center" style="color:red;">You have not purchased any orders.</h4>';
					echo '</div>';
				}
				?>
			</div>
		</div>
	</div><br><br>
</body>
</html>