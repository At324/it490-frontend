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

	require_once('rabbitMQLib.inc');
	require_once('get_host_info.inc');
	require_once('path.inc');
	$options = [
		'cost' => 11,
	];

	//retrieve input
	$username = $_POST['username'];
	$passwd = $_POST['password'];
	$hash = password_hash($passwd, PASSWORD_DEFAULT, $options);
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];

	$request = array();
	$request['type']="login";
	$request['username']="$user";
	$request['password']="$hash";
	$request['firstname']="$firstname";
	$request['lastname']="$lastname";

	$client = new rabbitMQClient("testRabbitMQ.ini", "testServer");

	$response = $client->send_request($request);
//$response = $client->publish($request);


?>


</body>

</html>

