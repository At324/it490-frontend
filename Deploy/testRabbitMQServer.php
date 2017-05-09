#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
require_once('deploy.inc');

function logMessage($request)
{
	$logFile = fopen("log.txt", "a");
	fwrite($logFile, $request['message'] .'\n\n');
		return true;
}
      	
function nextPackage($request)
{
	$db = new deploy();
	$db->connect();
	$r = $db->nextPackage($request['name']);
   	return $r;	
}

function update($request)
{
	$db = new deploy();
        $db->connect();
        $r = $db->update($request['name'], $request['version']);
        return $r;
}

function deployNew($request)
{
	
	$json = file_get_contents('./ips.json');
	$decodedJson = json_decode($json, true);

	$targetMachine = ($decodedJson[$request['package']][$request['level']] );
	$targetIp = $targetMachine['ip'];

	$db = new deploy();
	$db->connect();
	$version = $db->nextPackage($request['name']);
	$version -= 1;
	$package = $request['name'] . $version;

	$scpPackage = 'scp -r /home/Sean/Packages/' . $package . '.tar.gz ' . $targetMachine['username'] . '@' . $targetIp . ':/home/' . $targetMachine['username'] . '/temp';
	
	shell_exec($scpPackage);
	

	if(($request['package'] == 'BE') && ($request['level']  == 'QA')){
		            $exchange = "BEQA";
  }
	elseif(($request['package'] == 'BE') && ($request['level']  == 'Prod')){
                $exchange = "BEProd";
  }
	elseif(($request['package'] == 'FE') && ($request['level']  == 'QA')){
                $exchange = "FEQA";
  }
	elseif(($request['package'] == 'FE') && ($request['level']  == 'Prod')){
                $exchange = "FEProd";
  }
	elseif(($request['package'] == 'DMZ') && ($request['level']  == 'QA')){
                $exchange = "DMZQA";
  }
  elseif(($request['package'] == 'DMZ') && ($request['level']  == 'Prod')){
                $exchange = "DMZProd";	
  }

	
	else{
		$exchange = "deployServer";
  }

	$client = new rabbitMQClient("deployRabbitMQServer.ini", $exchange);
	$deployReq = array();
	$deployReq['type'] = $request['package'] . $request['level'];
	$deployReq['version'] = $version;
	$deployReq['name'] = $request['name'];
	$deployReq['tar'] = $request['name'] . $version . ".tar.gz";

	$client->publish($deployReq);	


  
}

function rollback($request)
{

	$json = file_get_contents('./ips.json');
        $decodedJson = json_decode($json, true);

        $targetMachine = ($decodedJson[$request['package']][$request['level']] );
        $targetIp = $targetMachine['ip'];

        $db = new deploy();
        $db->connect();
        $version = $db->nextPackage($request['name']);
        $version = $version - 2;
        $package = $request['name'] . $version;
        
        $scpPackage = 'scp -r /home/Sean/Packages/' . $package . '.tar.gz ' . $targetMachine['username'] . '@' . $targetIp . ':/home/' . $targetMachine['username'] . '/temp';
	shell_exec($scpPackage);
	
	$client = new rabbitMQClient("deployRabbitServer.ini","deployServer");
        $rollbackRequest = array();
        $rollbackRequest['type'] = 'deploy';
        $rollbackRequest['version'] = $version;
        $rollbackRequest['name'] = $request['name'];
        $rollbackRequest['tar'] = $request['name'] . $version . ".tar.gz";

        $client->publish($rollbackRequest);

}


function processor($request)
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
    case "log":
      return logMessage($request);
    case "deploy":
      return deployNew($request);
    case "nextPackage":
      return nextPackage($request);
    case "update":
      return update($request);
    case "rollback":
      return rollback($request);	
  }
  return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

$server = new rabbitMQServer("deployRabbitMQServer.ini","deployServer");

$server->process_requests('processor');
exit();
?>
