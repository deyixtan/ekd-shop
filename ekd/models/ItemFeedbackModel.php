<?php
require_once __DIR__.'/../config.php';

class ItemFeedbackModel {

	private $dbConnection;
	private $itemFeedbackItemID;
	private $itemFeedbackIDs;
	private $itemFeedbackCustomerIDs;
	private $itemFeedbackMessages;
	private $itemFeedbackDateTimes;
	
	function __construct($itemID) {
		$this->itemFeedbackItemID = $itemID;
		$this->itemFeedbackIDs = array();
		$this->itemFeedbackCustomerIDs = array();
		$this->itemFeedbackMessages = array();
		$this->itemFeedbackDateTimes = array();
		
		$this->dbConnection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);
		
		if (!$this->dbConnection) {
			echo '<h2>Unable to connect to database server.</h2>';
			exit();
		}
		
		if ($query = $this->dbConnection->prepare('SELECT item_feedback_id,customer_id,message,datetime FROM item_feedbacks WHERE item_id=?')) {
			$query->bind_param('i', $itemID);
			$query->execute();
			$query->bind_result($itemFeedbackID, $itemFeedbackCustomerID, $itemFeedbackMessage, $itemFeedbackDateTime);
				
			$query->store_result();
			$resultRows = $query->num_rows;
				
			if ($resultRows > 0) {
				while ($query->fetch()) {
					array_push($this->itemFeedbackIDs, $itemFeedbackID);
					array_push($this->itemFeedbackCustomerIDs, $itemFeedbackCustomerID);
					array_push($this->itemFeedbackDateTimes, $itemFeedbackDateTime);
					array_push($this->itemFeedbackMessages, $itemFeedbackMessage);
				}
			}
		}
	}
		
	function SubmitFeedback($userID, $text) {
		$this->dbConnection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);
	
		if (!$this->dbConnection) {
			echo '<h2>Unable to connect to database server.</h2>';
			exit();
		}
	
		date_default_timezone_set('Asia/Singapore');
		$datetime = new DateTime();
		$datetime = $datetime->format('Y-m-d H:i:s');
		if ($query = $this->dbConnection->prepare('INSERT INTO item_feedbacks(customer_id,item_id,message,datetime) VALUES(?,?,?,?)')) {
			$query->bind_param('iiss', $userID, $this->itemFeedbackItemID, $text, $datetime);
			$query->execute();
		}
	}
	
	function DeleteFeedback($feedbackID) {
		$this->dbConnection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);
	
		if (!$this->dbConnection) {
			echo '<h2>Unable to connect to database server.</h2>';
			exit();
		}
	
		if ($query = $this->dbConnection->prepare('DELETE FROM item_feedbacks WHERE item_feedback_id=?')) {
			$query->bind_param('i', $feedbackID);
			$query->execute();
		}
	}
	
	function GetItemFeedbackIDArray() {
		return $this->itemFeedbackIDs;
	}
	
	function GetItemFeedbackCustomerIDArray() {
		return $this->itemFeedbackCustomerIDs;
	}
	
	function GetItemFeedbackMessageArray() {
		return $this->itemFeedbackMessages;
	}
	
	function GetItemFeedbackDateTimeArray() {
		return $this->itemFeedbackDateTimes;
	}
}