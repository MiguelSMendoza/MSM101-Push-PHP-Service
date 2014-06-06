<?php
class gcm {


	function __construct() {

	}

	function sendMessageToPhone($messageText, $username)
	{
		include_once 'Users.php';
		$response = array("success" => "0", "message" => "");
		$user = new Users();
		$data = $user->getUser($username);
		if($data != false){

			$apiKey = 'API_KEY';

			$userIdentificador = $data["gcmcode"];

			$headers = array('Authorization:key=' . $apiKey ,
						'Content-Type:application/json');
			$data = array(
				'registration_ids' => array ($userIdentificador),
				'data' => array( "message" => $messageText, "server" => 'NetRunners' ));

			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL, "https://android.googleapis.com/gcm/send");
			if ($headers)
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

			$resp = curl_exec($ch);
			$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if (curl_errno($ch)) {
				$response["message"] = "Connection Failed";
			}
			if ($httpCode != 200) {
				$response["message"] = $resp;
			}
			curl_close($ch);
			$response["success"] = 1;
		} 
		
		return json_encode($response);
	}
}

?>