<?php
require_once __DIR__.'/../config.php';

class EmployeeModel {
	
	private $dbConnection;
	private $employeeID;
	private $employeeEmail;
	private $employeePassword;
	private $employeeFirstName;
	private $employeeLastName;
	private $employeeMobileNumber;
	private $employeeDOB;
	private $employeeAddress;
	
	private $employeeAuthID;
	private $employeeAuthEmail;
	
	function RetrieveEmployeeInfo($userID) {
		$this->dbConnection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);
		
		if (!$this->dbConnection) {
			echo '<h2>Unable to connect to database server.</h2>';
			exit();
		}
		
		if ($query = $this->dbConnection->prepare('SELECT * FROM employees WHERE employee_id=?'))
		{
			$query->bind_param('i', $userID);
			$query->execute();
			$query->bind_result($employeeID,
								$employeeEmail,
								$employeePassword,
								$employeeFirstName,
								$employeeLastName,
								$employeeMobileNumber,
								$employeeDOB,
								$employeeAddress);
			
			$query->store_result();
			$resultRows = $query->num_rows;
			
			if ($resultRows > 0) {
				while ($query->fetch()) {
					$this->employeeID = $employeeID;
					$this->employeeEmail = $employeeEmail;
					$this->employeePassword = $employeePassword;
					$this->employeeFirstName = $employeeFirstName;
					$this->employeeLastName = $employeeLastName;
					$this->employeeMobileNumber = $employeeMobileNumber;
					$this->employeeDOB = $employeeDOB;
					$this->employeeAddress = $employeeAddress;
				}
			}
		}
	}
	
	function CheckUserCredentials($userEmail, $userPassword) {
		$this->dbConnection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);
	
		if (!$this->dbConnection) {
			echo '<h2>Unable to connect to database server.</h2>';
			exit();
		}
	
		if ($query = $this->dbConnection->prepare('SELECT employee_id,email,password FROM employees WHERE email=?'))
		{
			$query->bind_param('s', $userEmail);
			$query->execute();
			$query->bind_result($employeeID, $employeeEmail, $employeePassword);
			
			$query->store_result();
			$resultRows = $query->num_rows;
	
			if ($resultRows == 1) { // must only have 1 result
				while ($query->fetch()) {
					if (password_verify($userPassword, $employeePassword)) {
						$this->employeeAuthID = $employeeID;
						$this->employeeAuthEmail = $employeeEmail;
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
	
		if ($query = $this->dbConnection->prepare('SELECT '.$field.' FROM employees'))
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
	
	function GetEmployeeID() {
		return $this->employeeID;
	}
	
	function GetEmployeeEmail() {
		return $this->employeeEmail;
	}
	
	function GetEmployeeFirstName() {
		return $this->employeeFirstName;
	}
	
	function GetEmployeeLastName() {
		return $this->employeeLastName;
	}
	
	function GetEmployeeFullName() {
		return $this->employeeFirstName.' '.$this->employeeLastName;
	}
	
	function GetEmployeeMobileNumber() {
		return $this->employeeMobileNumber;
	}
	
	function GetEmployeeDOB() {
		return $this->employeeDOB;
	}
	
	function GetEmployeeAddress() {
		return $this->employeeAddress;
	}
	
	function GetEmployeeAuthID() {
		return $this->employeeAuthID;
	}
	
	function GetEmployeeAuthEmail() {
		return $this->employeeAuthEmail;
	}
}