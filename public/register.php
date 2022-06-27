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

if (!isset($postemail) || !isset($postpw) ) { exit("bad postdata"); }

require "../config/db_inc.php";
require './account_class.php';

$account = new Account();

// Create the new account
try
{
	$newId = $account->addAccount($postemail, $postpw);
}
catch (Exception $e)
{
	echo $e->getMessage();
	die();
}

// login the new account
session_start();

$login = FALSE;

try
{
	$login = $account->login($postemail, $postpw);
}
catch (Exception $e)
{
	echo $e->getMessage();
	die();
}

if ($login)
{
	$response = array('email' => $account->getEmail());
	echo json_encode($response);
}
else
{
	echo 'Authentication failed.';
}

session_destroy();
