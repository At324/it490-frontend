#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
require_once('databaseHelper.inc');

function doLogin($username,$password)
{
    $dbFunc = new DatabaseHelper(); 


    if(!$dbFunc->connect())
    {	
	return array("returnCode" => '1', 'message'=>"Error connecting to server");
    }


    $info = $dbFunc->getUserInfo($username, $password);
    //return $info;
    if($info)
    {	
	return (array('returnCode' => '0', 'message' => 'Login successful') + $info);
    }
    
    else
    {
	return (array("returnCode" => '1', 'message'=>"Login unsuccessful"));
    }

}

function doRegister($request)
{
    $dbFunc = new DatabaseHelper();
    
    if($dbFunc->registerUser($request['username'], $request['password'], $request['firstname'], $request['lastname'], $request['email']))
    {
	return array("returnCode" => '1', 'message'=>"Registration successful");
    }

    return array("returnCode" => '0', 'message'=>"<br>Registration unsuccessful<br>Username already exist!");
}

function logMessage($request)
{
	$logFile = fopen("log.txt", "a");

	fwrite($logFile, $request['message'] .'\n\n');

	return true;
}

function add2DMZ($request)
{
  $dbFunc = new DatabaseHelper();

  

}

function requestProcessor($request)
{
  echo "Request Received".PHP_EOL;
  var_dump($request);
  echo '\n' . 'End Message';
  if(!isset($request['type']))
  {
    return "ERROR: unsupported message type";
  }
  switch ($request['type'])
  {
    case "register":    
      return doRegister($request);
    case "login":
      return doLogin($request['username'],$request['password']);
    case "log":
      return logMessage($request);
   case "session";
      return sessionId($request);
    case "add2DMZ";
      return add2DMZ($request);
  }

  return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

$server = new rabbitMQServer("testRabbitMQ.ini","testServer");

$server->process_requests('requestProcessor');
exit();
?>
