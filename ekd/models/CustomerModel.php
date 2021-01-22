<?php
require_once __DIR__.'/../config.php';

class CustomerModel {
	
	private $dbConnection;
	private $customerID;
	private $customerEmail;
	private $customerPassword;
	private $customerFirstName;
	private $customerLastName;
	private $customerMobileNumber;
	private $customerDOB;
	private $customerAddress;
	
	private $customerAuthID;
	private $customerAuthEmail;
	
	function RetrieveCustomerInfo($userID) {
		$this->dbConnection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);
		
		if (!$this->dbConnection) {
			echo '<h2>Unable to connect to database server.</h2>';
			exit();
		}
		
		if ($query = $this->dbConnection->prepare('SELECT * FROM customers WHERE customer_id=?'))
		{
			$query->bind_param('i', $userID);
			$query->execute();
			$query->bind_result($customerID,
								$customerEmail,
								$customerPassword,
								$customerFirstName,
								$customerLastName,
								$customerMobileNumber,
								$customerDOB,
								$customerAddress);
			
			$query->store_result();
			$resultRows = $query->num_rows;
			
			if ($resultRows > 0) {
				while ($query->fetch()) {
					$this->customerID = $customerID;
					$this->customerEmail = $customerEmail;
					$this->customerPassword = $customerPassword;
					$this->customerFirstName = $customerFirstName;
					$this->customerLastName = $customerLastName;
					$this->customerMobileNumber = $customerMobileNumber;
					$this->customerDOB = $customerDOB;
					$this->customerAddress = $customerAddress;
				}
			}
		}
	}
	
	function RegisterUser($userEmail, $userPassword, $userPassword2, $userFirstName, $userLastName, $userMobileNumber, $userDOB, $userAddress) {
		$hashedPassword = password_hash($userPassword, PASSWORD_DEFAULT);
		
		$this->dbConnection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);
		
		if (!$this->dbConnection) {
			echo '<h2>Unable to connect to database server.</h2>';
			exit();
		}
		
		if ($query = $this->dbConnection->prepare('SELECT customer_id FROM customers WHERE email=?'))
		{
			$query->bind_param('s', $userEmail);
			$query->execute();
		
			$query->store_result();
			$resultRows = $query->num_rows;
		
			if ($resultRows > 0) { // must have no results
				return 1;
			}
		}
		
		if ($query = $this->dbConnection->prepare('INSERT INTO customers(email,password,first_name,last_name,mobile_number,dob,address) VALUES(?,?,?,?,?,?,?)'))
		{
			$query->bind_param('ssssiss', $userEmail, $hashedPassword, $userFirstName, $userLastName, $userMobileNumber, $userDOB, $userAddress);
			$query->execute();
			return 0;
		}
		return 2;
	}
	
	function CheckUserCredentials($userEmail, $userPassword) {
		$this->dbConnection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);
		
		if (!$this->dbConnection) {
			echo '<h2>Unable to connect to database server.</h2>';
			exit();
		}
		
		if ($query = $this->dbConnection->prepare('SELECT customer_id,email,password FROM customers WHERE email=?'))
		{
			$query->bind_param('s', $userEmail);
			$query->execute();
			$query->bind_result($customerID, $customerEmail, $customerPassword);
			
			$query->store_result();
			$resultRows = $query->num_rows;
		
			if ($resultRows == 1) { // must only have 1 result
				while ($query->fetch()) {
					if (password_verify($userPassword, $customerPassword)) {
						$this->customerAuthID = $customerID;
						$this->customerAuthEmail = $customerEmail;
						return true;
					}
					else {
						return false;
					}
				}
			}
			else {
				return false;
			}
		}
		return false;
	}
	
	function CheckFieldAvailability($field) {
		$this->dbConnection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);
		
		if (!$this->dbConnection) {
			echo '<h2>Unable to connect to database server.</h2>';
			exit();
		}
		
		if ($query = $this->dbConnection->prepare('SELECT '.$field.' FROM customers'))
		{
			$query->execute();
				
			$query->store_result();
			$resultRows = $query->num_rows;
		
			if ($resultRows == 0) {
				return true;
			}
		}
		return false;
	}
	
	function GetCustomerID() {
		return $this->customerID;
	}
	
	function GetCustomerEmail() {
		return $this->customerEmail;
	}
	
	function GetCustomerFirstName() {
		return $this->customerFirstName;
	}
	
	function GetCustomerLastName() {
		return $this->customerLastName;
	}
	
	function GetCustomerFullName() {
		return $this->customerFirstName.' '.$this->customerLastName;
	}
	
	function GetCustomerMobileNumber() {
		return $this->customerMobileNumber;
	}
	
	function GetCustomerDOB() {
		return $this->customerDOB;
	}
	
	function GetCustomerAddress() {
		return $this->customerAddress;
	}
	
	function GetCustomerAuthID() {
		return $this->customerAuthID;
	}
	
	function GetCustomerAuthEmail() {
		return $this->customerAuthEmail;
	}
}