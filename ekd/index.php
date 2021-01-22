<!DOCTYPE html>
<html lang="en">
<head>
	<?php 
	require_once __DIR__.'/navbar.php';
	require_once __DIR__.'/controllers/StatusMessageController.php'; 
	?>
	<title>EKD Shop</title>
</head>
<body background="images/background.png" style="background-color:black;">
	<div class="container">
		<?php 
		if (isset($_GET['timeoutStatus'])) {
			echo StatusMessageController::GetTimeoutMessage($_GET['timeoutStatus']); 
		}
		?>	
		<a href="products.php"><img class="img-responsive" src="images/homepage.jpg" style="width:100%; height:400px;"></a><br>
		<div class="jumbotron">
			<h2>Background</h2>
			<p>During the 1997 Asian Financial Crisis, it severely impacted our families badly and caused us to be financially crippled. We were unable to meet the basic needs, like a pair of walking shoes. While attending government subsidized schools, we were always jealous of other students as our shoes are way inferior as compared to them. Sparkling, clean, white or even a walkable pair of shoes is something we could not afford those times. We will always wonder about what is the feeling of wearing such shoes. After we grew up, we were very fortunate to be able to receive a pair of neat, clean and comfortable shoes that we were denied since young. The feeling of putting on the shoes on our feet for the very first time felt like heaven. And the first baby step we walk with it felt like we were walking on clouds. That soft and bouncy feeling was indescribable. Therefore, we would like to give that feeling back to the society.</p><br>
			<h2>Our Goal</h2> 
			<p>Our ultimate goal is to provide consumers with not only cheap, but durable and fashionable pairs of shoes that is filled with our love and gratitude. We hope that all our consumers will be able to experience that very same feeling that we had when we wore our very first shoe.</p><br>
			<h2>Our Team</h2>
			<ol class="h3">
				<li><a href="https://www.facebook.com/Aiyooooooooo" style="color:black;">Kok Ee Shi</a></li>
				<li><a href="https://www.facebook.com/kenneth.seah" style="color:black;">Kenneth Seah</a></li>
				<li><a href="https://www.facebook.com/tdy0123" style="color:black;">Tan De Yi</a></li>
			</ol>
		</div>
	</div>
</body>
</html>