<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

 function DeployBE($request)
	{
		 echo "\nInstalling BE"
		 shell_exec('sh backendInstall.sh')
		 echo "\nBE was installed"
 
	}
	public function processor($request)
	{
		echo "request complete".PHP_EOL;
  		var_dump($request);
 		echo '\n' . 'End Message';
  		if(!isset($request['type']))
  		{
    		return "ERROR: unsupported message type";
  		}
  		switch ($request['type'])
  		{
    		case "BEQA":   
      			return deployBE($request);	
		}
}

$server = new rabbitMQServer("deployRabbitMQ.ini","BEQA");
$server->process_requests('processor');

exit();


?>
