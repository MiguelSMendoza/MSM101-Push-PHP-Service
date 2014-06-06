<?php
include_once 'Users.php';
include_once 'gcm.php';
$tag = $_POST['tag'];

switch ($tag){
case 'usersave':
	$username = "";
	$gcmcode = "";
	if(isset($_POST['username']))
		$username = $_POST['username'];
	if(isset($_POST['gcmcode']))
		$gcmcode = $_POST['gcmcode'];

	$user = new Users();
	echo $user->saveUser($username, $gcmcode);
	break;
case 'sendmessage':
	$username = "";
	$message = "";
	$collapseKey = "";
	if(isset($_POST['message']))
		$messageText = $_POST['message'];
	if(isset($_POST['username']))
		$username = $_POST['username'];
	$message = new gcm();
	echo $message->sendMessageToPhone($messageText, $username);
	break;
default:
	$response = array("success" => "0", "err" => "no tag");
	echo json_encode($response);
	break;
}
?>