<?php
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../controllers/SessionManagementController.php';
require_once __DIR__.'/../models/CreditCardModel.php';
require_once __DIR__.'/../models/CustomerModel.php';
require_once __DIR__.'/../models/ItemModel.php';
require_once __DIR__.'/../models/OrderItemModel.php';
require_once __DIR__.'/../models/OrderModel.php';

class ShoppingCartController {
	
	private $orderItemModelObj;
	private $orderModelObj;
	private $userID;
	private $orderID;
	
	function __construct($userID) {
		$this->orderItemModelObj = new OrderItemModel();
		$this->orderModelObj = new OrderModel($userID);
		
		$this->userID = $userID;
		$this->orderID = $this->orderModelObj->GetOrderID();
	}
	
	function AddItemToCart($itemID, $quantity, $itemSize, $itemColor, $itemGender) {
		return $this->orderItemModelObj->InsertOrderItem($this->orderID, $itemID, $quantity, $itemSize, $itemColor, $itemGender);
	}
	
	function DeleteItemFromCart($orderItemID) {
		return $this->orderItemModelObj->DeleteOrderItem($this->orderID, $orderItemID);
	}
	
	function CheckOutOrder($status, $totalCost, $remarks) {
		$user = new CustomerModel();
		$user->RetrieveCustomerInfo($_SESSION['authenticated_id']);
		$userAddress = $user->GetCustomerAddress();
		
		$creditCard = new CreditCardModel($_SESSION['authenticated_id']);
		$ccNumber = $creditCard->GetCreditCardNumber();
		$ccDate = $creditCard->GetCreditCardExpiryDate();
		
		if (preg_match(PATTERN_ADDRESS, $userAddress) && preg_match(PATTERN_CCNUMBER, $ccNumber) && $ccDate > date('Y-m-d')) {
			if (preg_match(PATTERN_CCV, $_POST['txtCCN'])) {
				$orderItemModelObj = new OrderItemModel();
				$orderModelObj = new OrderModel($this->userID);
				
				$orderID = $orderModelObj->GetOrderID();
	    		$orderItemModelObj->RetrieveOrderItemInfo($this->orderID);
	    		$orderItemIDs = $orderItemModelObj->GetOrderItemIDs();
	    		$orderItemItemIDs = $orderItemModelObj->GetOrderItemItemIDs();
			 	$orderItemQuantities = $orderItemModelObj->GetOrderItemQuantities();
			 	
			 	foreach ($orderItemItemIDs as $index => $orderItemItemID) {
			 		$item = new ItemModel();
			 		$item->RetrieveItemInfo($orderItemItemID);
			 		$itemQuantity = $item->GetItemStockQuantity();
			 		if ($itemQuantity < $orderItemQuantities[$index]) {
			 			echo $orderItemItemID;
			 			$orderItemModelObj->DeleteOrderItem($orderID, $orderItemIDs[$index]);
			 			return 4;
			 		}
			 	}
			 	foreach ($orderItemIDs as $index => $itemID) {
			 		$item->RetrieveItemInfo($itemID);
			 		$item->DecrementItemStockQuantity($orderItemQuantities[$index]);
			 	}
			 	return $this->orderModelObj->UpdateOrderStatus($status, $totalCost, $remarks);
			}
			else {
				return 3;
			}
		}
		return 2;
	}
	
}
