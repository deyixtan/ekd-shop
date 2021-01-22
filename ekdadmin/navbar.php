<!DOCTYPE html>
<html lang="en">
<head>
	<?php
	require_once __DIR__.'/config.php';
	require_once __DIR__.'/controllers/SessionManagementController.php';
	require_once __DIR__.'/controllers/StatusMessageController.php';
	require_once __DIR__.'/models/EmployeeModel.php';
	require_once __DIR__.'/frameworks/bootstrap/bootstrap.php';
	?>
</head>
<body>
	<div class="container">
		<nav class="navbar navbar-default">
			<div class="navbar-header">
				<a href="index.php" class="navbar-brand"><span class="glyphicon glyphicon-home"></span> EKD Admin Panel</a>
			</div>
			<ul class="nav navbar-nav">
				<?php 
				$sessionManager = new SessionManagementController(SESSION_COOKIE_PATH);
				$sessionManager->UpdateActivity();
				if (isset($_SESSION['authenticated_id']) && isset($_SESSION['authenticated_email']) && isset($_SESSION['last_activity'])) {
					$employee = new EmployeeModel();
					$employee->RetrieveEmployeeInfo($_SESSION['authenticated_id']);
					$employeeName = $employee->GetEmployeeFullName();
					
					echo '	<li class="dropdown">';
					echo '		<a href="#" class="dropdown-toggle" data-toggle="dropdown">Actions<span class="caret"></span></a>';
					echo '		<ul class="dropdown-menu">';
					echo '			<li><a href="addItem.php">Add Item</a></li>';
					echo '			<li><a href="modifyItem.php">Modify Item</a></li>';
					echo '			<li><a href="removeItem.php">Remove Item</a></li>';
					echo '			<li><a href="updateOrders.php">Update Orders</a></li>';
					echo '		</ul>';
					echo '	</li>';
					echo '</ul>';
					echo '<div class="container-fluid">';
					echo '	<ul class="nav navbar-nav navbar-right">';
					echo '		<li class="dropdown">';
					echo '			<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span> '.$employeeName.'<span class="caret"></span></a>';
					echo '			<ul class="dropdown-menu">';
					echo '				<li><a href="accountDetails.php">Account Details</a></li>';
					echo '				<li><a href="process/logout.php">Logout</a></li>';
					echo '			</ul>';
					echo '		</li>';
					echo '	</ul>';
					echo '</div>';
				}
				?>
          	</ul>
		</nav>
		<?php
		if (isset($_GET['loginStatus'])) {
			StatusMessageController::GetLoginMessage($_GET['loginStatus']);
		}
		?>
	</div>
</body>
</html>