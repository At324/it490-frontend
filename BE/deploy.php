<?php

$version = 1.0

$client = new rabbitMQClient("deployRabbitMQ.ini", "deployServer");
$request = $array();
$request['type'] = "checkDeploy";
$request['version'] = $version;


$response = $client->send_request($request);

if()

?>