<!DOCTYPE html>
<html lang="en">
<head>
	<?php require_once __DIR__.'/navbar.php';?>
	<?php require_once __DIR__.'/models/ItemModel.php';?>
	<?php require_once __DIR__.'/models/SalesBannerModel.php';?>
	<title>Our Products</title>
</head>

<body background="images/background.png" style="background-color:black;">
	<div class="container">
		<?php
		$salesBanner = new SalesBannerModel();
		$salesBannerItemIDs = $salesBanner->GetSalesBannerItemIDs();
		$salesBannerImageURLs = $salesBanner->GetSalesBannerImageURLs();
		
		if (!empty($salesBannerItemIDs) && !empty($salesBannerImageURLs)) {
			// Banner
			echo '<div id="myCarousel" class="carousel slide" data-ride="carousel" style="background-color: white;border: 1px solid grey">';
			echo '	<div class="carousel-inner" role="listbox">';
		
			foreach ($salesBannerImageURLs as $imageIndex => $imageURL) {
				if ($imageIndex == 0) {
					echo '		<div class="item active" align="center">';
				}
				else {
					echo '		<div class="item" align="center">';
				}
				if ($salesBannerItemIDs[$imageIndex] != null) {
					echo '				<a href="itemInfo.php?id='.$salesBannerItemIDs[$imageIndex].'" style="text-decoration:none;"><img style="width:100%;height:400px;" src="'.$imageURL.'"></a>';
				}
				else {
					echo '				<img style="width:100%;height:400px;" src="'.$imageURL.'">';
				}
				echo '		</div>';
			}	
			echo '	</div>';
		
			// Carousel slider buttons
			echo '	<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">';
    		echo '		<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>';
    		echo '		<span class="sr-only">Previous</span>';
  			echo '	</a>';
  			echo '	<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">';
    		echo '		<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>';
    		echo '		<span class="sr-only">Next</span>';
  			echo '	</a>';
			echo '</div><br><br>';
		}
		?>
		<!-- Side Bar -->
		<div class="col-md-3">
			<div class="row">
				<div class="col-md-12" style="background-color: #006400; border: 1px solid black"><br>
					<form action="products.php" method="get">
						<input class="form-control" type="text" name="txtSearch" style="border: 1px solid black" placeholder="Item" required><br>					
						<button class="form-control btn-warning" type="submit" style="border: 1px solid black">
							<span class="glyphicon glyphicon-search"></span> Search
						</button>
					</form><br>
				</div>
			</div><br><br>
			<div class="row">
				<div class="col-md-12 nav-stacked" style="background-color: #006400; border: 1px solid black"><br>
				   <a href="products.php?gender=0" style="text-decoration:none;"><button class="form-control btn-warning" style="border: 1px solid black">All</button></a><br>
				   <a href="products.php?gender=1" style="text-decoration:none;"><button class="form-control btn-warning" style="border: 1px solid black">MEN'S FOOTWEAR</button></a><br>
				   <a href="products.php?gender=2" style="text-decoration:none;"><button class="form-control btn-warning" style="border: 1px solid black">WOMEN'S FOOTWEAR</button></a><br>
				</div>
			</div>
		</div>
		<!-- Products -->
		<div class="col-md-9" style="background-color: lightgrey; border: 1px solid grey;"><br>
			<?php
			$itemArr = array();
			$products = new ItemModel();

			if (isset($_COOKIE['sortType']) && $_COOKIE['sortType'] >= 0 && $_COOKIE['sortType'] <= 3) {
				if (isset($_GET['txtSearch'])) {
					$_GET['txtSearch'] = preg_replace(PATTERN_DENYXSS, '', $_GET['txtSearch']);
					$itemArr = $products->GetItemsByKeywords(filter_var($_GET['txtSearch'], FILTER_SANITIZE_STRING), $_COOKIE['sortType']);
				}
				else if (isset($_GET['gender'])) {
					$_GET['gender'] = preg_replace(PATTERN_DENYXSS, '', $_GET['gender']);
					switch ($_GET['gender']) {
						case 1:
							$itemArr = $products->GetItemsByGender('male', $_COOKIE['sortType']);
							break;
						case 2:
							$itemArr = $products->GetItemsByGender('female', $_COOKIE['sortType']);
							break;
						case 0:
						default:
							$itemArr = $products->GetAllItems($_COOKIE['sortType']);
					}
				}
				else {
					$itemArr = $products->GetAllItems($_COOKIE['sortType']);
				}
			}
			else {
				if (isset($_GET['txtSearch'])) {
					$_GET['txtSearch'] = preg_replace(PATTERN_DENYXSS, '', $_GET['txtSearch']);
					$itemArr = $products->GetItemsByKeywords(filter_var($_GET['txtSearch'], FILTER_SANITIZE_STRING), 0);
				}
				else if (isset($_GET['gender'])) {
					$_GET['gender'] = preg_replace(PATTERN_DENYXSS, '', $_GET['gender']);
					switch ($_GET['gender']) {
						case 1:
							$itemArr = $products->GetItemsByGender('male', 0);
							break;
						case 2:
							$itemArr = $products->GetItemsByGender('female', 0);
							break;
						case 0:
						default:
							$itemArr = $products->GetAllItems(0);
					}
				}
				else {
					$itemArr = $products->GetAllItems(0);
				}
			}
			
			// Sort Form
			echo '<form action="process/sortProducts.php" method="post">';
			echo '	<label class="form-control">SORT BY</label>';
			if (isset($_GET['txtSearch'])) {
				echo '<input type="hidden" name="txtSearch" value="'.$_GET['txtSearch'].'">';
			}
			else if (isset($_GET['gender'])) {
				echo '<input type="hidden" name="gender" value="'.$_GET['gender'].'">';
			}
			echo '	<select class="form-control" name="sortType" onchange="this.form.submit()">';
			echo '		<option value="0" '.((isset($_COOKIE['sortType']) && $_COOKIE['sortType']==0)?'selected="selected"':"").'>Default</option>';
			echo '		<option value="1" '.((isset($_COOKIE['sortType']) && $_COOKIE['sortType']==1)?'selected="selected"':"").'>Lastest Arrival</option>';
			echo '		<option value="2" '.((isset($_COOKIE['sortType']) && $_COOKIE['sortType']==2)?'selected="selected"':"").'>Lowest Price</option>';
			echo '		<option value="3" '.((isset($_COOKIE['sortType']) && $_COOKIE['sortType']==3)?'selected="selected"':"").'>Highest Price</option>';
			echo '	</select><br>';
			echo '</form>';	
			
			// Display Products
			if (!empty($itemArr)) {
				foreach ($itemArr as $index => $itemID) {
					$products->RetrieveItemInfo($itemID);
					$images = explode(',', $products->GetItemImageURL());
					echo '<div class="col-md-2">';
					echo '	<a href="itemInfo.php?id='.$products->GetItemID().'" class="thumbnail" style="text-decoration:none;color:black;width:150px;height:200px;border:2px solid grey">';
					echo '		<strong>'.$products->GetItemName().'</strong>';
					echo '		<img class="container-fluid img-responsive" src="'.$images[0].'"  style="max-height:50%"><br>';
					echo '		<h5>Price: SGD '.number_format($products->GetItemPrice(), 2).'</h5>';				
					echo '	</a>';			
					echo '</div>';
					echo '<div class="col-md-1">';
					echo '</div>';
				}
			}
			else {
				echo '<div>';
				echo '	<h4 align="center" style="color:red">Unable to search such item.</h4>';
				echo '</div>';
			}
			echo '</div>';
			?>
		</div><br><br><br><br>
		
	</div>
</body>
</html>