<?php

require_once __DIR__.'/../config.php';

class ItemModel {
	
	private $dbConnection;
	private $itemID;
	private $itemName;
	private $itemDescription;
	private $itemSize;
	private $itemColor;
	private $itemGender;
	private $itemPrice;
	private $itemStockQuantity;
	private $itemImageURL;
	private $itemEmployeeID;
	
	function RetrieveItemInfo($itemID) {
		$this->dbConnection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);
		
		if (!$this->dbConnection) {
			echo '<h2>Unable to connect to database server.</h2>';
			exit();
		}
		
		if ($query = $this->dbConnection->prepare('SELECT * FROM items WHERE item_id=?'))
		{
			$query->bind_param('i', $itemID);
			$query->execute();
			$query->bind_result($itemID,
								$itemName,
								$itemDescription,
								$itemSize,
								$itemColor,
								$itemGender,
								$itemPrice,
								$itemStockQuantity,
								$itemImageURL,
								$itemEmployeeID);
			
			$query->store_result();
			$resultRows = $query->num_rows;
			
			if ($resultRows > 0) {
				while ($query->fetch()) {
					$this->itemID = $itemID;
					$this->itemName = $itemName;
					$this->itemDescription = $itemDescription;
					$this->itemSize = $itemSize;
					$this->itemColor = $itemColor;
					$this->itemGender = $itemGender;
					$this->itemPrice = $itemPrice;
					$this->itemStockQuantity = $itemStockQuantity;
					$this->itemImageURL = $itemImageURL;
					$this->itemEmployeeID = $itemEmployeeID;
				}
			}
		}
	}
	
	function GetItemID() {
		return $this->itemID;
	}
	
	function GetItemName() {
		return $this->itemName;
	}
	
	function GetItemDescription() {
		return $this->itemDescription;
	}
	
	function GetItemSize() {
		return $this->itemSize;
	}
	
	function GetItemColor() {
		return $this->itemColor;
	}
	
	function GetItemGender() {
		return $this->itemGender;
	}
	
	function GetItemPrice() {
		return $this->itemPrice;
	}
	
	function GetItemStockQuantity() {
		return $this->itemStockQuantity;
	}
	
	function GetItemImageURL() {
		return $this->itemImageURL;
	}
	
	function GetItemEmployeeID() {
		return $this->itemEmployeeID;
	}
	
	function DecrementItemStockQuantity($quantity) {
		$this->dbConnection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);
	
		if (!$this->dbConnection) {
			echo '<h2>Unable to connect to database server.</h2>';
			exit();
		}
		
		$decrementedStock = $this->itemStockQuantity-$quantity;
		if ($query = $this->dbConnection->prepare('UPDATE items SET stock_quantity=? WHERE item_id=?')) {
			$query->bind_param('ii', $decrementedStock, $this->itemID);
			$query->execute();
			return 0;
		}
		return 1;
	}
	
	function GetAllItems($sortType) {
		$itemArr = array();
		
		$dbConnection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);
		
		if (!$dbConnection) {
			echo '<h2>Unable to connect to database server.</h2>';
			exit();
		}
		
		if ($query = $dbConnection->prepare('SELECT item_id FROM items WHERE stock_quantity>0'))
		{
			$query->execute();
			$query->bind_result($itemID);
			
			$query->store_result();
			$resultRows = $query->num_rows;
			
			if ($resultRows > 0) {
				while ($query->fetch()) {
					array_push($itemArr, $itemID);
				}
				
				switch ($sortType) {
					case 1:
						$itemArr = $this->GetItemArrayByLatestArrival($itemArr);
						break;
					case 2:
						$itemArr = $this->GetItemArrayByLowestPrice($itemArr);
						break;
					case 3:
						$itemArr = $this->GetItemArrayByHighestPrice($itemArr);
						break;
					case 0:
					default:
						$itemArr = $this->GetItemArray($itemArr);
				}
				return $itemArr;
			}
		}
		return null;
	}
	
	function GetItemsByKeywords($keyword, $sortType) {
		$keyword = filter_var($keyword, FILTER_SANITIZE_STRING);
		$keyword = '%'.$keyword.'%';
		$itemArr = array();
		
		$dbConnection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);
		
		if (!$dbConnection) {
			echo '<h2>Unable to connect to database server.</h2>';
			exit();
		}
		
		if ($query = $dbConnection->prepare('SELECT item_id FROM items WHERE item_name LIKE ? OR description LIKE ? AND stock_quantity>0'))
		{
			$query->bind_param('ss', $keyword, $keyword);
			$query->execute();
			$query->bind_result($itemID);
				
			$query->store_result();
			$resultRows = $query->num_rows;
				
			if ($resultRows > 0) {
				while ($query->fetch()) {
					array_push($itemArr, $itemID);
				}
				
				switch ($sortType) {
					case 1:
						$itemArr = $this->GetItemArrayByLatestArrival($itemArr);
						break;
					case 2:
						$itemArr = $this->GetItemArrayByLowestPrice($itemArr);
						break;
					case 3:
						$itemArr = $this->GetItemArrayByHighestPrice($itemArr);
						break;
					case 0:
					default:
						$itemArr = $this->GetItemArray($itemArr);
				}
				return $itemArr;
			}
		}
		return null;
	}
	
	function GetItemsByGender($gender, $sortType) {
		$gender = filter_var($gender, FILTER_SANITIZE_STRING);
		$gender = $gender.'%';
		$itemArr = array();
	
		$dbConnection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);
	
		if (!$dbConnection) {
			echo '<h2>Unable to connect to database server.</h2>';
			exit();
		}
	
		if ($query = $dbConnection->prepare('SELECT item_id FROM items WHERE gender LIKE ? stock_quantity>0'))
		{
			$query->bind_param('s', $gender);
			$query->execute();
			$query->bind_result($itemID);
	
			$query->store_result();
			$resultRows = $query->num_rows;
	
			if ($resultRows > 0) {
				while ($query->fetch()) {
					array_push($itemArr, $itemID);
				}
				
				switch ($sortType) {
					case 1:
						$itemArr = $this->GetItemArrayByLatestArrival($itemArr);
						break;
					case 2:
						$itemArr = $this->GetItemArrayByLowestPrice($itemArr);
						break;
					case 3:
						$itemArr = $this->GetItemArrayByHighestPrice($itemArr);
						break;
					case 0:
					default:
						$itemArr = $this->GetItemArray($itemArr);
				}
				return $itemArr;
			}
		}
		return null;
	}
	
	private function GetItemArray($itemArr) {
		return $itemArr;
	}
	
	private function GetItemArrayByLatestArrival($itemArr) {
		rsort($itemArr);
		return $itemArr;
	}
	
	private function GetItemArrayByLowestPrice($itemArr) {
		$itemArrPrice = array();
		foreach ($itemArr as $key => $itemID) {
			$this->RetrieveItemInfo($itemID);
			$price = $this->GetItemPrice();
			$itemArrPrice[$key] = $price;
		}
		array_multisort($itemArrPrice, SORT_ASC, $itemArr);
		return $itemArr;
	}
	
	private function GetItemArrayByHighestPrice($itemArr) {
		$itemArrPrice = array();
		foreach ($itemArr as $key => $itemID) {
			$this->RetrieveItemInfo($itemID);
			$price = $this->GetItemPrice();
			$itemArrPrice[$key] = $price;
		}
		array_multisort($itemArrPrice, SORT_DESC, $itemArr);
		return $itemArr;
	}
}