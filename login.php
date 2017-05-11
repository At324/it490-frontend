
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
	$user = $_POST['username'];
	$passwd = $_POST['password'];

	$request = array();
	$request['type'] = "login";
	$request['username'] = "$user";
	$request['password'] = "$passwd";
	//retrieve input
	
	$client = new rabbitMQClient("testRabbitMQ.ini", "testServer");

	$response = $client->send_request($request);
?>


</body>

</html>

