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
	$user = $_POST['username'];
	$passwd = $_POST['password'];
	$hash = password_hash($passwd, PASSWORD_BCRYPT, $options);

	$client = new RmqClient();

	$client->sendLogin($user, $hash);

?>


</body>

</html>

