<?php
class Users {

	var $dbhost = "HOST";
	var $dbuser = "USER";
	var $dbpassword = "PASSWORD";
	var $dbname = "DBNAME";

	var $mysqli;

	function __construct() {
		$this->mysqli = new mysqli($this->dbhost, $this->dbuser, $this->dbpassword, $this->dbname);

		if (mysqli_connect_errno()) {
			// ERROR DE CONEXION
		}
	}

	public function saveUser($username, $gcmcode){
		$response = array("success" => "0");
		$query  ="INSERT INTO users (username, gcmcode) VALUES ('" . stripslashes($username) . "', '" .
			stripslashes($gcmcode) . "') ON DUPLICATE KEY UPDATE gcmcode = '" . stripslashes($gcmcode)."' ; ";
			$response["success"] = $query;
		$this->mysqli->query($query);

		if($this->mysqli->affected_rows > 0)
			$response["success"] = "1";

		return json_encode($response);
	}

	public function getUser($username){
		$response = array("success" => 0);

		$query = "SELECT username, gcmcode FROM users WHERE username='".stripslashes($username)."';";
			if ($resultado = $this->mysqli->query($query)) {
				if($resultado->num_rows>0)
				{
					return mysqli_fetch_array($resultado);
				}
				$resultado->free();
			}
			return false;
	}
}
?>