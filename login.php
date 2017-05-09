
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
	$user = $_POST['username'];
	$passwd = $_POST['password'];

	$client = new rabbitMQClient("testRabbitMQ.ini","testServer");
	$request = $array();
	$request['type'] = "login";
	$request['username'] = "$user";
	$request['password'] = "$passwd";
	//retrieve input
	
	$response = $client->send_request($request);

	print_r($response);
?>


</body>

</html>

