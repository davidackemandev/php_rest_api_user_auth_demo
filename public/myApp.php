<?php

session_start();

/* Include the database connection file (remember to change the connection parameters) */
require '../config/db_inc.php';

/* Include the Account class file */
require './account_class.php';

/* Create a new Account object */
$account = new Account();



/*	Uncomment the following code blocks, one at a time, to test different Account operations. */


// 1. Insert a new account

try
{
	$newId = $account->addAccount('myUserName', 'myPassword');
}
catch (Exception $e)
{
	echo $e->getMessage();
	die();
}

echo 'The new account ID is ' . $newId;


// 2. Edit an account. Try passing invalid parameters to test error messages.

$accountId = 1;

try
{
	$account->editAccount($accountId, 'myNewName', 'new password', TRUE);
}
catch (Exception $e)
{
	echo $e->getMessage();
	die();
}

echo 'Account edit successful.';


// 3. Delete an account.

$accountId = 1;

try
{
	$account->deleteAccount($accountId);
}
catch (Exception $e)
{
	echo $e->getMessage();
	die();
}

echo 'Account delete successful.';


// 4. Login with email and password.

$login = FALSE;

try
{
	$login = $account->login('myEmail', 'myPassword');
}
catch (Exception $e)
{
	echo $e->getMessage();
	die();
}

if ($login)
{
	echo 'Authentication successful.';
	echo 'Account ID: ' . $account->getId() . '<br>';
	echo 'Account name: ' . $account->getName() . '<br>';
}
else
{
	echo 'Authentication failed.';
}


// 5. Session login

$login = FALSE;

try
{
	$login = $account->sessionLogin();
}
catch (Exception $e)
{
	echo $e->getMessage();
	die();
}

if ($login)
{
	echo 'Authentication successful.';
	echo 'Account ID: ' . $account->getId() . '<br>';
	echo 'Account name: ' . $account->getName() . '<br>';
}
else
{
	echo 'Authentication failed.';
}


// 6. Logout.

try
{
	$login = $account->login('myUserName', 'myPassword');
	
	if ($login)
	{
		echo 'Authentication successful.';
		echo 'Account ID: ' . $account->getId() . '<br>';
		echo 'Account name: ' . $account->getName() . '<br>';
	}
	else
	{
		echo 'Authentication failed.<br>';
	}
	
	$account->logout();
	
	$login = $account->sessionLogin();
	
	if ($login)
	{
		echo 'Authentication successful.';
		echo 'Account ID: ' . $account->getId() . '<br>';
		echo 'Account name: ' . $account->getName() . '<br>';
	}
	else
	{
		echo 'Authentication failed.<br>';
	}
}
catch (Exception $e)
{
	echo $e->getMessage();
	die();
}

echo 'Logout successful.';


// 7. Close other open Sessions (if any).
/*
try
{
	$login = $account->login('myUserName', 'myPassword');
	
	if ($login)
	{
		echo 'Authentication successful.';
		echo 'Account ID: ' . $account->getId() . '<br>';
		echo 'Account name: ' . $account->getName() . '<br>';
	}
	else
	{
		echo 'Authentication failed.<br>';
	}
	
	$account->closeOtherSessions();
}
catch (Exception $e)
{
	echo $e->getMessage();
	die();
}

echo 'Sessions closed successfully.';
*/
