<?php
require_once __DIR__.'/../config.php';

class OrderModel {
	
	private $dbConnection;
	private $userID;
	private $orderID;
	private $orderCustomerID;
	private $orderTotalCost;
	private $orderStatus;
	private $orderDeliveryDate;
	private $orderRemarks;

	function __construct($userID) {
		$this->userID = $userID;
		
		$this->dbConnection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);
		
		if (!$this->dbConnection) {
			echo '<h2>Unable to connect to database server.</h2>';
			exit();
		}
		
		if ($query = $this->dbConnection->prepare('SELECT * FROM orders WHERE customer_id=?')) {
			$query->bind_param('i', $userID);
			$query->execute();
			$query->bind_result($orderID,
								$orderCustomerID,
								$orderTotalCost,
								$orderStatus,
								$orderDeliveryDate,
								$orderRemarks);
				
			$query->store_result();
			$resultRows = $query->num_rows;
				
			if ($resultRows > 0) {
				while ($query->fetch()) {
					$this->orderID = $orderID;
					$this->orderCustomerID = $orderCustomerID;
					$this->orderTotalCost = $orderTotalCost;
					$this->orderStatus = $orderStatus;
					$this->orderDeliveryDate = $orderDeliveryDate;
					$this->orderRemarks = $orderRemarks;
				}
			}
		}
	}
	
	function UpdateOrderStatus($status, $totalCost, $remarks) {
		$this->dbConnection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);
	
		if (!$this->dbConnection) {
			echo '<h2>Unable to connect to database server.</h2>';
			exit();
		}
	
		$deliveryDate = date('Y-m-d', strtotime('+7 days'));
		if ($query = $this->dbConnection->prepare('UPDATE orders SET total_cost=?,status=?,delivery_date=?,remarks=? WHERE order_id=?')) {
			$query->bind_param('iissi', $totalCost, $status, $deliveryDate, $remarks, $this->orderID);
			$query->execute();
			return 0;
		}
		return 1;
	}
	
	function GetOrderID() {
		$status = 0;
		$total_cost = 0;
		$delivery_date = null;
		$remarks = null;
	
		$this->dbConnection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);
	
		if (!$this->dbConnection) {
			echo '<h2>Unable to connect to database server.</h2>';
			exit();
		}
	
		if ($query = $this->dbConnection->prepare('SELECT order_id FROM orders WHERE customer_id=? AND status=?')) {
			$query->bind_param('ii', $this->userID, $status);
			$query->execute();
			$query->bind_result($orderID);
	
			$query->store_result();
			$resultRows = $query->num_rows;
	
			if ($resultRows > 0) {
				while ($query->fetch()) {
					$this->orderID = $orderID;
					return $this->orderID;
				}
			}
		}
	
		if ($query = $this->dbConnection->prepare('INSERT INTO orders(customer_id,total_cost,status,delivery_date,remarks) VALUES(?,?,?,?,?)')) {
			$query->bind_param('iiiss', $this->userID, $total_cost, $status, $delivery_date, $remarks);
			$query->execute();
			$this->orderID = $query->insert_id;
			return $this->orderID;
		}
		return 0;
	}
	
	function GetOrderCustomerID() {
		return $this->orderCustomerID;
	}
	
	function GetOrderTotalCost() {
		return $this->orderTotalCost;
	}
	
	function GetOrderStatus() {
		return $this->orderStatus;
	}
	
	function GetOrderDeliveryDate() {
		return $this->orderDeliveryDate;
	}
	
	function GetOrderRemarks() {
		return $this->orderRemarks;
	}
	
	function GetPastOrderIDs() {
		$this->dbConnection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);
		
		if (!$this->dbConnection) {
			echo '<h2>Unable to connect to database server.</h2>';
			exit();
		}
		
		if ($query = $this->dbConnection->prepare('SELECT order_id FROM orders WHERE customer_id=? AND status=1 OR status=2')) {
			$query->bind_param('i', $this->userID);
			$query->execute();
			$query->bind_result($orderID);
				
			$query->store_result();
			$resultRows = $query->num_rows;
				
			$orderIDs = array();
			if ($resultRows > 0) {
				while ($query->fetch())
					array_push($orderIDs, $orderID);
				return $orderIDs;
			}
		}
		return 0;
	}
	
	function GetPastOrderTotalCosts() {
		$this->dbConnection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);
		
		if (!$this->dbConnection) {
			echo '<h2>Unable to connect to database server.</h2>';
			exit();
		}
		
		if ($query = $this->dbConnection->prepare('SELECT total_cost FROM orders WHERE customer_id=? AND status=1 OR status=2')) {
			$query->bind_param('i', $this->userID);
			$query->execute();
			$query->bind_result($orderTotalCost);
		
			$query->store_result();
			$resultRows = $query->num_rows;
		
			$orderTotalCosts = array();
			if ($resultRows > 0) {
				while ($query->fetch())
					array_push($orderTotalCosts, $orderTotalCost);
				return $orderTotalCosts;
			}
		}
		return 0;
	}
	
	function GetPastOrderStatuses() {
		$this->dbConnection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);
		
		if (!$this->dbConnection) {
			echo '<h2>Unable to connect to database server.</h2>';
			exit();
		}
		
		if ($query = $this->dbConnection->prepare('SELECT status FROM orders WHERE customer_id=? AND status=1 OR status=2')) {
			$query->bind_param('i', $this->userID);
			$query->execute();
			$query->bind_result($orderStatus);
		
			$query->store_result();
			$resultRows = $query->num_rows;
		
			$orderStatuses = array();
			if ($resultRows > 0) {
				while ($query->fetch())
					array_push($orderStatuses, $orderStatus);
				return $orderStatuses;
			}
		}
		return 0;
	}
	
	function GetPastOrderDeliveryDates() {
		$this->dbConnection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);
		
		if (!$this->dbConnection) {
			echo '<h2>Unable to connect to database server.</h2>';
			exit();
		}
		
		if ($query = $this->dbConnection->prepare('SELECT delivery_date FROM orders WHERE customer_id=? AND status=1 OR status=2')) {
			$query->bind_param('i', $this->userID);
			$query->execute();
			$query->bind_result($orderDeliveryDate);
		
			$query->store_result();
			$resultRows = $query->num_rows;
		
			$orderDeliveryDates = array();
			if ($resultRows > 0) {
				while ($query->fetch())
					array_push($orderDeliveryDates, $orderDeliveryDate);
				return $orderDeliveryDates;
			}
		}
		return 0;
	}
	
	function GetPastOrderRemarks() {
		$this->dbConnection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);
		
		if (!$this->dbConnection) {
			echo '<h2>Unable to connect to database server.</h2>';
			exit();
		}
		
		if ($query = $this->dbConnection->prepare('SELECT remarks FROM orders WHERE customer_id=? AND status=1 OR status=2')) {
			$query->bind_param('i', $this->userID);
			$query->execute();
			$query->bind_result($orderRemarks);
		
			$query->store_result();
			$resultRows = $query->num_rows;
		
			$orderRemarkss = array();
			if ($resultRows > 0) {
				while ($query->fetch())
					array_push($orderRemarkss, $orderRemarks);
				return $orderRemarkss;
			}
		}
		return 0;
	}
}