<?php

if (isset($_POST['sortType'])) {
	setcookie('sortType', $_POST['sortType'], time()+(60*60*24*7), '/ekd', null, true, true); // cookie last 7 days
	header('Location: '.$_SERVER['HTTP_REFERER']);
	exit();
}

header('Location: ../index.php');