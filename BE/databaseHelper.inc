<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');


class DatabaseHelper
{
	private $conn;

// Connect to database, log on error

	public function connect()
	{
		try
		{
		
			$this->conn = new PDO('mysql:host=localhost;dbname=login', 'root', 'punkrockgirl');
			return true;
		}
		catch(PDOException $e)
		{
			$message =  'Error: ' . $e->getMessage();
			$client = new rabbitMQClient("logRabbitMQ.ini","logServer");			
			$request = array();
			$request['type'] = "log";
			$request['message'] = $message;
			$response = $client->publish($request);
		}
		
		return false;
	}
	public function sessionId($username)
	{
		$this->conn = new PDO('mysql:host=localhost;dbname=login', 'root', 'punkrockgirl');
		$stmt->$this->conn->prepare("INSERT INTO SESSION (sessionId, Username, timestamp) VALUES (NULL, :un, localtime()");
		$stmt->bindParam(':un', $username);
		
		$stmt->execute(); 
		// return true; 
	}
	public function __destruct()
	{
		$this->conn = null;
	}
// Grabs Users firstname/lastname from USERS table after verifying the hashed password is correct
	public function getUserInfo($username, $password)
	{
		$database = mysql_connect ('localhost', 'root', 'punkrockgirl');
		mysql_select_db('login');
		$query = ("SELECT Password FROM USERS WHERE Username = '$username'");
		$tw = mysql_query($query);
		
		$t=mysql_fetch_array($tw);
		$hash = $t[0];
		//$hashString = implode("",$hash);
		if(password_verify($password, $hash)) {
			$stmt = $this->conn->prepare('SELECT firstName FROM USERS WHERE Username = :un');
			$stmt->bindParam(':un', $username);
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			$stmt->execute();
		
			$result = $stmt->fetch();
			
			//insert into SESSION
			/*$stmt2 = $this->conn->prepare('INSERT INTO SESSION (SessionID, Username, Time, IPaddress, Valid) VALUES (NULL, :un, NULL, NULL, 1)');
			$stmt2->bindParam(':un', $username);
			
			$//stmt2->bindParam(':ip', '1.1.1.1');

			$stmt2->execute(); */

			
	
			return $result;
		}
		else
		{

			$stmt = $this->conn->prepare('SELECT firstName, lastName FROM USERS WHERE Username = :un AND Password = :pw');
			$stmt->bindParam(':un', $username);
			$stmt->bindParam(':pw', $password);
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			$stmt->execute();
		
			$result = $stmt->fetch();
		
			//insert into SESSION
			/*$stmt2 = $this->conn->prepare('INSERT INTO SESSION (SessionID, Username, Time, IPaddress, Valid) VALUES (NULL, :un, NULL, NULL, 0)');
			$stmt2->bindParam(':un', $username);
			
			//$stmt2->bindParam(':ip', '1.1.1.1');
		
			$stmt2->execute(); */
			

			return false;			
		}
		
	}
	

	public function registerUser($username, $password, $firstname, $lastname, $email)
	{

		$database = mysql_connect ('localhost', 'root', 'punkrockgirl');
		mysql_select_db('login');
		$query = ("SELECT * FROM USERS where Username = '$username'");
		$t = mysql_query($query);
		if(mysql_num_rows($t) > 0)
		{
			echo "Username already exists";
			return false;
		}
 		else
		{
			
			$this->conn = new PDO('mysql:host=localhost;dbname=login', 'root', 'punkrockgirl');
			$stmt = $this->conn->prepare("INSERT INTO USERS (UserID, Username, Password, RoleID, firstName, lastName) VALUES (NULL, :un, :pw, 1, :fname, :lname)");
			$stmt->bindParam(':un', $username);
			$stmt->bindParam(':pw', $password);
			$stmt->bindParam(':fname', $firstname);
			$stmt->bindParam(':lname', $lastname);
			//$stmt->bindParam(':em', $email);

			return $stmt->execute();
			return true;
		}
	}

	public function addDMZ($name, $price, $description)
	{
		$this->conn = new PDO('mysql:host=localhost;dbname=DMZ', 'root', 'punkrockgirl');
		$stmt = $this->conn->prepare("INSERT INTO output (ID, name, price, description) VALUES (NULL, :name, :price, :dsc)");
		$stmt->bindParam(':name', $username);
		$stmt->bindParam(':price', $password);
		$stmt->bindParam(':dsc', $firstname);
		

		return $stmt->execute();
		return true;
	}
	
	
}
$client = new rabbitMQClient("testRabbitMQ.ini","testServer");

class Deployment
{

	public function Deploy(packageName, targetServer)
	{


	}
	
}
?>
