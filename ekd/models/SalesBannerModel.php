<?php
require_once __DIR__.'/../config.php';

class SalesBannerModel {
	
	private $dbConnection;
	private $salesBannerItemIDs;
	private $salesBannerImageURLs;
	
	function __construct() {
		$this->salesBannerItemIDs = array();
		$this->salesBannerImageURLs = array();
		
		$this->dbConnection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);
		
		if (!$this->dbConnection) {
			echo '<h2>Unable to connect to database server.</h2>';
			exit();
		}
		
		if ($query = $this->dbConnection->prepare('SELECT item_id,image_url FROM sales_banner'))
		{
			$query->execute();
			$query->bind_result($itemID, $imageURL);
			
			$query->store_result();
			$resultRows = $query->num_rows;
			
			if ($resultRows > 0) {
				while ($query->fetch()) {
					array_push($this->salesBannerItemIDs, $itemID);
					array_push($this->salesBannerImageURLs, $imageURL);
				}
			}
		}
	}
	
	function GetSalesBannerItemIDs() {
		return $this->salesBannerItemIDs;
	}
	
	function GetSalesBannerImageURLs() {
		return $this->salesBannerImageURLs;
	}
	
}