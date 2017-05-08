<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');


class deploy
{
	private $conn;
	public function connect()
	{
		try
		{
			$this->conn = new PDO('mysql:host=localhost;dbname=deploy', 'root', 'punkrockgirl');
			return true;
		}
		catch(PDOException $e)
		{
			$message =  'Error: ' . $e->getMessage();
						
			$client = new rabbitMQClient("testRabbitMQ.ini","testServer");      
			$request = array();
			$request['type'] = "log";
			$request['message'] = $message;
			$response = $client->publish($request);
		}
		
		return false;
	}

	public function nextPackage($package)
	{
		$stmt = $this->conn->prepare("SELECT * FROM PACKAGE WHERE name LIKE '$package%' ORDER BY version DESC");
		$stmt->bindParam(':name', $package);
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$stmt->execute();
		$version = $stmt->fetch()['version'];
			return $version+1;
	}
	
	public function update($name, $version)
	{
		$stmt = $this->conn->prepare('INSERT INTO packages (name, version) VALUES (:pn, :vn)');
		$stmt->bindParam(':pn', $name);
		$stmt->bindParam(':vn', $version);
		$stmt->execute();
			return true;
	}
	public function __destruct()
	{
		$this->conn = null;
	}
}

?>
