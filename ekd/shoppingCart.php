<!DOCTYPE html>
<html lang="en">
<head>
	<?php 
	require_once __DIR__.'/config.php';
	require_once __DIR__.'/navbar.php';
	require_once __DIR__.'/controllers/SessionManagementController.php';
	require_once __DIR__.'/controllers/StatusMessageController.php';
	require_once __DIR__.'/controllers/TokenController.php';
	require_once __DIR__.'/models/ItemModel.php';
	require_once __DIR__.'/models/OrderItemModel.php';
	require_once __DIR__.'/models/OrderModel.php';
	$sessionManager = new SessionManagementController(SESSION_COOKIE_PATH);
	$sessionManager->CheckValidPage('index.php', true);
	?>
	<title>Shopping Cart</title>
</head>
<body background="images/background.png" style="background-color:black;">
	<div class="container">
		<div class="col-md-8 col-md-offset-2">
			<?php
			if (isset($_GET['removeOrderItemStatus'])) {
				StatusMessageController::GetRemoveOrderItemMessage($_GET['removeOrderItemStatus']);
			}
			else if (isset($_GET['checkoutOrderStatus'])) {
				StatusMessageController::GetCheckoutOrderMessage($_GET['checkoutOrderStatus']);
			}
			
			echo '<div align="center" class="col-md-12" style="background-color:white; border:1px solid grey;">';
			echo '	<h2>My Shopping Cart</h2>';
			if (isset($_SESSION['authenticated_id']) && isset($_SESSION['authenticated_email']) && isset($_SESSION['last_activity'])) {
				$order = new OrderModel($_SESSION['authenticated_id']);
				$orderItem = new OrderItemModel();
				$orderItem->RetrieveOrderItemInfo($order->GetOrderID());
				$itemIDs = $orderItem->GetOrderItemItemIDs();
				
				if (!empty($itemIDs)) {
					echo '	<table class="table table-hover">';
					echo '		<tr>';
					echo '			<th>Index</th>';
					echo '			<th>Name</th>';
					echo '			<th>Quantity</th>';
					echo '			<th>Size</th>';
					echo '			<th>Color</th>';
					echo '			<th>Gender</th>';
					echo '			<th></th>';
					echo '		</tr>';
					
					$totalcost = 0;
					foreach ($itemIDs as $index => $itemID) {
						$item = new ItemModel();
						$item->RetrieveItemInfo($itemID);
						$totalcost += $item->GetItemPrice() * $orderItem->GetOrderItemQuantities()[$index];
						echo '		<tr>';
						echo '				<td>'.($index+1).'</td>';
						echo '				<td>'.$item->GetItemName().'</td>';
						echo '				<td>'.$orderItem->GetOrderItemQuantities()[$index].'</td>';
						echo '				<td>'.explode(',', $item->GetItemSize())[$orderItem->GetOrderItemSizes()[$index]].'</td>';
						echo '				<td>'.explode(',', $item->GetItemColor())[$orderItem->GetOrderItemColors()[$index]].'</td>';
						echo '				<td>'.explode(',', $item->GetItemGender())[$orderItem->GetOrderItemGenders()[$index]].'</td>';
						echo '				<td>';
						echo '					<form action="process/manageShoppingCart.php" method="post">';
						echo '						<input type="hidden" name="txtOrderItemID" value="'.$orderItem->GetOrderItemIDs()[$index].'">';
						echo '						<input type="hidden" name="txtToken" value="'.TokenController::GenerateToken().'">';
						echo '						<button type="submit" name="btnDeleteOrderItem" class="close">&times;</button>';
						echo '					</form>';
						echo '				</td>';
						echo '		</tr>';
					}
					echo '	</table>';
					echo '	<div align="right">';
					echo '		<label>Total Cost: SGD '.number_format($totalcost,2).'</label>';
					echo '	</div>';
					echo '</div><br>';
					
					echo '<form action="process/manageShoppingCart.php" method="post">';
					echo '	<div class="col-md-12" style="background-color:white; border:1px solid grey;">';
					echo '		<h2 align="center">Checkout</h2>';
					echo '		<label>Order Remarks: </label><br>';
					echo '		<textarea class="form-control" name="txtRemarks" rows="3" style="resize:none;" placeholder="Enter your remarks for your order here..."></textarea><br>';
					echo '		<label>Credit Card CCV: </label><br>';
					echo '		<input type="number" name="txtCCN" autocomplete="off" min="100" max="999"><br><br>';
					echo '		<input type="hidden" value="'.$totalcost.'" name="txtTotalCost">';
					echo '		<input type="hidden" name="txtToken" value="'.TokenController::GenerateToken().'">';
					echo '		<button type="submit" class="btn btn-primary" name="btnCheckoutOrder">Checkout</button><br><br>';
					echo '	</div>';
					echo '</form>';
				}
				else {
					echo '<div align="center">';
					echo '	<h4 align="center" style="color:red;">Your shopping cart is empty.</h4>';
					echo '</div>';
				}
			}
			?>
		</div>
	</div><br><br>
</body>
</html>