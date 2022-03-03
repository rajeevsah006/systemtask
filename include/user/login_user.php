<?php
header('Content-type: application/json');
$response = array();
session_start();
require_once "../class/SystemTask.php";
$systemTask = new SystemTask();
if (isset($_POST['login_button']))
{
	$user_email = strtolower(strip_tags(trim($_POST['user_email'])));
	$user_password = strip_tags(trim($_POST['user_password']));
	$user_array = $systemTask->validateUserName($user_email);
	if (!empty($user_array))
	{
		if ($user_array[0]["user_password"] == hash('sha256', $user_password))
		{
			if ($user_array[0]["user_verified"] == "YES")
			{
				$_SESSION['session_user_sno'] = $user_array[0]["user_sno"];
				$_SESSION['session_user_role'] = $user_array[0]["user_role"];
				$response['status'] = 'success';
				$response['message'] = 'Login sucessfully...';
			}
			else
			{
				$response['status'] = 'error';
				$response['message'] = 'Your account is not verfied yet, Try again...';
			}
		}
		else
		{
			$response['status'] = 'error';
			$response['message'] = 'Wrong password, Try again...';
		}
	}
	else
	{
		$response['status'] = 'error';
		$response['message'] = 'Incorrect Credentials, Try again...';
	}
}
else
{
	$response['status'] = 'error';
	$response['message'] = 'Missing parameters, Try again...';
}
echo json_encode($response);
