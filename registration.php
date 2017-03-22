<!DOCTYPE html>
<html>

<style>
	body{
	background-color: #d3d3d3
	}
</style>

<head>Insomniacs</head><br><br>

<body>

<?php

	require_once('RmqClient.php');
	$options = [
		'cost' => 11,
	];

	//retrieve input
	$username = $_POST['username'];
	$passwd = $_POST['password'];
	$hash = password_hash($passwd, PASSWORD_DEFAULT, $options);
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];

	$client = new RmqClient();

	$client->sendRegister($username, $hash, $firstname, $lastname);

?>


</body>

</html>

