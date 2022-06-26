<?php
if (isset($_SERVER['HTTP_ORIGIN'])) {
header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
}
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: POST');
header("Access-Control-Allow-Headers: X-Requested-With");

$postbody = json_decode(file_get_contents('php://input'), true);
$postemail = $postbody["email"];
$postpw = $postbody["password"];

require "./db_inc.php";
require './account_class.php';

$account = new Account();
$login = FALSE;

session_set_cookie_params(['samesite' => 'None']);
session_start();

// try login with session cookie
try
{	
	$login = $account->sessionLogin();
}
catch (Exception $e)
{
	echo 'bad cookie';
	die();
}

// try login with username and password
if(!$login){
try
{
	$login = $account->login($postemail, $postpw);
}
catch (Exception $e)
{
	echo $e->getMessage();
	die();
}
}

// response
if ($login)
{
	$response = array('email' => $account->getEmail(), 'notes' =>$account->getNotes());
	echo json_encode($response);
}
else
{
	echo 'Authentication failed.';
}

session_destroy();