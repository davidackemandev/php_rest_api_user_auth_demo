<?php
if (isset($_SERVER['HTTP_ORIGIN'])) {
	header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
	}
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: POST');
header("Access-Control-Allow-Headers: X-Requested-With");

$postbody = json_decode(file_get_contents('php://input'), true);
$postnotes = $postbody["notes"];

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

// return the notes
// response
if ($login)
{

$accountid = $account->getId();

try
{
	$updated = $account->updateNotes($accountid, $postnotes);
}
catch (Exception $e)
{
	echo 'update failed';
	die();
}
}
else
{
	echo 'Authentication failed.';
}
$response = array('email' => $account->getEmail(), 'notes' =>$account->getNotes());
echo json_encode($response);

session_destroy();



