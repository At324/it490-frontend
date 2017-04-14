 #!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
require_once('databaseHelper.inc');

function doLogin($username,$password)
{
    $dbHelper = new DatabaseHelper(); 


    if(!$dbHelper->connect())
    {	
	return array("returnCode" => '1', 'message'=>"Error connecting to server");
    }


    $info = $dbHelper->getUserInfo($username, $password);
    //return $info;
    $str = implode(" ", $info);
    if($info)
    {	
      logMessage(array("returnCode" => '0', 'message'=>"Login successful for" . " " . $str));
      sessionId($username);
	return (array('returnCode' => '0', 'message' => 'Login successful') + $info);
    }
    
    else
    {
logMessage(array("returnCode" => '1', 'message'=>"Login unsuccessful for" . " " . $str));
	return (array("returnCode" => '1', 'message'=>"Login unsuccessful"));
    }

}

function doRegister($request)
{
    $dbHelper = new DatabaseHelper();
    
    if($dbHelper->registerUser($request['username'], $request['password'], $request['firstname'], $request['lastname'], $request['email']))
    {
      logMessage($info);
	return array("returnCode" => '1', 'message'=>"Registration successful");
    }

    return array("returnCode" => '0', 'message'=>"<br>Registration unsuccessful<br>Username already exist!");
}

function logMessage($request)
{
	$logFile = fopen("log.txt", "a");

	fwrite($logFile, $request['message'] . PHP_EOL);
  fclose($logFile);

	return true;
}

function add2DMZ($request)
{
  $dbHelper = new DatabaseHelper();

  

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
      logMessage($request); 
      return doRegister($request);
    case "login":
      logMessage($request);
      return doLogin($request['username'],$request['password']);
    case "log":
      return logMessage($request);
   case "session";
      logMessage($request);
      return sessionId($request);
    case "add2DMZ";
      logMessage($request);
      return add2DMZ($request);
  }

  return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

$server = new rabbitMQServer("testRabbitMQ.ini","testServer");

$server->process_requests('requestProcessor');
exit();
?>
