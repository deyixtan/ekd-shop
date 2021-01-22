<?php
require_once __DIR__.'/../config.php';

class CreditCardModel {
	
	private $dbConnection;
	private $creditCardID;
	private $creditCardNumber;
	private $creditCardType;
	private $creditCardCCV;
	private $creditCardExpiryDate;
	private $creditCardCustomerID;
	
	function __construct($userID) {
		$this->dbConnection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);
		
		if (!$this->dbConnection) {
			echo '<h2>Unable to connect to database server.</h2>';
			exit();
		}
		
		if ($query = $this->dbConnection->prepare('SELECT * FROM credit_cards WHERE customer_id=?'))
		{
			$query->bind_param('i', $userID);
			$query->execute();
			$query->bind_result($creditCardID,
								$creditCardNumber,
								$creditCardType,
								$creditCardCCV,
								$creditCardExpiryDate,
								$creditCardCustomerID);
			
			$query->store_result();
			$resultRows = $query->num_rows;
			
			if ($resultRows > 0) {
				while ($query->fetch()) {
					$this->creditCardID = $creditCardID;
					$this->creditCardNumber = $creditCardNumber;
					$this->creditCardType = $creditCardType;
					$this->creditCardCCV = $creditCardCCV;
					$this->creditCardExpiryDate = $creditCardExpiryDate;
					$this->creditCardCustomerID = $creditCardCustomerID;
				}
			}
		}
	}
	
	function GetCreditCardID() {
		return $this->creditCardID;
	}
	
	function GetCreditCardNumber() {
		return $this->creditCardNumber;
	}
	
	function GetCreditCardType() {
		return $this->creditCardType;
	}
	
	function GetCreditCardCCV() {
		return $this->creditCardCCV;
	}
	
	function GetCreditCardExpiryDate() {
		return $this->creditCardExpiryDate;
	}
	
	function GetCreditCardCustomerID() {
		return $this->creditCardCustomerID;
	}
}