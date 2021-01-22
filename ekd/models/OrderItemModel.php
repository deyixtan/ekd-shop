<?php
require_once __DIR__.'/../config.php';

class OrderItemModel {
	
	private $dbConnection;	
	private $orderItemIDs;
	private $orderItemItemIDs;
	private $orderItemQuantities;
	private $orderItemSizes;
	private $orderItemColors;
	private $orderItemGenders;
	
	function RetrieveOrderItemInfo($orderID) {
		$this->orderItemIDs = array();
		$this->orderItemItemIDs = array();
		$this->orderItemQuantities = array();
		$this->orderItemSizes = array();
		$this->orderItemColors = array();
		$this->orderItemGenders = array();
	
		$this->dbConnection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);
		
		if (!$this->dbConnection) {
			echo '<h2>Unable to connect to database server.</h2>';
			exit();
		}
		
		if ($query = $this->dbConnection->prepare('SELECT order_item_id,item_id,quantity,size,color,gender FROM order_items WHERE order_id=?'))
		{
			$query->bind_param('i', $orderID);
			$query->execute();
			$query->bind_result($orderItemID,
								$orderItemItemID,
								$orderItemQuantity,
								$orderItemSize,
								$orderItemColor,
								$orderItemGender);
			
			$query->store_result();
			$resultRows = $query->num_rows;
			
			if ($resultRows > 0) {
				while ($query->fetch()) {
					array_push($this->orderItemIDs, $orderItemID);
					array_push($this->orderItemItemIDs, $orderItemItemID);
					array_push($this->orderItemQuantities, $orderItemQuantity);
					array_push($this->orderItemSizes, $orderItemSize);
					array_push($this->orderItemColors, $orderItemColor);
					array_push($this->orderItemGenders, $orderItemGender);
				}
			}
		}
	}
	
	function InsertOrderItem($orderID, $itemID, $quantity, $itemSize, $itemColor, $itemGender) {
		$this->dbConnection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);
	
		if (!$this->dbConnection) {
			echo '<h2>Unable to connect to database server.</h2>';
			exit();
		}
	
		if ($query = $this->dbConnection->prepare('INSERT INTO order_items(order_id,item_id,quantity,size,color,gender) VALUES(?,?,?,?,?,?)')) {
			$query->bind_param('iiiiii', $orderID, $itemID, $quantity, $itemSize, $itemColor, $itemGender);
			$query->execute();
			echo $orderID;
			return 0;
		}
		return 1;
	}
	
	function DeleteOrderItem($orderID, $orderItemID) {
		$this->dbConnection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);
	
		if (!$this->dbConnection) {
			echo '<h2>Unable to connect to database server.</h2>';
			exit();
		}
	
		if ($query = $this->dbConnection->prepare('DELETE FROM order_items WHERE order_id=? AND order_item_id=?')) {
			$query->bind_param('ii', $orderID, $orderItemID);
			$query->execute();
			return 0;
		}
		return 1;
	}
	
	function GetOrderItemIDs() {
		return $this->orderItemIDs;
	}
	
	function GetOrderItemItemIDs() {
		return $this->orderItemItemIDs;
	}
	
	function GetOrderItemQuantities() {
		return $this->orderItemQuantities;
	}
	
	function GetOrderItemSizes() {
		return $this->orderItemSizes;
	}
	
	function GetOrderItemColors() {
		return $this->orderItemColors;
	}
	
	function GetOrderItemGenders() {
		return $this->orderItemGenders;
	}
}