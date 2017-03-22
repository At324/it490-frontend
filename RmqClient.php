#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

class RmqClient(){

	private $client;

	function __construct(){
		$this->client = new rabbitMQClient("testRabbitMQ.ini","testServer");
	}

	//login
	function sendLogin($username, $password){
		$request = array();
		$request['type'] = "login";
		$request['username'] = $username;
		$request['password'] = $password;
		$response = $client->send_request($request);

		//if response["returncode"] => '1' echo message
		//else start a session, log session datetime, and set session variables to user info by username
		if($response["returncode"] => '1'){
			sendLog($response["message"]);
			print_r($response["message"] . PHP_EOL);
		} else {
			session_start();
			sendSession($username);
			$_SESSION["username"] = $username;
			$_SESSION["firstname"] = $response["firstname"]; //check if column name is that
			$_SESSION["lastname"] = $response["lastname"];
			//TODO: redirect to profile
		}
	}

	//register
	function sendRegister($username, $password, $firstname, $lastname, $email){
		request = array();
		$request['type'] = "register";
		$request['username'] = $username;
		$request['password'] = $password;
		$request['firstname'] = $firstname;
		$request['lastname'] = $lastname;
		$request['email'] = $email;
		$response = $client->send_request($request);

		print_r($response["message"]);
		//TODO: redirect to login
	}

	//if login is successful, log datetime into SESSION
	function sendSession($username){
		request = array();
		$request['type'] = "session";
		$request['username'] = $username;
		$response = $client->send_request($request);
	}

	/**
	@ALL MESSAGES TO BE APPENDED TO LOG.TXT
	*/

	function sendLog($msg){
		request = array();
		$request['type'] = "log";
		$request['message'] = $msg;
		$response = $client->send_request($request);
	}
	/*echo "client received response: ".PHP_EOL;
	print_r($response);
	echo "\n\n";

	echo $argv[0]." END".PHP_EOL;*/
}
?>