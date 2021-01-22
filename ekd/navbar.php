<!DOCTYPE html>
<html lang="en">
<head>
	<?php
	require_once __DIR__.'/config.php';
	require_once __DIR__.'/controllers/SessionManagementController.php';
	require_once __DIR__.'/controllers/StatusMessageController.php';
	require_once __DIR__.'/frameworks/bootstrap/bootstrap.php';
	require_once __DIR__.'/models/CustomerModel.php'; 
	?>
	<script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body>
	<div class="container">
		<nav class="navbar navbar-default">
			<div class="navbar-header">
				<a href="index.php" class="navbar-brand"><span class="glyphicon glyphicon-home"></span> EKD Shop</a>
			</div>
			<div>
				<ul class="nav navbar-nav">
					<li><a href="products.php"><span><img src="images/favicon.ico" height="16px" width="16px"></img></span>Products</a></li>
				</ul>
			</div>
			<div class="container-fluid">
				<ul class="nav navbar-nav navbar-right">
					<?php 
					$sessionManager = new SessionManagementController(SESSION_COOKIE_PATH);
					$sessionManager->UpdateActivity();
					if (isset($_SESSION['authenticated_id']) && isset($_SESSION['authenticated_email']) && isset($_SESSION['last_activity'])) {
						$customer = new CustomerModel();
						$customer->RetrieveCustomerInfo($_SESSION['authenticated_id']);
						$customerName = $customer->GetCustomerFullName();
						
						echo '<li><a href="shoppingCart.php"><span class="glyphicon glyphicon-shopping-cart"></span> Shopping Cart</a></li>';
						echo '<li class="dropdown">';
						echo '	<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span> '.$customerName.'<span class="caret"></span></a>';
						echo '	<ul class="dropdown-menu">';
						echo '		<li><a href="accountDetails.php">Account Details</a></li>';
						echo '		<li><a href="creditCardDetails.php">Credit Card Details</a></li>';
						echo '		<li><a href="pastOrders.php">Past Orders</a></li>';
						echo '		<li><a href="process/logout.php">Logout</a></li>';
						echo '	</ul>';
						echo '</li>';
					}
					else {
						echo '<li><a href="register.php">Register</a></li>';
						echo '<li><a href="#" data-toggle="modal" data-target="#loginModal">Sign In</a></li>';
					}
					?>
	          	</ul>
			</div>
		</nav>
		
		<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden = "true">
   			<div class="modal-dialog">
      			<div class="modal-content">
        			<div class="modal-header">
           				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
               				&times;
           				</button>
           				<h4 class = "modal-title" id = "myModalLabel">User Login</h4>
        			</div>
        			<form action="process/login.php" method="post">
          				<div class = "modal-body">
           					<label>Email:</label>
            				<input class="form-control" type="email" name="txtEmail" required="required"><br>
            				<label>Password:</label>
            				<input class="form-control" type="password" name="txtPassword" autocomplete="off" required="required"><br>
            				<div class="g-recaptcha" data-sitekey="<?php echo RECAPTCHA_CLIENT_KEY; ?>"></div>
         				</div>
         				<div class = "modal-footer">
            				<button type="submit" class="btn btn-primary" name="btnLogin">Login</button>
         				</div>
            		</form>
      			</div>
   			</div>
		</div>		
		<?php
		if (isset($_GET['loginStatus'])) {
			StatusMessageController::GetLoginMessage($_GET['loginStatus']);
		}
		?>
	</div>
</body>
</html>