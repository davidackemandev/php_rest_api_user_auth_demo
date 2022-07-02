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

require "../config/db_inc.php";
require './account_class.php';

$account = new Account();
$login = FALSE;

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
	$response = array('email' => $account->getEmail());
	echo json_encode($response);
}
else
{
	header('HTTP/1.1 500 Internal Server Error');
	echo 'Authentication failed.';
	die();
}

session_destroy();