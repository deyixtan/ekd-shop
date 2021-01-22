<?php

if (isset($_GET['text'])) {
	$hashedPassword = password_hash($_GET['text'], PASSWORD_DEFAULT);
	echo 'Your input value: '.$_GET['text'].'<br>';
	echo 'Your hashed value: '.$hashedPassword.'<br>';
}
else {
	echo 'Provide a string to the "text" query parameter in the URL';
}